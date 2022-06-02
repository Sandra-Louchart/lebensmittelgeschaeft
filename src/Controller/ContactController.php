<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        $notification = null;

        if($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from('hello@example.com')
                ->to('you@example.com')
                ->subject('Time for Symfony Mailer!')
                ->html('<p>See Twig integration for better HTML integration!</p>');
            $mailer->send($email);
            $notification= 'Wir werden Ihre E-Mail so schnell wie möglich beantworten';

        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification,

        ]);
    }
    // TODO Verwalten Sie den Kontakt mit einem Kontaktteil in der Datenbank oder API
}
