<?php

namespace Wsza\Bundle\ReportBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ClientAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab("Dane podstawowe")
            ->add('name')
            ->add('login')
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('nip')
            ->add('bankAccountNumber')
            ->add('paymentDelay')
            ->end()
            ->end()
            ->tab('Dane kontaktowe')
            ->with('Adres firmy')
            ->add('address1')
            ->add('address2')
            ->end()
            ->with('Adres do korespondencji dla klienta')
            ->add('correspondenceName')
            ->add('correspondenceAddress1')
            ->add('correspondenceAddress2')
            ->add('correspondencePhoneNumber')
            ->end()
            ->end()
            ->tab('API')
            ->add('subscriberUrl')
            ->add('billingUrl')
            ->add('postReportUrl')
            ->end()
            ->end()
            //TODO zrobić plainPassword jak w przypadku FosUserBundle
//
//            ->add('author', 'entity', array('class' => 'Acme\DemoBundle\Entity\User'))
//            ->add('body') //if no type is specified, SonataAdminBundle tries to guess it
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('login')
            ->add('nip');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('login')
            ->add('nip');
    }
}