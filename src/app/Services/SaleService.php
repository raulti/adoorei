<?php

namespace App\Services;

use App\DTO\Sales\CreateSaleDTO;
use App\DTO\Sales\FilterSaleDTO;
use App\Repositories\Contracts\SaleRepositoryInterface;

class SaleService
{
    public function __construct(protected SaleRepositoryInterface $saleRepository)
    {
    }
    public function create(CreateSaleDTO $createSaleDTO)
    {
        return $this->saleRepository->create($createSaleDTO);
    }

    public function index(FilterSaleDTO $filterSaleDTO)
    {
        return $this->saleRepository->index($filterSaleDTO);
    }
}
