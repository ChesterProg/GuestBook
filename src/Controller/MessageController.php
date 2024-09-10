<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageFormType;
use App\Service\HtmlPurifierService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MessageController
 * This controller handles the CRUD operations for messages.
 */
class MessageController extends AbstractController
{
	private HtmlPurifierService $purifier;

	// Constructor to inject the HTML purifier service.
	public function __construct(HtmlPurifierService $purifier)
	{
		$this->purifier = $purifier;
	}

	/**
	 * Lists all messages with pagination and sorting.
	 *
	 * @param Request $request The HTTP request object.
	 * @param EntityManagerInterface $entityManager The entity manager for database operations.
	 * @return Response The rendered response with the message list.
	 */
	#[Route('/', name: 'message_list')]
	public function list(Request $request, EntityManagerInterface $entityManager): Response
	{

		// Get sorting parameters
		$sortField = $request->query->get('sort', 'created_at');
		$sortOrder = $request->query->get('order', 'DESC');

		// Pagination setup
		$queryBuilder = $entityManager->getRepository(Message::class)->createQueryBuilder('m')
			->where('m.status = :status')
			->setParameter('status', true)
			->orderBy('m.' . $sortField, $sortOrder);

		$pagerfanta = new Pagerfanta(new QueryAdapter($queryBuilder));
		$pagerfanta->setMaxPerPage(25); // Set number of messages per page.
		$currentPage = $request->query->getInt('page', 1);
		$pagerfanta->setCurrentPage($currentPage);

		return $this->render('message/message-list.html.twig', [
			'messages' => $pagerfanta->getCurrentPageResults(),
			'pager' => $pagerfanta, // Pass the pager object to the template.
			'sortField' => $sortField,
			'sortOrder' => $sortOrder,
		]);
	}

	/**
	 * Handles the addition of a new message.
	 *
	 * @param Request $request The HTTP request object.
	 * @param EntityManagerInterface $entityManager The entity manager for database operations.
	 * @return Response The rendered response for adding a message.
	 */
	#[Route('/messages/add', name: 'message_new')]
	public function addMessage(Request $request, EntityManagerInterface $entityManager): Response
	{
		$message = new Message();
		$isAdmin = $this->isGranted('ROLE_ADMIN');

		// Create the form for adding a new message
		$form = $this->createForm(MessageFormType::class, $message, [
			'user_id' => $this->getUser() ? $this->getUser()->getId() : 0,
			'is_admin' => $isAdmin,
		]);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->handleFormSubmission($form, $message, $request, false);

			// Persist the message to the database.
			$entityManager->persist($message);
			$entityManager->flush();

			// Set a flash message to inform the user.
			$this->addFlash('success', 'Your message has been submitted for moderation and will appear once approved.');

			// Redirect after successful addition.
			return $this->redirectToRoute('message_list');
		}

		return $this->render('message/add-message.html.twig', [
			'form' => $form->createView(),
		]);
	}

	/**
	 * Handles the editing of an existing message.
	 *
	 * @param Request $request The HTTP request object.
	 * @param Message $message The message entity to edit.
	 * @param EntityManagerInterface $entityManager The entity manager for database operations.
	 * @return Response The rendered response for editing a message.
	 */
	#[Route('/messages/{id}/edit', name: 'message_edit')]
	public function editMessage(Request $request, Message $message, EntityManagerInterface $entityManager): Response
	{
		// Check if the user is an admin.
		$isAdmin = $this->isGranted('ROLE_ADMIN');

		$form = $this->createForm(MessageFormType::class, $message, [
			'user_id' => $this->getUser() ? $this->getUser()->getId() : 0,
			'is_edit' => true,
			'is_admin' => $isAdmin,
		]);

		$form->handleRequest($request);
		$this->checkEditPermissions($message);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->handleFormSubmission($form, $message, $request, true);

			// Update the message in the database
			$entityManager->flush();
			return $this->redirectToRoute('message_list');
		}

		return $this->render('message/edit-message.html.twig', [
			'form' => $form->createView(),
			'message' => $message,
		]);
	}

	/**
	 * Handles the deletion of a message.
	 *
	 * @param Message $message The message entity to delete.
	 * @param EntityManagerInterface $entityManager The entity manager for database operations.
	 * @return Response The redirect response after deletion.
	 */
	#[Route('/messages/{id}/delete', name: 'message_delete')]
	public function delete(Message $message, EntityManagerInterface $entityManager): Response
	{
		$this->checkDeletePermissions($message);

		$entityManager->remove($message);
		$entityManager->flush();

		return $this->redirectToRoute('message_list');
	}

	/**
	 * Handles form submission for messages.
	 *
	 * @param Message $message The message entity.
	 * @param Request $request The HTTP request object.
	 * @param bool $isEdit Indicates if this is an edit operation.
	 */
	private function handleFormSubmission($form, Message $message, Request $request, bool $isEdit = false): void
	{
		// Handle status from form
		$status = $form->has('status') ? $form->get('status')->getData() : false;
		$message->setStatus($status);

		// Set created timestamps
		$now = new DateTime();
		$message->setCreatedAt($now);

		// Record IP and user agent
		$message->setUserAgent($request->headers->get('User-Agent'));

		// Handle image upload
		if (!$isEdit) {
			$this->handleImageUpload($form, $message);
		}

		// Sanitize input to allow only specific HTML tags
		$cleanText = $this->purifier->purify($message->getText());
		$message->setText($cleanText);
	}

	/**
	 * Handles image upload for messages.
	 *
	 * @param Message $message The message entity.
	 */
	private function handleImageUpload($form, Message $message): void
	{
		/** @var UploadedFile $file */
		$file = $form->get('image_path')->getData();
		if ($file instanceof UploadedFile) {
			$newFilename = uniqid('', true) . '.' . $file->guessExtension();
			$file->move($this->getParameter('images_directory'), $newFilename);
			$message->setImagePath('/uploads/images/' . $newFilename);
		}
	}

	/**
	 * Checks if the current user has permission to edit a message.
	 *
	 * @param Message $message The message entity.
	 * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException if the user does not have permission.
	 */
	private function checkEditPermissions(Message $message): void
	{
		$currentUserId = $this->getUser() ? $this->getUser()->getId() : null;
		$isAdmin = $this->isGranted('ROLE_ADMIN');
		$userIdFromMessage = $message->getUserId();

		// Check if the user is an admin or the owner of the message
		if (!$isAdmin && $currentUserId !== $userIdFromMessage) {
			throw $this->createAccessDeniedException('You do not have permission to edit this message.');
		}
	}

	/**
	 * Checks if the current user has permission to delete a message.
	 *
	 * @param Message $message The message entity.
	 * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException if the user does not have permission.
	 */
	private function checkDeletePermissions(Message $message): void
	{
		$currentUserId = $this->getUser() ? $this->getUser()->getId() : null;
		$isAdmin = $this->isGranted('ROLE_ADMIN');
		$userIdFromMessage = $message->getUserId();

		// Check if the user is an admin or the owner of the message
		if (!$isAdmin && $currentUserId !== $userIdFromMessage) {
			throw $this->createAccessDeniedException('You do not have permission to delete this message.');
		}
	}
}