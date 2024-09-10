<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ChangePasswordFormType
 * This class defines the form for changing a user's password.
 */
class ChangePasswordFormType extends AbstractType
{
	/**
	 * Builds the form for changing the password.
	 *
	 * @param FormBuilderInterface $builder The form builder.
	 * @param array $options The options for the form.
	 */
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('plainPassword', RepeatedType::class, [
				'type' => PasswordType::class, // Specifies the type of the fields
				'options' => [
					'attr' => [
						'autocomplete' => 'new-password', // Prevents the browser from autofilling the password
					],
				],
				'first_options' => [
					'constraints' => [
						new NotBlank([
							'message' => 'Please enter a password', // Error message if the field is empty
						]),
						new Length([
							'min' => 6, // Minimum length of the password
							'minMessage' => 'Your password should be at least {{ limit }} characters', // Error message for minimum length
							'max' => 4096, // Maximum length allowed for security reasons
						]),
					],
					'label' => 'New password', // Label for the first password field
				],
				'second_options' => [
					'label' => 'Repeat Password', // Label for the second password field
				],
				'invalid_message' => 'The password fields must match.', // Error message if passwords do not match
				'mapped' => false, // This field is not mapped to the entity directly
			]);
	}

	/**
	 * Configures the options for this form type.
	 *
	 * @param OptionsResolver $resolver The resolver for the options.
	 */
	public function configureOptions(OptionsResolver $resolver): void
	{
		// Set default options for the form
		$resolver->setDefaults([]);
	}
}