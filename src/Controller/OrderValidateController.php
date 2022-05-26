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

    #[Route('order/success/{stripeSessionId}', name: 'app_order_validate')]
    public function index($stripeSessionId, Cart $cart, MailerInterface $mailer): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        if(!$order->isIsPaid()) {

            $cart ->remove();
            $order->setIsPaid(1);
            $this->entityManager->flush();

//            $email = (new Email())
//                ->from('hello@example.com')
//                ->to('you@example.com')
//                ->subject('Time for Symfony Mailer!')
//                ->html('<p>See Twig integration for better HTML integration!</p>');
//            $mailer->send($email);


        }
        return $this->render('order_validate/index.html.twig', [
            'order' => $order,
        ]);
    }
}