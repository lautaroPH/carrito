<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegistroType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('nombre',TextType::class, [
            'label' => 'Nombre'
        ])
        ->add('apellidos',TextType::class, [
            'label' => 'Apellidos'
        ])
        ->add('email',EmailType::class, [
            'label' => 'Correo electronico'
        ])
        ->add('password',PasswordType::class, [
            'label' => 'Contraseña'
        ])
        ->add('submit',SubmitType::class, [
            'label' => 'Registrarse'
        ]);
        
    }

}