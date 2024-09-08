<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class UserAdmin extends AbstractAdmin
{
	// Налаштування форми для додавання/редагування користувачів
	protected function configureFormFields(FormMapper $form_mapper): void
	{
		$form_mapper
			->add('email', TextType::class)
			->add('roles', ChoiceType::class, [
				'choices' => [
					'User' => 'ROLE_USER',
					'Admin' => 'ROLE_ADMIN',
				],
				'multiple' => true, // Allow multiple selections if necessary
				'expanded' => true,  // Use checkboxes or radio buttons
			])
			->add('password', TextType::class)
			->add('is_blocked', CheckboxType::class, [
				'required' => false,
				'label' => 'Block user',
			]);

	}

	// Налаштування фільтрів для пошуку та фільтрації користувачів
	protected function configureDatagridFilters(DatagridMapper $filter): void
	{
		$filter
		->add('email')
		->add('roles')
		->add('is_blocked');
	}

	// Налаштування списку для відображення користувачів
	protected function configureListFields(ListMapper $list): void
	{
		$list
			->addIdentifier('email')
			->add('roles')
			->add('is_blocked', null, [
				'editable' => true,
				'label' => 'Blocked',
			])
			->add('_action', 'actions', [
				'actions' => [
					'edit' => [],
					'delete' => [],
				],
			]);
	}
}
