<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert(
            [
                [
                    'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                    'name' => 'Celular 1',
                    'description' => 'Lorenzo Ipsulum',
                    'price' => 1800,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                    'name' => 'Celular 2',
                    'description' => 'Lorem ipsum dolor',
                    'price' => 3200,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                    'name' => 'Celular 3',
                    'description' => 'Lorem ipsum dolor sit amet',
                    'price' => 9800,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]
            ]
        );
    }
}
