<?php

namespace App\Form;

use App\Entity\Message;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class MessageFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('name', TextType::class, [
			'constraints' => [
				new Assert\NotBlank(),
				new Assert\Regex([
					'pattern' => '/^[a-zA-Z0-9]+$/',
					'message' => 'Username can only contain letters and digits.',
				]),
				],
			])
			->add('email', TextType::class, [
				'constraints' => [
					new Assert\NotBlank(),
					new Assert\Email(),
				],
			])
			->add('homepage', UrlType::class, [
				'required' => false,
				'constraints' => [
					new Assert\Url(),
				],
			])
			->add('text', TextareaType::class, [
				'constraints' => [
					new Assert\NotBlank(),
					new Assert\Length(['max' => 1000]),
				],
			])
			->add('user_id', HiddenType::class, [
				'data' => $options['user_id'],
			]);
			if (!$options['is_edit']) {
				$builder->add('captcha', CaptchaType::class);
				$builder->add('image_path', FileType::class, [
					'label' => 'Image (optional)',
					'required' => false,
				]);
			}

		// Add the checkbox for admin to approve the message
		if ($options['is_admin']) {
			$builder->add('status', CheckboxType::class, [
				'required' => false,
				'label' => 'Approve this message',
				'data' => false, // Default value for the checkbox
			]);
		}

	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Message::class,
			'is_admin' => false,
			'is_edit' => false, // Default value
			'user_id' => null, // Define user_id option with a default value
		]);
	}
}