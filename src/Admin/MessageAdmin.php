<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MessageAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $form): void
	{}

	protected function configureDatagridFilters(DatagridMapper $datagrid): void
	{
		$datagrid->add('name')
		->add('email')
		->add('status');
	}

	protected function configureListFields(ListMapper $list): void
	{
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

	// Налаштування перегляду одного запису (опціонально)
	protected function configureShowFields(ShowMapper $show_mapper): void
	{
		$show_mapper
			->add('name', null, ['label' => 'Name'])
			->add('email', null, ['label' => 'Email'])
			->add('homepage', null, ['label' => 'Homepage'])
			->add('text', null, ['label' => 'Message'])
			->add('image_path', null, ['label' => 'Image'])
			->add('status', null, ['label' => 'Approved'])
			->add('created_at', null, ['label' => 'Created At']);
	}


	//	protected function configureRoutes(RouteCollection $collection): void
//	{
//		// Додаємо додаткові маршрути, якщо потрібно (напр., для кастомних дій)
//	}
}
