<?php
namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageFormType;
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
		// Отримуємо всі повідомлення з бази даних, сортуємо за датою створення (LIFO)
		$messages = $entityManager->getRepository(Message::class)->findBy([], ['created_at' => 'DESC']);

		// Передаємо повідомлення в Twig шаблон для відображення
		return $this->render('message/message-list.html.twig', [
			'messages' => $messages
		]);
	}

	#[Route('/messages/add', name: 'message_new')]
	public function addMessage(Request $request, EntityManagerInterface $entityManager): Response
	{
		$message = new Message();
		$form = $this->createForm(MessageFormType::class, $message);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			// Set data created and updated.
			$now = new DateTime();
			$message->setCreatedAt($now);
			$message->setUpdatedAt($now);
			// Set default status (e.g., true or false)
			$message->setStatus(false);
			// Record IP and user agent.
			$message->setIpAddress($request->getClientIp());
			$message->setUserAgent($request->headers->get('User-Agent'));

			// Захист від XSS — дозволити тільки певні теги
			$allowedTags = '<a><code><i><strike><strong>';
			$message->setText(strip_tags($message->getText(), $allowedTags));

			// Зберігаємо повідомлення в базу
			$entityManager->persist($message);
			$entityManager->flush();

			// Перенаправлення після успішного додавання
			return $this->redirectToRoute('message_list');
		}

		return $this->render('message/add-message.html.twig', [
			'form' => $form->createView(),
		]);
	}

	#[Route('/messages/{id}/edit', name: 'message_edit')]
	public function editMessage(Request $request, Message $message, EntityManagerInterface $entityManager): Response
	{
		$form = $this->createForm(MessageFormType::class, $message);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$message->setUpdatedAt(new DateTime());
			$message->setIpAddress($request->getClientIp());
			$message->setUserAgent($request->headers->get('User-Agent'));
			$allowedTags = '<a><code><i><strike><strong>';
			$message->setText(strip_tags($message->getText(), $allowedTags));
			$entityManager->flush();
			return $this->redirectToRoute('message_list');
		}

		return $this->render('message/edit-message.html.twig', [
			'form' => $form->createView(),
			'message' => $message,
		]);
	}

	#[Route('/message/{id}/delete', name: 'message_delete')]
	public function delete(Message $message, EntityManagerInterface $entityManager): Response
	{
		$entityManager->remove($message);
		$entityManager->flush();
		return $this->redirectToRoute('message_list');
	}
}