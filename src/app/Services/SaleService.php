<?php

namespace App\Services;

use App\DTO\Sales\CreateSaleDTO;
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
}
