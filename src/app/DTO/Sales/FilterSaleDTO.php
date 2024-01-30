<?php

namespace App\DTO\Sales;

use App\Http\Requests\FilterSaleRequest;

class FilterSaleDTO
{
    public function __construct(
        public array $productIds,
        public array $saleIds,
        public $startDate,
        public $finalDate,
        public $finalizedDate,
        public $isFinalized,
        public $page,
        public $perPage,
        public $orderBy
    ) {
    }

    public static function makeFromRequest(FilterSaleRequest $request): self
    {
        return new self(
            $request->input("product_ids") ? $request->input("product_ids") : [],
            $request->input("sale_ids") ? $request->input("sale_ids") : [],
            $request->input("start_date"),
            $request->input("final_date"),
            $request->input("finalized_date"),
            $request->input("is_finalized"),
            $request->input('page') ? $request->input('page') : 1,
            $request->input('per_page') ? $request->input('per_page') : 15,
            $request->input("order_by")
        );
    }
}