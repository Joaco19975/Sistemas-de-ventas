<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Product;

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
                            'name' => 'Laravel',
                            'cost' => 200,
                            'price' => 350,
                            'barcode' => '75080065981',
                            'stock' => 5,
                            'alerts' => 5,       
                            'category_id' => 1,
                            'image' => 'curso.jpg',
                    ]);
                    Product::create([
                        'name' => 'RUNNING Y NIKE',
                        'cost' => 600,
                        'price' => 1500,
                        'barcode' => '75080065978',
                        'stock' => 1000,
                        'alerts' => 10,       
                        'category_id' => 2,
                        'image' => 'tenis.jpg',
                    ]);
                    Product::create([
                        'name' => 'IPHONE 11',
                        'cost' => 900,
                        'price' => 1400,
                        'barcode' => '75080065941',
                        'stock' => 1000,
                        'alerts' => 10,       
                        'category_id' => 3,
                        'image' => 'iphone11.jpg',
                    ]);
                    Product::create([
                        'name' => 'PC GAMER',
                        'cost' => 700,
                        'price' => 1000,
                        'barcode' => '75080065921',
                        'stock' => 1000,
                        'alerts' => 10,       
                        'category_id' => 4,
                        'image' => 'pcgamer.jpg',
                     ]);
    }
}
