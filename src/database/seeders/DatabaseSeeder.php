<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'seller@adoorei.com.br',
            'password' => Hash::make('12345678'),
        ]);

        $this->call([
            ProductSeeder::class
        ]);
    }
}
