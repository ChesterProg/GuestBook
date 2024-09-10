<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

/**
 * EmailVerifier class
 *
 * This class is responsible for sending email verification links to users
 * and handling email confirmation requests.
 */
class EmailVerifier
{
	/**
	 * Constructor.
	 *
	 * @param VerifyEmailHelperInterface $verifyEmailHelper The helper for generating email verification signatures
	 * @param MailerInterface $mailer The mailer service for sending emails
	 * @param EntityManagerInterface $entityManager The entity manager for persisting user data
	 */
	public function __construct(
		private VerifyEmailHelperInterface $verifyEmailHelper,
		private MailerInterface $mailer,
		private EntityManagerInterface $entityManager
	) {
	}

	/**
	 * Sends an email confirmation to the user with a signed verification link.
	 *
	 * @param string $verifyEmailRouteName The route name for email verification
	 * @param UserInterface $user The user to whom the email is sent
	 * @param TemplatedEmail $email The email template to be sent
	 */
	public function sendEmailConfirmation(string $verifyEmailRouteName, UserInterface $user, TemplatedEmail $email): void
	{
		// Generate the signature components for the verification link
		$signatureComponents = $this->verifyEmailHelper->generateSignature(
			$verifyEmailRouteName,
			$user->getId(),
			$user->getEmail()
		);

		// Prepare the email context with the signed URL and expiration messages
		$context = $email->getContext();
		$context['signedUrl'] = $signatureComponents->getSignedUrl();
		$context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
		$context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();
		$email->context($context);

		// Send the email
		$this->mailer->send($email);
	}

	/**
	 * Handles the email confirmation request from the user.
	 *
	 * Validates the confirmation request and marks the user as verified.
	 *
	 * @param Request $request The request containing the confirmation URI
	 * @param UserInterface $user The user whose email is being confirmed
	 * @throws VerifyEmailExceptionInterface If the verification fails
	 */
	public function handleEmailConfirmation(Request $request, UserInterface $user): void
	{
		// Validate the email confirmation request
		$this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());

		// Mark the user as verified
		$user->setIsVerified(true);

		// Persist the changes to the database
		$this->entityManager->persist($user);
		$this->entityManager->flush();
	}
}