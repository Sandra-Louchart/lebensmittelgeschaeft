<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\HomePicturesRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HomePicturesRepository $homePicturesRepository): Response
    {
        $pictures = $homePicturesRepository ->findAll();
        return $this->render('home/index.html.twig', [
            'pictures' => $pictures,
        ]);
    }
}
