<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, Mail $mail): Response
    {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        $notification = null;

        if($form->isSubmitted() && $form->isValid()) {
            $mail->sendEmail(
                $contact->getEmail(),
                $contact->getSubject(),
                $contact->getMessage(),
            );

            $notification= 'Wir werden Ihre E-Mail so schnell wie möglich beantworten';

        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification,

        ]);
    }
    // TODO Verwalten Sie den Kontakt mit einem Kontaktteil in der Datenbank oder API
}
