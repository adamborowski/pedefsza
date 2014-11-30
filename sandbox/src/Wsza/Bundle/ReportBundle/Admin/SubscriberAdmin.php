<?php

namespace Wsza\Bundle\ReportBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SubscriberAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('client', 'entity', array('class' => 'Wsza\Bundle\ReportBundle\Entity\Client', 'property' => 'name'))
            ->add('id')
            ->add('firstName')
            ->add('lastName')
            ->add('number')
            ->add('address1')
            ->add('address2')
            ->add('bankAccountNumber')
            ->add('accountingPeriodStart');
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('client.name')
            ->add('id')
            ->add('firstName')
            ->add('lastName')
            ->add('number')
            ->add('address1')
            ->add('address2')
            ->add('bankAccountNumber')
            ->add('accountingPeriodStart');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('client.name')
            ->addIdentifier('id')
            ->addIdentifier('firstName')
            ->addIdentifier('lastName')
            ->add('number')
            ->add('address1')
            ->add('address2')
            ->add('bankAccountNumber')
            ->add('accountingPeriodStart');
    }
}