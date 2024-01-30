<?php

namespace App\Repositories\Contracts;

use App\DTO\Sales\CreateSaleDTO;
use App\DTO\Sales\FilterPaginatedSalesDTO;
use App\DTO\Sales\FilterSaleDTO;
use App\DTO\Sales\UpdateSaleDTO;
use App\Models\Sale;
use Illuminate\Pagination\Paginator;

interface SaleRepositoryInterface
{
    public function create(CreateSaleDTO $createSaleDTO): Sale;

    public function findById(string $id): Sale;

    public function index(FilterPaginatedSalesDTO $filterPaginatedSalesDTO, FilterSaleDTO $filterSaleDTO): Paginator;

    public function findbyFilter(string $id, FilterSaleDTO $filterSaleDTO): Sale;

    public function softDelete(string $id): void;

    public function update(string $id, UpdateSaleDTO $createSaleDTO): Sale;

}