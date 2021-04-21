<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('provincia',TextType::class, [
            'label' => 'Provincia'
        ]) 
        ->add('localidad',TextType::class, [
            'label' => 'Ciudad'
        ])
        ->add('direccion',TextType::class, [
            'label' => 'Direccion'
        ])
        ->add('order',SubmitType::class, [
            'label' => 'Confirmar pedido'
        ]);
           
    }

}