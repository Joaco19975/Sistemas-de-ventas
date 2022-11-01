<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class Select2 extends Component
{
    public $products, $productSelectedId, $productSelectedName;

    public function mount()
    {
        $this->products = [];
    }

    public function render()
    {
        //esto lo hacemos para un sistema con 100 registros aprox, sino seria una manera incorecta de hacerlo, por la sobrecarga, relentizamos el sistema
        $this->products = Product::orderBy('name', 'asc')->get();

        return view('livewire.utils.select2')
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
