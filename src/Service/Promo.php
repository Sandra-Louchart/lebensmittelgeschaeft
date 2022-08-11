<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;

class Promo
{
    private $entityManager;
    public function  __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

//    public function addAction($)
}