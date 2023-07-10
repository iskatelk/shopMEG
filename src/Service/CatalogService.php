<?php
namespace App\Service;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductsRepository;

class CatalogService
{
    public function comments(EntityManagerInterface $em){
        return $em->getRepository(Products::class)->findAll();
    }

    public function comments2(ProductsRepository $repository,$value1,$value2,$value3,$value4,$value5){
       return $repository->findProductMix($value1,$value2,$value3,$value4,$value5);
    }

    public function comments3(ProductsRepository $repository){
       return  $repository->findProductPrice();
    }
}