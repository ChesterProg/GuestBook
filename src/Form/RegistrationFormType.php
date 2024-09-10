<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class RegistrationFormType
 * This class defines the form used for user registration.
 */
class RegistrationFormType extends AbstractType
{
	/**
	 * Builds the registration form.
	 *
	 * @param FormBuilderInterface $builder The form builder.
	 * @param array $options The options for the form.
	 */
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('email') // Field for the user's email address
			->add('agreeTerms', CheckboxType::class, [
				'mapped' => false, // This field is not mapped to the User entity
				'constraints' => [
					new IsTrue([
						'message' => 'You should agree to our terms.', // Error message if terms are not agreed to
					]),
				],
			])
			->add('plainPassword', PasswordType::class, [
				// This field is not mapped to the User entity; it's processed in the controller
				'mapped' => false,
				'attr' => ['autocomplete' => 'new-password'], // Prevents browser autofill for security
				'constraints' => [
					new NotBlank([
						'message' => 'Please enter a password', // Error message for empty password
					]),
					new Length([
						'min' => 6, // Minimum password length
						'minMessage' => 'Your password should be at least {{ limit }} characters', // Error message for short passwords
						'max' => 4096, // Maximum length allowed for security reasons
					]),
				],
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
		$resolver->setDefaults([
			'data_class' => User::class, // The class that this form is mapped to
		]);
	}
}