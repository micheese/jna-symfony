<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 14-11-18
 * Time: 20:33
 */

namespace Jna\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ProjectAdmin extends Admin{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text', array(
                'label' => 'Titre du projet',
                'required' => true
            ))
            ->add('description' , 'textarea' , array(
                'label' => 'Description du projet',
                'required' => true
            ))
            ->add('file', 'file', array('required' => false))
            ->add('workType', 'sonata_type_model_list', array(
                'btn_add'       => 'Ajouter un "type de projet" (Servira de filtre pour les photos) ',  //Specify a custom label
                'btn_list'      => 'button.list',     //which will be translated
                'btn_delete'    => false,             //or hide the button.
                'btn_catalogue' => 'SonataNewsBundle' //Custom translation domain for buttons
            ), array(
                'placeholder' => 'Aucun projet selectionné'
            ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('description')
        ;
    }

}