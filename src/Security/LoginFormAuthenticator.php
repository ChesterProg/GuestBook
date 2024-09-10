<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * LoginFormAuthenticator class
 *
 * This class handles the authentication process for users logging in via a form.
 * It extends AbstractLoginFormAuthenticator to leverage Symfony's security features.
 */
class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
	use TargetPathTrait;

	// Define the route name for the login page
	public const LOGIN_ROUTE = 'app_login';

	/**
	 * Constructor.
	 *
	 * @param UrlGeneratorInterface $urlGenerator The URL generator for creating redirect URLs
	 */
	public function __construct(private UrlGeneratorInterface $urlGenerator)
	{
	}

	/**
	 * Authenticates the user based on the provided request.
	 *
	 * @param Request $request The incoming request containing login credentials
	 * @return Passport The Passport object containing user credentials and badges
	 */
	public function authenticate(Request $request): Passport
	{
		// Retrieve the email and store it in the session for the last username
		$email = $request->request->get('email', '');
		$request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

		// Create and return a new Passport object for authentication
		return new Passport(
			new UserBadge($email), // UserBadge for identifying the user
			new PasswordCredentials($request->request->get('password', '')), // Password credentials
			[
				new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')), // CSRF token for security
				new RememberMeBadge(), // Remember me functionality
			]
		);
	}

	/**
	 * Handles successful authentication.
	 *
	 * @param Request $request The incoming request
	 * @param TokenInterface $token The authenticated user token
	 * @param string $firewallName The name of the firewall used for authentication
	 * @return Response|null A RedirectResponse to the target path or null
	 */
	public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
	{
		// Redirect to the target path if available
		if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
			return new RedirectResponse($targetPath);
		}

		// Default redirect to the homepage or a specific route
		return new RedirectResponse('/');
	}

	/**
	 * Returns the login URL for the application.
	 *
	 * @param Request $request The incoming request
	 * @return string The URL for the login page
	 */
	protected function getLoginUrl(Request $request): string
	{
		return $this->urlGenerator->generate(self::LOGIN_ROUTE);
	}
}