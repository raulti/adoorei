<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductService
{
    public function __construct(protected ProductRepositoryInterface $productRepository)
    {
    }
    public function getAll()
    {
        return $this->productRepository->getAll();
    }
}
