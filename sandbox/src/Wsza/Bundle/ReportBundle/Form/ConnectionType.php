<?php

namespace Wsza\Bundle\ReportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConnectionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number')
            ->add('startTime')
            ->add('endTime')
            ->add('subscriber')
            ->add('tariff')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wsza\Bundle\ReportBundle\Entity\Connection'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wsza_bundle_reportbundle_connection';
    }
}
