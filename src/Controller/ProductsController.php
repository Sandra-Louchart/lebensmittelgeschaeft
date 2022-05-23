<?php

namespace App\Controller;

use App\Class\Search;
use App\Entity\Products;
use App\Form\SearchType;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @param ProductsRepository $productsRepository
     * @param $request
     * @return Response
     */
    #[Route('/unseren-products', name: 'app_products')]
    public function index(ProductsRepository $productsRepository, Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Products::class)->findWithSearch($search);
        } else {
            $products = $this->entityManager->getRepository(Products::class)->findAll();
        }

        return $this->render('products/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);

    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Products $product): Response
    {
        return $this->render('products/show.html.twig', [
            'product' => $product,
        ]);
    }
}
