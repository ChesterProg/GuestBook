<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
					->add('name', TextType::class, [
//						// @TODO make regex constraint;
//						'constraints' => new Assert\Regex([
//							'pattern' => '/^[a-zA-Z0-9]+$/',
//							'message' => 'Username can only contain letters and numbers.',
//						]),
						'label' => 'Username'
					])
					->add('email', EmailType::class, [
						'label' => 'Email'
					])
					->add('homepage', UrlType::class, [
						'label' => 'Homepage (optional)',
						'required' => false
					])
					->add('text', TextareaType::class, [
						'label' => 'Message'
					]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
			 $resolver->setDefaults([
				 'data_class' => Message::class,
			 ]);
    }
}
