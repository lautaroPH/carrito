<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\Usuario;
use App\Form\RegistroType;

class UsuarioController extends AbstractController
{

    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $usuario = new Usuario();
        $form = $this->createForm(RegistroType::class, $usuario);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //declarar el rol
            $usuario->setRol('ROLE_USER');

            //cifrar contraseña
            $encoded = $encoder->encodePassword($usuario, $usuario->getPassword());
            $usuario->setPassword($encoded);

            //guarda usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            $this->addFlash('success', 'Te has registrado correctamente');

            
            return $this->redirectToRoute('login');
        }
        
        return $this->render('usuario/registro.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function login(AuthenticationUtils $autenticationUtils){
        $error = $autenticationUtils->getLastAuthenticationError();

        $lastUsername = $autenticationUtils->getLastUsername();


        return $this->render('usuario/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }
}
