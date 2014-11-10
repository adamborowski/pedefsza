<?php

namespace Wsza\Bundle\ReportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubscriberType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('firstName')
            ->add('lastName')
            ->add('address1')
            ->add('address2')
            ->add('accountingPeriodStart')
            ->add('client')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wsza\Bundle\ReportBundle\Entity\Subscriber'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wsza_bundle_reportbundle_subscriber';
    }
}
