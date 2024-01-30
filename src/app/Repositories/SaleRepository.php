<?php

namespace App\Repositories;

use App\DTO\Sales\CreateSaleDTO;
use App\Models\Sale;
use App\Repositories\Contracts\SaleRepositoryInterface;

class SaleRepository implements SaleRepositoryInterface
{

    public function __construct(protected Sale $sale, protected ProductRepository $productRepository)
    {
    }

    public function create(CreateSaleDTO $createSaleDTO): Sale
    {
        $products = $this->productRepository->sumAmountByIds($createSaleDTO->productIds);

        $sale = new Sale();
        $sale->setAmount($products);

        $createdSale = $this->sale->create($sale->toArray());

        $createdSale->products()->attach($createSaleDTO->productIds);

        return $this->findById($createdSale->id);
    }

    public function findById(int $id): Sale
    {
        return $this->sale::with('products')
            ->find($id);
    }
}
