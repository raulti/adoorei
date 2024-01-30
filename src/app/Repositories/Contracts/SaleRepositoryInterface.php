<?php

namespace App\Repositories\Contracts;

use App\DTO\Sales\CreateSaleDTO;
use App\DTO\Sales\FilterSaleDTO;
use App\Models\Sale;
use Illuminate\Pagination\Paginator;

interface SaleRepositoryInterface
{
    public function create(CreateSaleDTO $createSaleDTO): Sale;

    public function findById(string $id): Sale;

    public function index(FilterSaleDTO $filterSaleDTO): Paginator;
}