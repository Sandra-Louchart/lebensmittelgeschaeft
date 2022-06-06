<?php

namespace App\Service;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    private $requestStack;
    private $entityManager;
    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager) {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    public function add($id)
    {
        $session = $this->requestStack->getSession();
        $cart =$session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

       return $session->set('cart' , $cart);
    }

    public function get()
    {
        $session = $this->requestStack->getSession();

        return $session->get('cart');
    }

    public function remove()
    {
        $session = $this->requestStack->getSession();

        $session->remove('cart');
    }

    public function delete($id)
    {
        $session = $this->requestStack->getSession();

        $cart = $session->get('cart', []);

        unset($cart[$id]);

        return $session->set('cart', $cart);
    }

    public function decrease($id)
    {
        $session = $this->requestStack->getSession();

        $cart = $session->get('cart', []);

        if ($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }

        return $session->set('cart', $cart);
    }

    public function addDirect($id)
    {
        $session = $this->requestStack->getSession();

        $cart = $session->get('cart', []);

        if (empty($cart[$id])) {
            $cart[$id] = 0;
        } else {
            $cart[$id]++;

        }

        return $session->set('cart', $cart);
    }

    public function getFull()
    {
        $session = $this->requestStack->getSession();

        $cartComplete = [];

        if ($this->get()) {
            foreach ($this->get() as $id => $quantity) {
                $product_object = $this->entityManager->getRepository(Products::class)->findOneById($id);

                if (!$product_object) {
                    $this->delete($id);
                    continue;
                }

                $cartComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }

        return $cartComplete;
    }

    public function getAction()
    {
//        $totalAction = 0;
//        $product_action = $th
    }
}
