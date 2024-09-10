<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

/**
 * Class RegistrationController
 * Handles user registration logic.
 */
class RegistrationController extends AbstractController
{
	/**
	 *
	 * This method handles the registration of new users.
	 *
	 * @param Request $request The HTTP request object.
	 * @param UserPasswordHasherInterface $userPasswordHasher The service for hashing user passwords.
	 * @param UserAuthenticatorInterface $userAuthenticator The service for authenticating users.
	 * @param LoginFormAuthenticator $authenticator The login form authenticator.
	 * @param EntityManagerInterface $entityManager The entity manager for database operations.
	 * @return Response The rendered response for the registration page or a redirect to the main page after successful registration.
	 */
	#[Route('/register', name: 'app_register')]
	public function register(
		Request $request,
		UserPasswordHasherInterface $userPasswordHasher,
		UserAuthenticatorInterface $userAuthenticator,
		LoginFormAuthenticator $authenticator,
		EntityManagerInterface $entityManager
	): Response {
		// Create a new User entity.
		$user = new User();

		// Create the registration form.
		$form = $this->createForm(RegistrationFormType::class, $user);
		$form->handleRequest($request);

		// Check if the form is submitted and valid.
		if ($form->isSubmitted() && $form->isValid()) {
			// Hash the plain password and set it on the user entity.
			$user->setPassword(
				$userPasswordHasher->hashPassword(
					$user,
					$form->get('plainPassword')->getData()
				)
			);

			// Persist the new user entity to the database.
			$entityManager->persist($user);
			$entityManager->flush();

			// Authenticate the user and redirect to the main page.
			$userAuthenticator->authenticateUser(
				$user,
				$authenticator,
				$request
			);

			// Redirect to the main page after successful registration
			return $this->redirectToRoute('message_list'); // Adjust 'message_list' to your main page route
		}

		// Render the registration form view if not submitted or invalid
		return $this->render('registration/register.html.twig', [
			'registrationForm' => $form->createView(),
		]);
	}
}