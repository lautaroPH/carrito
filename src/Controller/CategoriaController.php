<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Categoria;
use App\Entity\Producto;
use App\Repository\ProductoRepository;
use App\Form\CrearCateType;

class CategoriaController extends AbstractController
{

    public function index(){
        $em = $this->getDoctrine()->getManager();
        $categorias_repo = $em->getRepository(Categoria::class);
        $categorias = $categorias_repo->findById('DESC');


        return $this->render('categoria/index.html.twig', [
            'categorias' => $categorias,
        ]);

    }

    public function mostrar(){
        $em = $this->getDoctrine()->getManager();
        $categorias_repo = $em->getRepository(Categoria::class);
        $categorias = $categorias_repo->findById('DESC');


        return $this->render('base.html.twig', [
            'categorias' => $categorias,
        ]);

    }



    public function crear(Request $request){
        
        $categorias = new Categoria();
        $form = $this->createForm(CrearCateType::class, $categorias);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            

            $em = $this->getDoctrine()->getManager();
            $em->persist($categorias);
            $em->flush();
            $categorias_repo = $em->getRepository(Categoria::class);
            $categorias = $categorias_repo->findById('DESC');

            $this->addFlash('categoria', 'Se ha creado la categoria correctamente');

            return $this->redirect($this->generateUrl('categoria'));
        }

        return $this->render('categoria/crear.html.twig', [
            'form' => $form->createView(),
            'categorias' => $categorias,
        ]);
    }

    public function ver(){
        $em = $this->getDoctrine()->getManager();
        $categorias_repo = $em->getRepository(Categoria::class);
        $categorias = $categorias_repo->findById('DESC');


        $id = $_GET['id'];

        $productos_repo = $em->getRepository(Producto::class);
        $productos = $productos_repo->findAll();
        $categoria_repo = $em->getRepository(Categoria::class);
        $categoriaTitle = $categoria_repo->findOneBy(['id' => "$id"]);

        // var_dump($productos);
        // die();
        

        
        return $this->render('categoria/ver.html.twig',[
            'categorias' => $categorias,
            'categoriaTitle' => $categoriaTitle,
            'productos' => $productos,
            'id' => $id,
        ]);
    }


}
