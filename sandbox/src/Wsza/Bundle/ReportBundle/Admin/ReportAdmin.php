<?php

namespace Wsza\Bundle\ReportBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ReportAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('subscriber', 'entity', array('class' => 'Wsza\Bundle\ReportBundle\Entity\Subscriber', 'property' => 'displayName'))
            ->add('requestTime', 'sonata_type_datetime_picker')
            ->add('completeTime', 'sonata_type_datetime_picker')
            ->add('reportTime', 'sonata_type_datetime_picker')
            ->add('filePath');
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('subscriber.client.name')
            ->add('subscriber.firstName')
            ->add('subscriber.lastName')
            ->add('requestTime')
            ->add('completeTime')
            ->add('reportTime')
            ->add('filePath');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('subscriber.client.name')
            ->add('subscriber.displayName')
            ->addIdentifier('requestTime')
            ->addIdentifier('completeTime')
            ->addIdentifier('reportTime')
            ->addIdentifier('filePath');
    }
}