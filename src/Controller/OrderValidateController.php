<?php

namespace App\Controller;

use App\Entity\Order;
use App\Service\Cart;
use App\Service\Mail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

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
    public function index($stripeSessionId, Cart $cart, Mail $mail): Response
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

            $mail->succesEmail(
                $order->getUser()->getEmail()
                );

            $mail->newOrder();

        }
        return $this->render('order_validate/index.html.twig', [
            'order' => $order,
        ]);
    }
}