<?php

namespace App\DTO\Sales;

use App\Http\Requests\FilterPaginatedSalesRequest;

class FilterPaginatedSalesDTO
{
    public function __construct(
        public array $saleIds,
        public $page,
        public $perPage,
        public $orderBy
    ) {
    }

    public static function makeFromRequest(FilterPaginatedSalesRequest $request): self
    {
        return new self(
            $request->input("sale_ids") ? $request->input("sale_ids") : [],
            $request->input('page') ? $request->input('page') : 1,
            $request->input('per_page') ? $request->input('per_page') : 15,
            $request->input("order_by")
        );
    }
}