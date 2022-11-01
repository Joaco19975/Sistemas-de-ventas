<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Denomination;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use DB;

class PosComponent extends Component
{
    public $total, $itemsQuantity, $efectivo, $change;

    public function mount()
    {
        $this->efectivo = 0;
        $this->change = 0;
        $this->total =  Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

    }

    public function render()
    {
       
        return view('livewire.pos.component', [
                    'denominations' => Denomination::orderBy('value','desc')->get(),
                    'cart' => Cart::getContent()->sortBy('name')
                    ])
                    ->extends('layouts.theme.app')
                    ->section('content');
    }

    public function ACash($value)
    {
        //agrega en todo momento el efectivo que estamos pulsando en la parte frontal
        //si $value es 0, clickeó en "Exacto"
        $this->efectivo = ($value == 0 ? $this->total : $value);
        $this->change = ($this->total - $this->efectivo);
    }

    protected $listeners = [
        //LECTOR DE CODIGO DE BARRAS
        'scan-code' => 'ScanCode',
        'removeItem' => 'removeItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale'
    ];

    public function ScanCode($barcode, $cant = 1)
    {
        //el primero encontrado
        $product = Product::where('barcode', $barcode)->first();

        if($pruduct == null || empty($empty))
        {
            $this->emit('scan-notfound', 'The product is not registered');
        } else {

                if($this->InCart($product)->id)
                {
                    //una vez que el producto existe, incrementamos la cantidad
                    $this->increaseQty($product->id);
                    return;
                }
                //ademas de eso, hay que validar si las existencias del producto son suficientes

                 if($product->stock < 1)
                 {
                    $this->emit('no-stock', 'Insufficient stock :(');
                    return;
                 }

                 //agregar el producto al carrito

                 Cart::add($product->id, $product->name, $product->price, $cant,$product->image);
                 $this->total = Cart::getTotal();

                 $this->emit('scan-ok','Product added');



        }
    
    }

    public function InCart($productId)
    {
        $exist = Cart::get($productId);
         if($exist)
          return true;
          else
           return false;

    }

    public function increaseQty($productId, $cant = 1)
    {
        $title = '';
        $productId = Product::find($productId);
        $exist = Cart::get($productId);
        if($exist)
         $title = 'Updated quantity';
         else
          $title = 'Added product';

          if($exist)
          {
            if($product->stock < ($cant + $exist->quantity))
            {
                $this->emit('no-stock', 'Insufficient stock :(');
                return;
            }
          }

          Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

          $this->total = Cart::getTotal();
          $this->itemsQuantity = Cart::getTotalQuantity();

          $this->emit('scanf-ok', $title);
    }

    public function updateQty($productId, $cant = 1)
    {
        //reemplaza completamente la informacion del producto EN EL CARRITO
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);

            if($exist)
                $title = 'Updated quantity';
                 else
                    $title = 'Added product';

             if($exist)
             {
                if($product->stock < $cant)
                {
                        $this->emit('no-stock', 'Insufficient stock :(');
                        return;
                }
             }

             $this->removeItem($productId);

             if($cant > 0)
             {
                Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
                    $this->total = Cart::getTotal();
                    $this->itemsQuantity = Cart::getTotalQuantity();

                    $this->emit('scanf-ok', $title);

             }

    }

    public function removeItem($productId)
    {
        Cart::remove($productId);
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Deleted product');
    }

    public function decreaseQty($productId)
    {
        $item = Cart::get($productId);
          Cart::remove($productId);

          $newQty = ($item->quantity) - 1;

            if($newQty > 0)
                Cart::add($item->id, $item->name,$item->price,$newQty, $item->attributes[0]);
            
                $this->total = Cart::getTotal();
                $this->itemsQuantity = Cart::getTotalQuantity();
        
                $this->emit('scan-ok', 'Updated quantity');
    }

    public function  clearCart()
    {
        Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Trolley empty');
    }

    public function saveSale()
    {
        if($this->total <= 0)
        {
            $this->emit('sale-error', 'add products for sale');
            return;
        }
        if($this->efectivo <= 0)
        {
            $this->emit('sale-error', 'Enter the cash');
            return;
        }
        if($this->total > $this->efectivo)
        {
            $this->emit('sale-error', 'Enter the cash');
            return;
        }

        
        //transacciones 
        DB::beginTransaction();
        try {
                $sale = Sale::create([
                    'total' => $this->total,
                    'items' => $this->itemsQuantity,
                    'cash' => $this->efectivo,
                    'change' => $this->change,
                    'user_id' => Auth()->user()->id,
                ]);

                if($sale)
                {
                    //todos los productos del carrito
                    $items = Cart::getContent();
                    foreach($items as $item){
                        SaleDetail::create([
                            'price' => $item->price,
                            'quantity' => $item->quantity,
                            'product_id' => $item->id,
                            'sale_id' => $sale->id
                        ]);

                        //update stock
                        $product = Product::find($item->id);
                        $product->stock = $product->stock - $item->quantity;
                        $product->save();
                    }
                }

                //confirmar la transaccion
                DB::commit();
                //limpiamos el carrito e inicializamos las variables
                Cart::clear();
                $this->efectivo = 0;
                $this->change = 0;
                $this->total = Cart::getTotal();
                $this->itemsQuantity = Cart::getTotalQuantity();

                $this->emit('sale-ok', 'Sale registered successfully');
                $this->emit('print-ticket', $sale->id);


        } catch (Exception $e){
            //rollback para mantener consistencia de la informacion
            DB::rollBack();
            $this->emit('sale-error', $e->getMessage());
        }
        

    }

    public function printTicket(){
        return Redirect::to("print://$sale->id");
    }

    


}
