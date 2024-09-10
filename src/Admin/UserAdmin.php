<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

/**
 * Class UserAdmin
 * This class manages the administration interface for user entities.
 */
class UserAdmin extends AbstractAdmin
{

	/**
	 * Configure the form fields for adding/editing users.
	 *
	 * @param FormMapper $formMapper The form mapper for configuring form fields.
	 */
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

	/**
	 * Configure the filters for searching and filtering users.
	 *
	 * @param DatagridMapper $filter The datagrid mapper for configuring filters.
	 */
	protected function configureDatagridFilters(DatagridMapper $filter): void
	{
		$filter
		->add('email')
		->add('roles')
		->add('is_blocked');
	}

	/**
	 * Configure the fields displayed in the list view of users.
	 *
	 * @param ListMapper $list The list mapper for configuring list fields.
	 */
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
