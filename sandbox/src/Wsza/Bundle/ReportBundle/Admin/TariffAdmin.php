<?php

namespace Wsza\Bundle\ReportBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TariffAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('client', 'entity', array('class' => 'Wsza\Bundle\ReportBundle\Entity\Client', 'property' => 'name'))
            ->add('name')
            ->add('countingMethod', 'choice',
                array('choices' => array(
                    'seconds' => 'naliczanie sekundowe',
                    'singular' => 'za połączenie',
                    'minutes' => 'za każdą rozpoczętą minutę połączenia'
                )))
            ->add('price', 'number');
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('client.name')
            ->add('name')
            ->add('countingMethod')
            ->add('price');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('client.name')
            ->addIdentifier('name')
            ->add('countingMethod')
            ->add('price', 'currency', array('currency' => 'PLN'));
    }
}