<?php

namespace App\DTO\Sales;

use App\Http\Requests\FilterPaginatedSalesRequest;
use App\Http\Requests\FilterSaleRequest;

class FilterSaleDTO
{
    public function __construct(
        public array $productIds,
        public $startDate,
        public $finalDate,
        public $finalizedDate,
        public $isFinalized,
    ) {
    }

    public static function makeFromRequest(FilterSaleRequest $request): self
    {
        return new self(
            $request->input("product_ids") ? $request->input("product_ids") : [],
            $request->input("start_date"),
            $request->input("final_date"),
            $request->input("finalized_date"),
            $request->input("is_finalized"),
        );
    }

    public static function makeFromPaginatedRequest(FilterPaginatedSalesRequest $request): self
    {
        return new self(
            $request->input("product_ids") ? $request->input("product_ids") : [],
            $request->input("start_date"),
            $request->input("final_date"),
            $request->input("finalized_date"),
            $request->input("is_finalized"),
        );
    }
}