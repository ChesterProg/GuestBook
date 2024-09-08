<?php
namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageFormType; // Ensure this matches the form class name
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
	#[Route('/messages', name: 'message_list')]
	public function list(EntityManagerInterface $entityManager): Response
	{
		// Retrieve all messages from the database, sorted by creation date (LIFO)
		$messages = $entityManager->getRepository(Message::class)->findBy(['status' => true], ['created_at' => 'DESC']);

		// Pass messages to Twig template for display
		return $this->render('message/message-list.html.twig', [
			'messages' => $messages
		]);
	}

	#[Route('/messages/add', name: 'message_new')]
	public function addMessage(Request $request, EntityManagerInterface $entityManager): Response
	{
		$message = new Message();

		// Check if the user has the admin role
		$is_admin = $this->isGranted('ROLE_ADMIN');

		$form = $this->createForm(MessageFormType::class, $message, [
			'is_admin' => $is_admin,
		]);

		$form->handleRequest($request);


		if ($form->isSubmitted() && $form->isValid()) {
			$status = $form->has('status') ? $form->get('status')->getData() : false;

			$message->setStatus($status);

			// Set created timestamps
			$now = new DateTime();
			$message->setCreatedAt($now);

			// Record IP and user agent
			$message->setIpAddress($request->getClientIp());
			$message->setUserAgent($request->headers->get('User-Agent'));

			// Handle image upload
			$file = $form->get('image_path')->getData();
			if ($file) {
				$newFilename = uniqid('', TRUE).'.'.$file->guessExtension();
				$file->move($this->getParameter('images_directory'), $newFilename);
				$message->setImagePath($newFilename);
			}

			// Sanitize input to allow only specific HTML tags
			$allowedTags = '<a><code><i><strike><strong>';
			$message->setText(strip_tags($message->getText(), $allowedTags));

			// Persist the message to the database
			$entityManager->persist($message);
			$entityManager->flush();

			// Redirect after successful addition
			return $this->redirectToRoute('message_list');
		}

		return $this->render('message/add-message.html.twig', [
			'form' => $form->createView(),
		]);
	}

	#[Route('/messages/{id}/edit', name: 'message_edit')]
	public function editMessage(Request $request, Message $message, EntityManagerInterface $entityManager): Response
	{
		// Check if the current user is the owner of the message
		if ($message->getUser() !== $this->getUser()) {
			throw $this->createAccessDeniedException('You do not have permission to edit this message.');
		}

		$form = $this->createForm(MessageFormType::class, $message);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$message->setIpAddress($request->getClientIp());
			$message->setUserAgent($request->headers->get('User-Agent'));

			// Sanitize input to allow only specific HTML tags
			$allowedTags = '<a><code><i><strike><strong>';
			$message->setText(strip_tags($message->getText(), $allowedTags));

			// Handle image upload if a new image is provided
			$file = $form->get('image_path')->getData();
			if ($file) {
				$newFilename = uniqid('', TRUE).'.'.$file->guessExtension();
				$file->move($this->getParameter('images_directory'), $newFilename);
				$message->setImagePath($newFilename);
			}

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
		$entityManager->remove($message);
		$entityManager->flush();

		return $this->redirectToRoute('message_list');
	}
}