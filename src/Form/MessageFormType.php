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

/**
 * Class MessageFormType
 * This class defines the form for creating or editing messages.
 */
class MessageFormType extends AbstractType
{
	/**
	 * Builds the form for creating or editing a message.
	 *
	 * @param FormBuilderInterface $builder The form builder.
	 * @param array $options The options for the form.
	 */
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('name', TextType::class, [
				'constraints' => [
					new Assert\NotBlank(['message' => 'Please enter your name.']),
					new Assert\Regex([
						'pattern' => '/^[a-zA-Z0-9]+$/',
						'message' => 'Username can only contain letters and digits.',
					]),
				],
			])
			->add('email', TextType::class, [
				'constraints' => [
					new Assert\NotBlank(['message' => 'Please enter your email.']),
					new Assert\Email(['message' => 'Please enter a valid email address.']),
				],
			])
			->add('homepage', UrlType::class, [
				'required' => false, // This field is optional
				'constraints' => [
					new Assert\Url(['message' => 'Please enter a valid URL.']),
				],
			])
			->add('text', TextareaType::class, [
				'constraints' => [
					new Assert\NotBlank(['message' => 'Please enter your message.']),
					new Assert\Length([
						'max' => 1000,
						'maxMessage' => 'Your message cannot be longer than {{ limit }} characters.',
					]),
				],
				'help' => 'Allowed HTML tags: <a>, <code>, <i>, <strike>, <strong>', // Hint for allowed HTML tags
			])
			->add('user_id', HiddenType::class, [
				'data' => $options['user_id'], // Pre-fill with the user ID passed in options
			]);

		// Add captcha and image upload fields only if not in edit mode
		if (!$options['is_edit']) {
			$builder->add('captcha', CaptchaType::class); // Captcha for validation
			$builder->add('image_path', FileType::class, [
				'label' => 'Image (optional)',
				'required' => false, // This field is optional
			]);
		}

		// Add the checkbox for admin to approve the message if the user is an admin
		if ($options['is_admin']) {
			$builder->add('status', CheckboxType::class, [
				'required' => false,
				'label' => 'Approve this message',
				'data' => false, // Default value for the checkbox
			]);
		}
	}

	/**
	 * Configures the options for this form type.
	 *
	 * @param OptionsResolver $resolver The resolver for the options.
	 */
	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Message::class, // The class that this form is mapped to
			'is_admin' => false, // Default value for admin option
			'is_edit' => false, // Default value for edit option
			'user_id' => null, // Default value for user_id option
		]);
	}
}