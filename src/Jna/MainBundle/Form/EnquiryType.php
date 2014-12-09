<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 14-12-08
 * Time: 20:41
 */

namespace Jna\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class EnquiryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'attr' => array(
                'placeholder' => 'Votre nom complet',
                'id'          => 'contact_name'
            ),
            'label' => false,
        ));
        $builder->add('email', 'email',array(
            'attr' => array(
                'placeholder' => 'Votre adresse email',
                'id'          => 'contact_email'
            ),
            'label' => false,
        ));
        $builder->add('body', 'textarea',array(
            'attr' => array(
                'placeholder' => 'Parlez-nous de votre projet',
                'id'          => 'contact_message',
                'rows' => '15'
            ),
            'label' => false,
        ));
    }

    public function getName()
    {
        return 'contact';
    }

} 