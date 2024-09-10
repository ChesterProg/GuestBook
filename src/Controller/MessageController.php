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

class MessageController extends AbstractController
{
	private HtmlPurifierService $purifier;

	public function __construct(HtmlPurifierService $purifier)
	{
		$this->purifier = $purifier;
	}

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
		$pagerfanta->setMaxPerPage(5); // Set number of messages per page.
		$currentPage = $request->query->getInt('page', 1);
		$pagerfanta->setCurrentPage($currentPage);

		return $this->render('message/message-list.html.twig', [
			'messages' => $pagerfanta->getCurrentPageResults(),
			'pager' => $pagerfanta, // Pass the pager object to the template.
			'sortField' => $sortField,
			'sortOrder' => $sortOrder,
		]);
	}

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

	#[Route('/messages/{id}/delete', name: 'message_delete')]
	public function delete(Message $message, EntityManagerInterface $entityManager): Response
	{
		$this->checkDeletePermissions($message);

		$entityManager->remove($message);
		$entityManager->flush();

		return $this->redirectToRoute('message_list');
	}

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