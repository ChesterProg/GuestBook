<?php
namespace App\Command;

use App\Entity\Message;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand; // Import the AsCommand attribute
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'app:create-test-messages', description: 'Створює 50 тестових повідомлень.')]
class CreateTestMessagesCommand extends Command
{
	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		parent::__construct();
		$this->entityManager = $entityManager;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		for ($i = 1; $i <= 50; $i++) {
			$message = new Message();
			$message->setName('User #' . $i);
			$message->setEmail('test@mail.com' . $i);
			$message->setText('Тестове повідомлення номер ' . $i);
			$message->setUserId(10);
			$message->setStatus(true);
			$message->setImagePath('/uploads/images/test.png');
			$now = new DateTime();
			$now->modify("+$i minutes");
			$message->setCreatedAt($now);
			$this->entityManager->persist($message);
		}
		$this->entityManager->flush();
		$output->writeln('50 тестових повідомлень успішно створено!');
		return Command::SUCCESS;
	}
}