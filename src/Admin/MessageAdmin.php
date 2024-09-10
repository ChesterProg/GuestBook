<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MessageAdmin extends AbstractAdmin
{

	/**
	 * Configure the form fields for creating/editing messages.
	 *
	 * @param FormMapper $form The form mapper
	 */
	protected function configureFormFields(FormMapper $form): void
	{}

	/**
	 * Configure the filters for the datagrid.
	 *
	 * @param DatagridMapper $datagrid The datagrid mapper
	 */
	protected function configureDatagridFilters(DatagridMapper $datagrid): void
	{
		// Add filters to the datagrid for searching messages.
		$datagrid->add('name')
		->add('email')
		->add('status');
	}

	/**
	 * Configure the fields displayed in the list view of messages.
	 *
	 * @param ListMapper $list The list mapper
	 */
	protected function configureListFields(ListMapper $list): void
	{
		// Define the fields to display in the list view of messages.
		$list->addIdentifier('email', null, ['label' => 'Email'])
			->add('name', null, ['label' => 'Username'])
			->add('text', null, ['label' => 'Text'])
			->add('homepage', null, ['label' => 'Homepage'])
			->add('status', null, ['editable' => true, 'label' => 'Approved'])
			->add('image_path', null, ['label' => 'Image path'])
			->add('created_at', null, ['label' => 'Created At'])
			->add('_action', 'actions', [
				'actions' => [
					'edit' => [],
					'delete' => [],
				],
			]);
	}

	/**
	 * Configure the fields displayed when viewing a single message.
	 *
	 * @param ShowMapper $showMapper The show mapper
	 */
	protected function configureShowFields(ShowMapper $show_mapper): void
	{
		// Define the fields to display in the detail view of a message.
		$show_mapper
			->add('name', null, ['label' => 'Name'])
			->add('email', null, ['label' => 'Email'])
			->add('homepage', null, ['label' => 'Homepage'])
			->add('text', null, ['label' => 'Message'])
			->add('image_path', null, ['label' => 'Image'])
			->add('status', null, ['label' => 'Approved'])
			->add('created_at', null, ['label' => 'Created At']);
	}
}
