<?php

namespace App\Controller;

use App\Class\Cart;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    #[Route('/order/create-session', name: 'app_stripe_create_session')]
    public function index(Cart $cart): Response
    {
        Stripe::setApiKey('sk_test_51L3ETgFLHJnUYcV0otC1Xg7gswSl5WvJzYr4lcFSPHRT6A2DFHwnPI7PQplwmiP6rUOWwXdsCj6sPNJNeKZy695v00OGocMx2a');

        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
        $products_for_stripe = [];

        foreach ($cart->getFull() as $product) {
            $products_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => ($product['product']->getPrice()*100),
                    'product_data' => [
                        'name' => $product['product']->getName(),
                    ],
                ],
                'quantity' => $product['quantity'],

            ];
        }


        $checkout_session = Session::create([
            'line_items' => [[
                $products_for_stripe,
            ]],

            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success.html',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);

        return $this->redirect($checkout_session->url);

    }
}
