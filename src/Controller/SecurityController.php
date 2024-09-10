<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * Handles user authentication, including login and logout functionalities.
 */
class SecurityController extends AbstractController
{
	/**
	 * Displays the login page and handles authentication errors.
	 *
	 * @param AuthenticationUtils $authenticationUtils The authentication utility service.
	 * @return Response The rendered login view.
	 */
	#[Route(path: '/login', name: 'app_login')]
	public function login(AuthenticationUtils $authenticationUtils): Response
	{
		 // Uncomment the following lines if you want to redirect authenticated users away from the login page.
		 if ($this->getUser()) {
		     return $this->redirectToRoute('message_list'); // Change 'target_path' to your desired route.
		 }

		// Get the last authentication error, if there is one.
		$error = $authenticationUtils->getLastAuthenticationError();

		// Get the last username entered by the user.
		$lastUsername = $authenticationUtils->getLastUsername();

		// Render the login template with the last username and any authentication error.
		return $this->render('security/login.html.twig', [
			'last_username' => $lastUsername,
			'error' => $error,
		]);
	}

	/**
	 * Handles user logout.
	 *
	 * This method can be left blank; it will be intercepted by the logout key on your firewall.
	 *
	 * @throws \LogicException This exception is thrown to indicate the method should not be called directly.
	 */
	#[Route(path: '/logout', name: 'app_logout')]
	public function logout(): void
	{
		// This method can be blank - it will be intercepted by the logout key on your firewall.
		throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
	}
}