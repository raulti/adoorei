<?php

namespace App\Http\Controllers;

use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }

    public function index()
    {
        $allProducts = $this->productService->getAll();
        return response()->json($allProducts);
    }
}
