<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Producto;
use App\Entity\Categoria;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\ProductoType;
use App\Repository\ProductoRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\AddToCartType;
use App\Manager\CartManager;




class ProductoController extends AbstractController
{

    public function index(PaginatorInterface $paginator, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorias_repo = $em->getRepository(Categoria::class);
        $categorias = $categorias_repo->findById('DESC');
        $productos_repo = $em->getRepository(Producto::class);
        $productos = $productos_repo->findAll();
        $query = $productos_repo->findAll();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            16 /*limit per page*/
        );
        return $this->render('producto/index.html.twig', [
            'categorias' => $categorias,
            'productos' => $productos,
            'pagination' => $pagination
        ]);
    }

    public function gestion(){

        $em = $this->getDoctrine()->getManager();
        $productos_repo = $em->getRepository(Producto::class);
        $productos = $productos_repo->findByProducto('DESC');

        $categorias_repo = $em->getRepository(Categoria::class);
        $categorias = $categorias_repo->findById('DESC');

        return $this->render('producto/producto.html.twig',[
            'productos' => $productos,
            'categorias' => $categorias
        ]);
    }

    public function crear(Request $request, SluggerInterface $slugger){
        $em = $this->getDoctrine()->getManager();
        $productos = new Producto();
        $form = $this->createForm(ProductoType::class, $productos);

        $form->handleRequest($request);

        // var_dump($productos);
        // die();
        if($form->isSubmitted() && $form->isValid()){
            $brochureFile = $form->get('imagen')->getData();
            
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $productos->setImagen($newFilename);
            }



            $productos->setFecha(new \DateTime());
            
            // $productos->setNombre($usuario);


            $em->persist($productos);
            $em->flush();
            $this->addFlash('producto-crear', 'Se ha creado el producto correctamente');


            return $this->redirectToRoute('gestion-producto');
        }
        $categorias_repo = $em->getRepository(Categoria::class);
        $categorias = $categorias_repo->findById('DESC');

        return $this->render('producto/crear.html.twig', [
            'form' => $form->createView(),
            'categorias' => $categorias,
            'productos' => $productos
        ]);
    }

    public function editar(Request $request, Producto $productos, SluggerInterface $slugger){
        $em = $this->getDoctrine()->getManager();
        $categorias_repo = $em->getRepository(Categoria::class);
        $categorias = $categorias_repo->findById('DESC');

        $form = $this->createForm(ProductoType::class, $productos);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $brochureFile = $form->get('imagen')->getData();
            
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $productos->setImagen($newFilename);
            }

            $em->persist($productos);
            $em->flush();

            $this->addFlash('editar-producto', 'Se ha editado el producto correctamente');

            return $this->redirect($this->generateUrl('gestion-producto', ['id' => $productos->getId()]));
        }


        return $this->render('producto/crear.html.twig',[
            'form' => $form->createView(),
            'categorias' => $categorias,
            'editar' => true,
            'productos' => $productos
            
        ]);
    }

    public function eliminar(Producto $productos){
        $em = $this->getDoctrine()->getManager();
        $categorias_repo = $em->getRepository(Categoria::class);
        $categorias = $categorias_repo->findById('DESC');

        if(!$productos){
            return $this->redirectToRoute('gestion-producto');
        }

        $em->remove($productos);
        $em->flush();
        return $this->redirectToRoute('gestion-producto',[
            'categorias' => $categorias,
        ]);

    }

    public function comprar(Producto $productos, Request $request, CartManager $cartManager){
        $em = $this->getDoctrine()->getManager();

        $categorias_repo = $em->getRepository(Categoria::class);
        $categorias = $categorias_repo->findById('DESC');
        $id = $productos->getId();

        $form = $this->createForm(AddToCartType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            $item->setProducto($productos);

            $cart = $cartManager->getCurrentCart();
            $cart
                ->addItem($item)
                ->setUpdatedAt(new \DateTime());

            $cartManager->save($cart);

            return $this->redirectToRoute('cart', ['id' => $productos->getId()]);
        }

        $productos_repo = $em->getRepository(Producto::class);
        $productos = $productos_repo->findAll();

        return $this->render('producto/comprar.html.twig',[
            'id' => $id,
            'productos' => $productos,
            'categorias' => $categorias,
            'form' => $form->createView(),
            
        ]);
    }
}
