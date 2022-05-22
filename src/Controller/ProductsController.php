<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/unseren-products', name: 'app_products')]
    public function index(ProductsRepository $productsRepository): Response
    {
        $products = $this ->entityManager->getRepository(Products::class)->findAll();

        return $this->render('products/index.html.twig', [
            'products' => $products,
            ]);
    }
}
