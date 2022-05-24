<?php

namespace App\Controller;

use App\Class\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/order', name: 'app_order')]
    public function index(Cart $cart, Request $request): Response
    {
        if (!$this->getUser()->getAddresses()->getValues())
        {
            return $this->redirectToRoute('app_account_add_address');
        }
        $form =$this->createForm(OrderType::class, null, [
            'user' =>$this->getUser()
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull(),
        ]);
    }

    #[Route('/order/recapitulatif', name: 'app_order_recap', methods: ['POST'])]
    public function add(Cart $cart, Request $request): Response
    {
        $form =$this->createForm(OrderType::class, null, [
            'user' =>$this->getUser()
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTime();
            $carriers = $form->get('carriers')->getData();
            $delivery = $form->get('addresses')->getData();
            $delivery_content = $delivery->getFirstName(). ' ' .$delivery->getLastname();
            $delivery_content .= '<br/>' .$delivery->getPhone();

            if ($delivery->getCompany()) {
                $delivery_content .= '<br/>' .$delivery->getCompany();
            }

            $delivery_content .= '<br/>' .$delivery->getAddress();
            $delivery_content .= '<br/>' .$delivery->getPostal(). ' '.$delivery->getCity();
            $delivery_content .= '<br/>' .$delivery->getCountry();


            $order = new Order();
            $order->setUser($this->getUser());
            $order->setCreateAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($delivery_content);
            $order->setIsPaid(0);

            $this->entityManager->persist($order);


            $products_for_stripe = [];

            foreach ($cart->getFull() as $product) {
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product ['product']->getPrice());
                $orderDetails->setTotal($product ['product']->getPrice() * $product['quantity']);
                $this->entityManager->persist($orderDetails);

                $products_for_stripe[] = [
                    'name' => $product['product']->getName(),
                    'price' => $product ['product']->getPrice(),
                    'quantity' => $product['quantity'],

                ];


            }
//            $this->entityManager->flush();
//STRIPE

            Stripe::setApiKey('sk_test_51L2xg3HTzwG93SGE4HJFo8P5KuWa3PIznDhn5jlhoD7xiwAKAi80YFIzxZ1IWUJnalHni0wkNUv8cOnvu7DtGPLk00dXhCkDWE');

            $YOUR_DOMAIN = 'http://127.0.0.1:8000';

            $checkout_session = Session::create([
                'line_items' => [[
                    $products_for_stripe,
                ]],
                dd($products_for_stripe), 'mode' => 'payment',
                'success_url' => $YOUR_DOMAIN . '/success.html',
                'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
            ]);

//            header("HTTP/1.1 303 See Other");
//            header("Location: " . $checkout_session->url);

            dump($checkout_session->id);


            return $this->render('order/add.html.twig', [
                'cart' => $cart->getFull(),
                'carrier' => $carriers,
                'delivery' => $delivery_content,
            ]);
        }

        return $this->redirectToRoute('app_cart');

    }
}
