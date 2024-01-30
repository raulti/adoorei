<?php

namespace App\Http\Controllers;

use App\DTO\Sales\CreateSaleDTO;
use App\DTO\Sales\FilterPaginatedSalesDTO;
use App\DTO\Sales\FilterSaleDTO;
use App\DTO\Sales\UpdateSaleDTO;
use App\Http\Requests\CreateSaleRequest;
use App\Http\Requests\FilterPaginatedSalesRequest;
use App\Http\Requests\FilterSaleRequest;
use App\Services\SaleService;
use Symfony\Component\HttpFoundation\Response;

class SaleController extends Controller
{
    public function __construct(protected SaleService $saleService)
    {
    }
    public function create(CreateSaleRequest $request): Response
    {
        $sale = $this->saleService->create(CreateSaleDTO::makeFromRequest($request));
        return response()->json($sale, Response::HTTP_CREATED);
    }

    public function update(CreateSaleRequest $request): Response
    {
        $id = $request->route("id");
        $sale = $this->saleService->update($id, UpdateSaleDTO::makeFromRequest($request));
        return response()->json($sale, Response::HTTP_CREATED);
    }

    public function index(FilterPaginatedSalesRequest $filterRequest): Response
    {
        $filterSaleDTO = FilterSaleDTO::makeFromPaginatedRequest($filterRequest);
        $filterPaginatedSalesDTO = FilterPaginatedSalesDTO::makeFromRequest($filterRequest);
        $sales = $this->saleService->index($filterPaginatedSalesDTO, $filterSaleDTO);
        return response()->json($sales);
    }

    public function findByFilter(FilterSaleRequest $filterRequest): Response
    {
        $id = $filterRequest->route("id");
        $sale = $this->saleService->findByFilter($id, FilterSaleDTO::makeFromRequest($filterRequest));
        return response()->json($sale);
    }

    public function delete(FilterSaleRequest $filterRequest): Response
    {
        $id = $filterRequest->route("id");
        $this->saleService->delete($id);
        return response()->noContent();
    }
}
