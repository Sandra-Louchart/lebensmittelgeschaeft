<?php

namespace App\Controller;

use App\Class\Search;
use App\Entity\Products;
use App\Form\SearchType;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $arrayCollection = array();
        foreach($products as $product) {
            $arrayCollection[] =array(
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'image' => $product->getPictureName()

            );
        }

        return new JsonResponse($arrayCollection);

    }

    #[Route('/produkt/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Products $product): JsonResponse
    {
//        return  new JsonResponse($product);
        dd($product);
    }
}
