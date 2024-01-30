<?php

namespace App\Repositories\Contracts;

use App\DTO\Sales\CreateSaleDTO;
use App\Models\Sale;

interface SaleRepositoryInterface
{
    public function create(CreateSaleDTO $createSaleDTO): Sale;

    public function findById(string $id): Sale;
}