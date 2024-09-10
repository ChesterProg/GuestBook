<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

/**
 * Class ResetPasswordController
 * Handles password reset functionality including requesting a reset, validating tokens, and changing passwords.
 */
#[Route('/reset-password')]
class ResetPasswordController extends AbstractController
{
	use ResetPasswordControllerTrait;

	public function __construct(
		private ResetPasswordHelperInterface $resetPasswordHelper,
		private EntityManagerInterface $entityManager
	) {
	}

	/**
	 * Display & process form to request a password reset.
	 */
	#[Route('', name: 'app_forgot_password_request')]
	public function request(Request $request, MailerInterface $mailer): Response
	{
		// Create the password reset request form
		$form = $this->createForm(ResetPasswordRequestFormType::class);
		$form->handleRequest($request); // Handle the form submission

		// Check if the form is submitted and valid
		if ($form->isSubmitted() && $form->isValid()) {
			return $this->processSendingPasswordResetEmail(
				$form->get('email')->getData(),
				$mailer
			);
		}

		// Render the password reset request form
		return $this->render('reset_password/request.html.twig', [
			'requestForm' => $form->createView(),
		]);
	}

	/**
	 * Confirmation page after a user has requested a password reset.
	 */
	#[Route('/check-email', name: 'app_check_email')]
	public function checkEmail(): Response
	{
		// Generate a fake token if the user does not exist or someone hit this page directly
		// This prevents exposing whether or not a user was found with the given email address
		if (null === ($resetToken = $this->getTokenObjectFromSession())) {
			$resetToken = $this->resetPasswordHelper->generateFakeResetToken();
		}

		// Render the email check confirmation page
		return $this->render('reset_password/check_email.html.twig', [
			'resetToken' => $resetToken,
		]);
	}

	/**
	 * Validates and processes the reset URL that the user clicked in their email.
	 */
	#[Route('/reset/{token}', name: 'app_reset_password')]
	public function reset(Request $request, UserPasswordHasherInterface $passwordHasher, string $token = null): Response
	{
		// If a token is passed in the URL, store it in the session and redirect
		if ($token) {
			$this->storeTokenInSession($token);
			return $this->redirectToRoute('app_reset_password');
		}

		// Retrieve the token from the session
		$token = $this->getTokenFromSession();
		if (null === $token) {
			throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
		}

		// Validate the token and fetch the user
		try {
			$user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
		} catch (ResetPasswordExceptionInterface $e) {
			$this->addFlash('reset_password_error', sprintf(
				'%s - %s',
				ResetPasswordExceptionInterface::MESSAGE_PROBLEM_VALIDATE,
				$e->getReason()
			));
			return $this->redirectToRoute('app_forgot_password_request');
		}

		// The token is valid; allow the user to change their password
		$form = $this->createForm(ChangePasswordFormType::class);
		$form->handleRequest($request); // Handle the form submission

		// Check if the form is submitted and valid
		if ($form->isSubmitted() && $form->isValid()) {
			// A password reset token should be used only once, remove it
			$this->resetPasswordHelper->removeResetRequest($token);

			// Encode (hash) the plain password, and set it
			$encodedPassword = $passwordHasher->hashPassword(
				$user,
				$form->get('plainPassword')->getData()
			);
			$user->setPassword($encodedPassword);
			$this->entityManager->flush();

			// Clean up the session after the password has been changed
			$this->cleanSessionAfterReset();

			// Redirect to the main page after successful password reset
			return $this->redirectToRoute('message_list');
		}

		// Render the password reset form
		return $this->render('reset_password/reset.html.twig', [
			'resetForm' => $form->createView(),
		]);
	}

	/**
	 * Processes sending the password reset email.
	 *
	 * @param string $emailFormData The email address from the form.
	 * @param MailerInterface $mailer The mailer service.
	 *
	 * @return RedirectResponse The redirect response to the check email route.
	 * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
*/
	private function processSendingPasswordResetEmail(string $emailFormData, MailerInterface $mailer): RedirectResponse
	{
		// Find the user by email
		$user = $this->entityManager->getRepository(User::class)->findOneBy([
			'email' => $emailFormData,
		]);

		// Do not reveal whether a user account was found or not
		if (!$user) {
			return $this->redirectToRoute('app_check_email');
		}

		// Generate a reset token for the user
		try {
			$resetToken = $this->resetPasswordHelper->generateResetToken($user);
		} catch (ResetPasswordExceptionInterface $e) {
			return $this->redirectToRoute('app_check_email');
		}

		// Create and send the password reset email
		$email = (new TemplatedEmail())
			->from(new Address('guest@book.ua', 'Guest Book')) // Change email as needed
			->to($user->getEmail())
			->subject('Your password reset request')
			->htmlTemplate('reset_password/email.html.twig')
			->context([
				'resetToken' => $resetToken,
			]);

		$mailer->send($email);

		// Store the token object in session for retrieval in check-email route
		$this->setTokenObjectInSession($resetToken);

		return $this->redirectToRoute('app_check_email');
	}
}