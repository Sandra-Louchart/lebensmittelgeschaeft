<?php

namespace App\Controller;

use App\Class\Cart;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/cart', name: 'app_cart')]
    public function index(Cart $cart)
    {

        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFull()
        ]);

    }

    #[Route('/cart/add/{id}', name: 'app_add_cart')]
    public function add(Cart $cart, $id)
    {
        $cart->add($id);

        return $this->redirectToRoute('app_products');

    }

    #[Route('/delete/{id}', name:'app_delete_cart')]
    public function delete(Cart $cart, $id)
    {
        $cart->delete($id);

        return $this->redirectToRoute('app_cart');

    }

    #[Route('/cart/decrease/{id}', name:'decrease_to_cart')]
    public function decrease(Cart $cart, $id){
        $cart->decrease($id);

        return $this->redirectToRoute('app_cart');


    }

    #[Route('/cart/add_direct/{id}', name: 'app_add_direct_cart')]
    public function addDirect(Cart $cart, $id)
    {
        $cart->addDirect($id);


        return $this->redirectToRoute("app_cart");
    }
}

