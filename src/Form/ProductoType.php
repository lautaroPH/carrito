<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Mime\MimeTypes;
use App\Entity\Producto;
use App\Entity\Categoria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductoType extends AbstractType{



    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder->add('nombre',TextType::class, [
            'label' => 'Nombre'
        ])
        ->add('descripcion',TextareaType::class, [
            'label' => 'Descripcion'
        ])
        ->add('precio',NumberType::class, [
            'label' => 'Precio'
        ])
        ->add('stock',NumberType::class, [
            'label' => 'Stock'
        ])
        ->add('categoria', EntityType::class, [
            'class' => Categoria::class, 
            'choice_label' => 'nombre',
        ])
        ->add('imagen',FileType::class, [
            'data_class' => null,
            'label' => 'Imagen',
            'required'=> true,
            'mapped' => 'false',
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/png',
                        'image/webp',
                        'image/jpg',
                        'image/jpeg',
                    ],
                    'mimeTypesMessage' => 'Sube un archivo de imagen correcto',
                ])
            ],
        ]);


        
           
        }

}