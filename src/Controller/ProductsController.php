<?php

namespace App\Controller;

use App\Service\Search;
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

        /*We call on the Search class which will allow the customer to make a filter according to the category of the
        products, but also by writing the product (not necessarily in complete need of a minimum letter)*/

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Products::class)->findWithSearch($search);
        } else {
            $products = $this->entityManager->getRepository(Products::class)->findBy([],['isBest' => 'desc']);
        }

        return $this->render('products/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);

    }

    #[Route('/sold', name: 'app_products_sold')]
    public function sold(ProductsRepository $productsRepository, Request $request): Response
    {

        /*Returned in JSon to be displayed using the vue.js component these are the promotions of the moment*/

        $products = $this->entityManager->getRepository(Products::class)->findByIsBest(1);

        $arrayCollection = array();
        foreach($products as $product) {
            $arrayCollection[] =array(
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'subtitle'=>$product->getSubtitle(),
            );
        }

        return new JsonResponse($arrayCollection);

    }

    #[Route('/produkt/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Products $product): Response
    {
        return $this->render('products/show.html.twig', [
            'product' => $product,
        ]);
    }
}
