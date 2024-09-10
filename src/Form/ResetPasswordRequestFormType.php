<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ResetPasswordRequestFormType
 *
 * This class is responsible for building the form used to request a password reset.
 */
class ResetPasswordRequestFormType extends AbstractType
{
	/**
	 * Builds the form by adding the necessary fields.
	 *
	 * @param FormBuilderInterface $builder The form builder
	 * @param array $options The options for the form
	 */
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('email', EmailType::class, [
				// Setting the HTML attribute for autocomplete
				'attr' => ['autocomplete' => 'email'],
				'constraints' => [
					// Ensuring that the email field is not left blank
					new NotBlank([
						'message' => 'Please enter your email',
					]),
				],
			]);
	}

	/**
	 * Configures the options for this form type.
	 *
	 * @param OptionsResolver $resolver The resolver for the options
	 */
	public function configureOptions(OptionsResolver $resolver): void
	{
		// Setting default options for the form (currently none)
		$resolver->setDefaults([]);
	}
}