<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(protected Product $product)
    {
    }

    public function getAll(): array
    {
        return $this->product::All()->toArray();
    }

    public function sumAmountByIds(array $ids): float
    {
        return $this->product::select('price')->findMany($ids)->sum('price');
    }
}
