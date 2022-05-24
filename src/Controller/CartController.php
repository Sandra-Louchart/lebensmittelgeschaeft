<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, ProductsRepository $productsRepository)
    {

        $panier = $session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $productsRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($panierWithData as $couple) {
            $total += $couple['product']->getPrice() * $couple['quantity'];
        }


        return $this->render('cart/index.html.twig', [
            "cart" => $panierWithData,
            "total" => $total
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_add_cart')]
    public function add($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);

        if (empty($panier[$id])) {
            $panier[$id] = 0;
        }

        $panier[$id]++;

        $session->set('panier', $panier);

        return $this->redirectToRoute("app_products");
    }

    #[Route('/delete/{id}', name:'app_delete_cart')]
    public function delete($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/decrease/{id}', name:'decrease_to_cart')]
    public function decrease($id, SessionInterface $session){
        $panier = $session->get('panier', []);

        if (!empty( $panier[$id] ) && ($panier[$id] > 1)) {
            $panier[$id]--;
        } else {
            unset($panier[$id]);
        }

         $session->set('panier', $panier);
        return $this->redirectToRoute('app_cart');

    }

    #[Route('/cart/add_direct/{id}', name: 'app_add_direct_cart')]
    public function addDirect($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);

        if (empty($panier[$id])) {
            $panier[$id] = 0;
        }

        $panier[$id]++;

        $session->set('panier', $panier);

        return $this->redirectToRoute("app_cart");
    }
}
