<?php

namespace App\Repositories;

use App\DTO\Sales\CreateSaleDTO;
use App\DTO\Sales\FilterPaginatedSalesDTO;
use App\DTO\Sales\FilterSaleDTO;
use App\DTO\Sales\UpdateSaleDTO;
use App\Models\Sale;
use App\Repositories\Contracts\SaleRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SaleRepository implements SaleRepositoryInterface
{

    public function __construct(protected Sale $sale, protected ProductRepository $productRepository)
    {
    }

    public function create(CreateSaleDTO $createSaleDTO): Sale
    {
        $amount = $this->productRepository->sumAmountByIds($createSaleDTO->productIds);

        $sale = new Sale();
        $sale->setAmount($amount);

        $createdSale = $this->sale->create($sale->toArray());

        $createdSale->products()->attach($createSaleDTO->productIds);

        return $this->findById($createdSale->id);
    }

    public function update(string $id, UpdateSaleDTO $updateSaleDTO): Sale
    {
        $savedSale = $this->sale::find($id);
        if (!$savedSale) {
            throw new NotFoundHttpException('Que chato em, não vai dar pra atualizar a venda pq ela não existe!');
        }

        $amount = $this->productRepository->sumAmountByIds($updateSaleDTO->productIds);

        $newSale = new Sale();
        $newSale->setAmount($amount);

        $savedSale->update($newSale->toArray());
        $savedSale->products()->sync($updateSaleDTO->productIds);

        return $this->findById($savedSale->id);
    }

    public function findById(string $id): Sale
    {
        return $this->sale::with('products')
            ->find($id);
    }

    public function index(FilterPaginatedSalesDTO $filterPaginatedSalesDTO, FilterSaleDTO $filterSaleDTO): Paginator
    {
        $query = $this->sale::with('products');

        if ($filterPaginatedSalesDTO->saleIds) {
            $query->where('id', $filterPaginatedSalesDTO->saleIds);
        }

        if ($filterPaginatedSalesDTO->orderBy) {
            $query->orderBy('created_at', $filterPaginatedSalesDTO->orderBy);
        }

        $this->getQueryFilter($filterSaleDTO, $query);
        return $query->simplePaginate($filterPaginatedSalesDTO->perPage, ['*'], 'page', $filterPaginatedSalesDTO->page);
    }

    public function findByFilter(string $id, FilterSaleDTO $filterSaleDTO): Sale
    {
        $saleCount = $this->countById($id);

        if (!$saleCount) {
            throw new NotFoundHttpException('Humm pequeno padawan, esse id não existe na nossa base de dados');
        }

        $query = $this->sale::with('products');
        $this->getQueryFilter($filterSaleDTO, $query);

        return $query->findOrNew($id);
    }

    public function softDelete(string $id): void
    {
        $sale = $this->sale::find($id);

        if (!$sale) {
            throw new NotFoundHttpException('Vou apagar a venda só quando vc me enviar um UUID válido :)');
        }

        $this->softDeleteProductsSaleBySaleId($id);

        $sale->delete();
    }

    private function softDeleteProductsSaleBySaleId(string $saleId)
    {
        DB::table('product_sale')
            ->where('sale_id', $saleId)
            ->update(array('deleted_at' => DB::raw('NOW()')));
    }

    private function countById(string $id): int
    {
        return $this->sale::select('id')->where('id', $id)->count('id');
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
    }
}