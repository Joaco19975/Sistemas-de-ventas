<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Curso',
            'image' => 'https://dummyimage.com/600x400/000/fff'
        ]);
        Category::create([
            'name' => 'Tenis',
            'image' => 'https://dummyimage.com/600x400/000/fff'
        ]);
        Category::create([
            'name' => 'CELULARES',
            'image' => 'https://dummyimage.com/600x400/000/fff'
        ]);
        Category::create([
            'name' => 'Computadoras',
            'image' => 'https://dummyimage.com/600x400/000/fff'
        ]);
    }
}
