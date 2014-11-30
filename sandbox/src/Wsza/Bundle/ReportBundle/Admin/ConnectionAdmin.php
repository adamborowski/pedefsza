<?php

namespace Wsza\Bundle\ReportBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ConnectionAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('subscriber', 'entity', array('class' => 'Wsza\Bundle\ReportBundle\Entity\Subscriber', 'property' => 'displayName'))
            ->add('tariff', 'entity', array('class' => 'Wsza\Bundle\ReportBundle\Entity\Tariff', 'property' => 'name'))
            ->add('number')
            ->add('startTime', 'sonata_type_datetime_picker')
            ->add('endTime', 'sonata_type_datetime_picker');
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('subscriber.client.name')
            ->add('subscriber.firstName')
            ->add('subscriber.lastName')
            ->add('number')
            ->add('startTime')
            ->add('endTime');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('subscriber.client.name')
            ->add('subscriber.displayName')
            ->addIdentifier('startTime')
            ->addIdentifier('endTime')
            ->add('tariff.name')
            ->add('number');
    }
}