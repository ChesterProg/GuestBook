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

class RegistrationController extends AbstractController
{
	#[Route('/register', name: 'app_register')]
	public function register(
		Request $request,
		UserPasswordHasherInterface $userPasswordHasher,
		UserAuthenticatorInterface $userAuthenticator,
		LoginFormAuthenticator $authenticator,
		EntityManagerInterface $entityManager
	): Response {
		$user = new User();
		$form = $this->createForm(RegistrationFormType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			// Encode the plain password
			$user->setPassword(
				$userPasswordHasher->hashPassword(
					$user,
					$form->get('plainPassword')->getData()
				)
			);

			$entityManager->persist($user);
			$entityManager->flush();

			// Authenticate the user and redirect to the main page
			$userAuthenticator->authenticateUser(
				$user,
				$authenticator,
				$request
			);

			// Redirect to the main page after successful registration
			return $this->redirectToRoute('message_list'); // Adjust 'message_list' to your main page route
		}

		return $this->render('registration/register.html.twig', [
			'registrationForm' => $form->createView(),
		]);
	}
}