<?php

namespace Wsza\Bundle\ReportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('login')
            ->add('password')
            ->add('address1')
            ->add('address2')
            ->add('correspondenceName')
            ->add('correspondenceAddress1')
            ->add('correspondenceAddress2')
            ->add('correspondencePhoneNumber')
            ->add('nip')
            ->add('bankAccountNumber')
            ->add('paymentDelay')
            ->add('subscriberUrl')
            ->add('billingUrl')
            ->add('postReportUrl')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wsza\Bundle\ReportBundle\Entity\Client'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wsza_bundle_reportbundle_client';
    }
}
