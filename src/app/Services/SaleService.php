<?php

namespace App\Services;

use App\DTO\Sales\CreateSaleDTO;
use App\DTO\Sales\FilterPaginatedSalesDTO;
use App\DTO\Sales\FilterSaleDTO;
use App\DTO\Sales\UpdateSaleDTO;
use App\Repositories\Contracts\SaleRepositoryInterface;
use App\Utils\StringUtils;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class SaleService
{
    public function __construct(protected SaleRepositoryInterface $saleRepository)
    {
    }
    public function create(CreateSaleDTO $createSaleDTO)
    {
        if (!$createSaleDTO?->productIds) {
            throw new UnprocessableEntityHttpException('Uai só, tem que informar os dados pra nois salvar né ;(');
        }

        return $this->saleRepository->create($createSaleDTO);
    }

    public function update(string $id, UpdateSaleDTO $updateSaleDTO)
    {
        if (StringUtils::isEmpty($id) || !$updateSaleDTO?->productIds) {
            throw new UnprocessableEntityHttpException('Uai só, tem que informar os dados pra nois fazer os update né ;(');
        }

        return $this->saleRepository->update($id, $updateSaleDTO);
    }

    public function index(FilterPaginatedSalesDTO $filterPaginatedSalesDTO, FilterSaleDTO $filterSaleDTO)
    {
        return $this->saleRepository->index($filterPaginatedSalesDTO, $filterSaleDTO);
    }

    public function findbyFilter(string $id, FilterSaleDTO $filterSaleDTO)
    {
        if (StringUtils::isEmpty($id)) {
            throw new UnprocessableEntityHttpException('Informa o ID aeee :)');
        }

        return $this->saleRepository->findbyFilter($id, $filterSaleDTO);
    }

    public function delete(string $id)
    {
        if (StringUtils::isEmpty($id)) {
            throw new UnprocessableEntityHttpException('Vc não vai conseguir fazer isso, desista!');
        }

        return $this->saleRepository->softDelete($id);
    }
}
