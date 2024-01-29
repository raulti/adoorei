<?php

namespace App\DTO\Sales;

use App\Http\Requests\CreateSaleRequest;

class CreateSaleDTO
{
    public function __construct(
        public array $productIds
    ) {
    }

    public static function makeFromRequest(CreateSaleRequest $request): self
    {
        return new self(
            $request->product_ids
        );
    }
}