<?php

namespace App\Http\Controllers;

use App\DTO\Sales\CreateSaleDTO;
use App\DTO\Sales\FilterSaleDTO;
use App\Http\Requests\CreateSaleRequest;
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

    public function index(FilterSaleRequest $filterRequest): Response
    {
        $sales = $this->saleService->index(FilterSaleDTO::makeFromRequest($filterRequest));
        return response()->json($sales);
    }
}
