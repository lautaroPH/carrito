<?php

namespace App\Controller;

use App\Form\CartType;
use App\Entity\Categoria;
use App\Entity\Producto;
use App\Manager\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CartController
 * @package App\Controller
 */
class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(CartManager $cartManager, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $categorias_repo = $em->getRepository(Categoria::class);
        $categorias = $categorias_repo->findById('DESC');

        $productos_repo = $em->getRepository(Producto::class);
        $productos = $productos_repo->findAll();

        $cart = $cartManager->getCurrentCart();
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cart->setUpdatedAt(new \DateTime());
            $cartManager->save($cart);

            return $this->redirectToRoute('cart');
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'form' => $form->createView(),
            'categorias' => $categorias,
            'productos' => $productos,
        ]);
    }
}