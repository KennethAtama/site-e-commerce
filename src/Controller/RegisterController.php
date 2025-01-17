<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        //instancier un objet user
        $user = new User();

        //instancier un objet formulaire, ensuite on mapp les données avec la class User
        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);

        //
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Félicitation !! Votre compte a été crée'
            );
            return $this->redirectToRoute('app_login');
        }
        return $this->render('register/index.html.twig', [
            'registerForm' => $form->createView()
        ]);
    }
}
