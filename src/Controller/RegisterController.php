<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/anmeldung', name: 'register')]
    public function index( Request $request, UserPasswordHasherInterface $passwordHasher ): Response
    {

        /*Check if the user and password hasher in the database are identical in order to allow the client to connect*/
        $notification = null;
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {

            $user = $form ->getData();
            $plaintextPassword = $form->get('password')->getData() ;
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);


            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $notification= 'Ihre Registrierung war erfolgreich. Sie können sich jetzt bei Ihrem Konto anmelden';
        }

        return $this->render('register/index.html.twig', [
            'form'=> $form->createView(),
            'notification' => $notification,
        ]);
    }
}
