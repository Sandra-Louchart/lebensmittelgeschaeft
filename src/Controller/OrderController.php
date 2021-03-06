<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use App\Service\Cart;
use Doctrine\ORM\EntityManagerInterface;
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

        /*Allows you to retrieve the addresses of the connected customers, the different possible deliverers and the customer's basket*/

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

        /*Takes into account the address and the delivery person chosen by the customer. As well as the customer's basket with the different prices
        The link to stripe is here. when we top the payment */

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
            $reference = $date->format('dmY'). '-'. uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreateAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($delivery_content);
            $order->setIsPaid(0);

            $this->entityManager->persist($order);

            foreach ($cart->getFull() as $product) {
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice(($product ['product']->getPrice())*100);
                $orderDetails->setTotal($product ['product']->getPrice() * $product['quantity']);
                $orderDetails->setProduct($product['product']->isIsBest());

                $this->entityManager->persist($orderDetails);

            }
            $this->entityManager->flush();

            return $this->render('order/add.html.twig', [
                'cart' => $cart->getFull(),
                'carrier' => $carriers,
                'delivery' => $delivery_content,
                'reference' => $order->getReference(),
            ]);
        }

        return $this->redirectToRoute('app_cart');

    }
}
