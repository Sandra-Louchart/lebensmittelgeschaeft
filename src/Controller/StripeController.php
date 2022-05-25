<?php

namespace App\Controller;

use App\Class\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    #[Route('/order/create-session/{reference}', name: 'app_stripe_create_session')]
    public function index(EntityManagerInterface $entityManager, Cart $cart, $reference): Response
    {
        Stripe::setApiKey('sk_test_51L3ETgFLHJnUYcV0otC1Xg7gswSl5WvJzYr4lcFSPHRT6A2DFHwnPI7PQplwmiP6rUOWwXdsCj6sPNJNeKZy695v00OGocMx2a');

        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
        $products_for_stripe = [];
        $order = $entityManager->getRepository(Order::class)->findOneBy(['reference' => $reference]);
        if (!$order) {
            $this->redirectToRoute('app_order');
        }
        foreach ($order->getOrderDetails()->getValues() as $product) {
            $products_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => ($product->getPrice()),
                    'product_data' => [
                        'name' => $product->getProduct(),
                    ],
                ],
                'quantity' => $product->getQuantity(),
            ];
        }

        $products_for_stripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => ($order->getCarrierPrice()*100),
                'product_data' => [
                    'name' => $order->getCarrierName(),
                ],
            ],
            'quantity' => 1,
        ];


        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'line_items' => [[
                $products_for_stripe,
            ]],

            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/order/success/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/order/cancel/{CHECKOUT_SESSION_ID}',
        ]);
        $order->setStripeSessionId($checkout_session->url);
        $entityManager->flush();

        return $this->redirect($checkout_session->url);

    }
}
