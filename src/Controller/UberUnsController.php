<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UberUnsController extends AbstractController
{
    #[Route('/uber-uns', name: 'app_uber_uns')]
    public function index(): Response
    {
        return $this->render('uber_uns/index.html.twig', [
            'controller_name' => 'UberUnsController',
        ]);
    }
}
