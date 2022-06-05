<?php

namespace App\Controller;

use App\Entity\Order;
use App\Service\Mail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderCancelController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /*Controller which allows you to manage customers when the stripe payment has not been successful*/

    #[Route('/order/cancel/{stripeSessionId}', name: 'app_order_cancel')]
    public function index($stripeSessionId, Mail $mail): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_home');

        } else {
            $mail->cancelEmail(
                $order->getUser()->getEmail()

            );
        }

        return $this->render('order_cancel/index.html.twig', [
            'order' => $order,
        ]);
    }
}
