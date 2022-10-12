<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'LARAVEL Y LIVEWIRE',
            'cost' => 200000,
            'price' => 350000,
            'barcode' => '75010065987',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png',
        ]);

        Product::create([
            'name' => 'RUNNING NIKE',
            'cost' => 280000,
            'price' => 350000,
            'barcode' => '76010065987',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 2,
            'image' => 'tenis.png',
        ]);

        Product::create([
            'name' => 'IPHONE 11',
            'cost' => 1900000,
            'price' => 2500000,
            'barcode' => '77010065987',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 3,
            'image' => 'iphone11.png',
        ]);

        Product::create([
            'name' => 'PC GAMER',
            'cost' => 7900000,
            'price' => 13500000,
            'barcode' => '70010065987',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 4,
            'image' => 'pcgamer.png',
        ]);
    }
}
