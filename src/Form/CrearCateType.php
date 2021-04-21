<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CrearCateType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('nombre',TextType::class, [
            'label' => 'Nombre'
        ])
        ->add('submit',SubmitType::class, [
            'label' => 'Crear'
        ]);
           
    }

}