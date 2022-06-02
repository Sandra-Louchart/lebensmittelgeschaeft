<?php

namespace App\Controller;

use App\Class\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class OrderValidateController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /*Controller which allows you to manage customers when the stripe payment has been successful*/

    #[Route('order/success/{stripeSessionId}', name: 'app_order_validate')]
    public function index($stripeSessionId, Cart $cart, MailerInterface $mailer): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        /*If the payment is validated and the customer is identical then we empty their basket and we pass isPaid in positive
         And we send an email*/
        if(!$order->isIsPaid()) {

            $cart ->remove();
            $order->setIsPaid(1);
            $this->entityManager->flush();

            $email = (new Email())
                ->from('hello@example.com')
                ->to('you@example.com')
                ->subject('Danke für Ihren Einkauf!')
                ->html('<p>Vielen Dank für Ihren Einkauf. Sie können Ihre Bestellung direkt in Ihrem Konto verfolgen</p>');
            $mailer->send($email);


        }
        return $this->render('order_validate/index.html.twig', [
            'order' => $order,
        ]);
    }
}