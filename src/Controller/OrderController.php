<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Producto;
use App\Entity\Usuario;
use App\Entity\Categoria;
use App\Entity\Order;
use App\Manager\CartManager;
use App\Form\OrderType;
use Symfony\Component\HttpFoundation\Request;



class OrderController extends AbstractController
{

    public function index(Request $request, CartManager $cartManager): Response
    {
        $em = $this->getDoctrine()->getManager();
        $categorias_repo = $em->getRepository(Categoria::class);
        $categorias = $categorias_repo->findById('DESC');
        $cart = $cartManager->getCurrentCart();

        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $order->setEstado('En fabrica');
            $order->setFecha(new \DateTime());
            $order->setHora(new \DateTime());
            $order->setCoste($cart->getTotal());
            $order->setUsuario();
            
           
            $em->persist($order);
            $em->flush();
            $this->addFlash('producto-crear', 'Se ha creado el producto correctamente');

           
            return $this->redirectToRoute('pedido');
        }
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
            'categorias' => $categorias,
            'form' => $form->createView(),
        ]);
    }
}
