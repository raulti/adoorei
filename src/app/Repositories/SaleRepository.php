<?php

namespace App\Repositories;

use App\DTO\Sales\CreateSaleDTO;
use App\DTO\Sales\FilterSaleDTO;
use App\Models\Sale;
use App\Repositories\Contracts\SaleRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;

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

    public function findById(string $id): Sale
    {
        return $this->sale::with('products')
            ->find($id);
    }

    public function index(FilterSaleDTO $filterSaleDTO): Paginator
    {
        $query = $this->sale::with('products');

        if ($filterSaleDTO->saleIds) {
            $query->where('id', $filterSaleDTO->saleIds);
        }

        $this->getQueryFilter($filterSaleDTO, $query);
        return $query->simplePaginate($filterSaleDTO->perPage, ['*'], 'page', $filterSaleDTO->page);
    }

    private function getQueryFilter(FilterSaleDTO $filterSaleDTO, Builder $query): void
    {
        if ($filterSaleDTO->productIds) {
            $query->whereHas('products', function ($query) use ($filterSaleDTO) {
                $query->where('product_id', $filterSaleDTO->productIds);
            }, '>=', 1);
        }

        if ($filterSaleDTO->startDate && !$filterSaleDTO->finalDate) {
            $query->where('created_at', '>=', $filterSaleDTO->startDate);
        }

        if ($filterSaleDTO->startDate && $filterSaleDTO->finalDate) {
            $query->whereBetween('created_at', [$filterSaleDTO->startDate, $filterSaleDTO->finalDate]);
        }

        if ($filterSaleDTO->finalizedDate) {
            $query->where('deleted_at', $filterSaleDTO->finalizedDate);
        }

        if ($filterSaleDTO->isFinalized) {
            $query->whereNotNull('deleted_at');
        }

        if ($filterSaleDTO->orderBy) {
            $query->orderBy('created_at', $filterSaleDTO->orderBy);
        }
    }
}