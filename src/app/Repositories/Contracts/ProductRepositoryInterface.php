<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    public function getAll(): array;
}