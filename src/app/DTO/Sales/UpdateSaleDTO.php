<?php

namespace App\DTO\Sales;

use App\Http\Requests\CreateSaleRequest;

class UpdateSaleDTO
{
    public function __construct(
        public string $id,
        public array $productIds
    ) {
    }

    public static function makeFromRequest(CreateSaleRequest $request): self
    {
        return new self(
            $request->route("id"),
            $request->product_ids
        );
    }
}