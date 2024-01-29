<?php

namespace App\Repositories;

use App\DTO\Sales\CreateSaleDTO;
use App\Models\Sale;
use App\Repositories\Contracts\SaleRepositoryInterface;

class SaleRepository implements SaleRepositoryInterface
{
    public function __construct(protected Sale $sale)
    {
    }

    public function create(CreateSaleDTO $createSaleDTO): Sale
    {
        // fazer amount service ou algo assim no model
        $createdSale = $this->sale->create(['amount' => 1020]);

        $createdSale->products()->attach($createSaleDTO->productIds);

        $sale = $this->sale::with('products')
            ->find($createdSale->id);
        return $sale;
    }
}
