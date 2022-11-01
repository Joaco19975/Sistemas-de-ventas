<?php
namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage; //lo necesitamos para poder manejar archivos e imagenes fdentro de nuestro proyecto
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

//use Illuminate\Support\Facades\Storage; //lo necesitamos para poder manejar archivos e imagenes fdentro de nuestro proyecto
use Livewire\WithFileUploads; //trait para subir imagen al backend
use Livewire\WithPagination;

class ProductsComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $barcode, $cost, $price, $stock, $alerts, $categoryid, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        //inicializando data
        $this->pageTitle = 'Listado';
        $this->componentName = 'Products';
        $this->categoryid = 'Elegir';
    }

    public function render()
    {
                         //
        if(strlen($this->search) > 0)   
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                                ->select('products.*', 'c.name as category')
                                ->where('products.name', 'like', '%' . $this->search . '%')
                                ->orWhere('products.barcode', 'like', '%' . $this->search . '%')
                                ->orWhere('c.name', 'like', '%' . $this->search . '%')
                                ->orderBy('products.name', 'asc')
                                ->paginate($this->pagination);
                 

                        else
                                $products = Product::join('categories as c', 'c.id', 'products.category_id')
                                ->select('products.*','c.name as category')
                                ->orderBy('products.name', 'asc')
                                ->paginate($this->pagination);
                            


                return view('livewire.product.products', ['data' => $products,
                                'categories' => Category::orderBy('name','asc')->get()
                                ])
                                ->extends('layouts.theme.app')
                                ->section('content');

    }

    public function Store()
    {
       $rules = [
            'name' => 'required|unique:products|min:3',
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'categoryid' => 'required|not_in:Elegir'

        ];

        $messages = [
            'name.required' => 'Required product name',
            'name.unique' => 'Product name already exists',
            'name.min' => 'Name needs a minimum of 3 characters',
            'cost.required' => 'Required product cost',
            'price.required' => 'Required product price',
            'stock.required' => 'Required product stock',
            'alerts.required' => 'Enter the minimum value in stock',
            'categoryid.not_in' => 'choose a category name other than Choose'
        ];

        $this->validate($rules, $messages);

        //del lado izquierdo estan los valores de los campos en la base de datos
        $product = Product::create([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->categoryid
        ]);

        $customFileName;
        if($this->image)
        {
            //guardamos archivo en disco
            $customFileName = uniqid() . '_' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName); //storeAs para personalizar nombre de los archivos
            $product->image = $customFileName;
            //guardamos en base de datos
            $product->save();
        }

        $this->resetUI();
        $this->emit('product-added', 'Product Added');

    }
    public function Edit(Product $product)
    {
        $this->selected_id = $product->id;
        $this->name = $product->name;
        $this->barcode = $product->barcode;
        $this->cost = $product->cost;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->alerts = $product->alerts;
        $this->categoryid = $product->category_id;
        $this->image = null;

        $this->emit('modal-show', 'Show modal');

    }
    public function Update()
    {
       $rules = [
            'name' => 'required|min:3|unique:products,name,{$this->selected_id}' ,
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'categoryid' => 'required|not_in:Elegir'

        ];

        $messages = [
            'name.required' => 'Required product name',
            'name.unique' => 'Product name already exists',
            'name.min' => 'Name needs a minimum of 3 characters',
            'cost.required' => 'Required product cost',
            'price.required' => 'Required product price',
            'stock.required' => 'Required product stock',
            'alerts.required' => 'Enter the minimum value in stock',
            'categoryid.not_in' => 'choose a category name other than Choose'
        ];

        $this->validate($rules, $messages);

        $product = Product::find($this->selected_id);
        //del lado izquierdo estan los valores de los campos en la base de datos
        $product->update([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->categoryid
        ]);

        $customFileName;
        if($this->image)
        {
            //guardamos archivo en disco
            $customFileName = uniqid() . '_' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName); //storeAs para personalizar nombre de los archivos
            $imageTemp = $product->image;
            $product->image = $customFileName;
            
            $product->save();
            //necesitamos borrarla del disco local
            //guardamos de forma temporal la imagen anterior por si el usuario ha actualizado a otra imagen
            
            if($imageTemp != null)
            {
                if(file_exists('storage/products/' . $imageTemp)){
                    unlink('storage/products/' . $imageTemp);
                }
            }
            
        }

        $this->resetUI();
        $this->emit('product-updated', 'Product updated');

    }

    public function resetUI()
    {
        $this->search = '';
        $this->name = '';
        $this->barcode = '';
        $this->cost = '';
        $this->price = '';
        $this->stock = '';
        $this->alerts = '';
        $this->categoryid = 'Elegir';
        $this->image = null;
        $this->selected_id = 0 ;

    }
    
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Product $product)
    {
        $imageTemp = $product->image ;
        $product->delete();

         if($imageTemp != null)
         {
            if(file_exists('storage/products/' . $imageTemp)){
                unlink('storage/products/' . $imageTemp);
            }
         }

         $this->resetUI();
         $this->emit('product-deleted', 'Product deleted');
         
    }



}
