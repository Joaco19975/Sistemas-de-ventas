<?php

namespace App\Http\Livewire;


use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Storage; //lo necesitamos para poder manejar archivos e imagenes fdentro de nuestro proyecto
use Livewire\WithFileUploads; //trait para subir imagen al backend
use Livewire\WithPagination;

class CategoriesComponent extends Component
{
 
    use WithFileUploads;
    use WithPagination;

    public $name, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;


    public function mount()
    {
        //usualmente se usa esta funcion para inicializar propiedades o informacion que se va a renderizar en la vista principal del componente
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categories';
    }

    public function paginationView()
    {
        //vista personalizada paginate
        return 'vendor.livewire.bootstrap';
    }

   

    public function render()
    {
        if(strlen($this->search) > 0)
            $data = Category::where('name','like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = Category::orderBy('id','desc')->paginate($this->pagination);
           
        return view('livewire.category.categories', ['categories' => $data])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    

    public function Edit($id)
    {
          // en el array pongo solo los campos necesarios para optimizar la busqueda
        $record = Category::findOrFail($id,['id','name','image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;

        //emito un evento
        $this->emit('show-modal', 'Show modal !');
    }

    public function Store()
    {
        $rules = [
            'name' => 'required|unique:categories|min:3'
        ];

        $messages = [
            'name.required' => 'Name the category is required',
            'name.unique' => 'Name the category is unique',
            'name.min' => 'Name the category required min 3 characters'
        ];

        $this->validate($rules, $messages);

        $category = Category::create([
           'name' => $this->name
        ]);

        $customFileName;
        if($this->image){
            $customFileName = uniqid() . '_' . $this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);
            $category->image = $customFileName;
            $category->save();
        }

        //limpio la modal
        $this->resetUI();

        $this->emit('category-added', 'Category registred successfully');


    }

    public function Update()
    {
        $rules = [
            'name' => "required|min:3|unique:categories,name,{$this->selected_id}"
        ];
        $messages = [
            'name.required' => 'Name in the category is required',
            //'name.unique' => 'Name category is exist',
            'name.min' => 'Name category required min 3 characters'
        ];

        $this->validate($rules, $messages);

        $category = Category::find($this->selected_id);
        $category->update([
            'name' => $this->name
        ]);

        if($this->image){
            $customFileName = uniqid() . '_' . $this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);

                $imageName = $category->image ;
                $category->image = $customFileName;

                $category->save();

                    if($imageName != null){
                    
                        if(file_exist('storage/categories/' . $imageName)){
                            unlink('storage/categories/' . $imageName);
                        }
            
                    }
         }

         $this->resetUI();
         $this->emit('category-updated', 'Category updated successfully');
    }

    // $listeners para cuando el front envíe una peticion de un evento al back
    protected $listeners = [
        //tras bambalinas (en el front) se le pasa el id al Destroy 
        'deleteRow' => 'Destroy'
    ];

    public function Destroy($id)
    {
        $category = Category::findOrFail($id);
       // dd($category); //printf para ver la info
        $imageName = $category->image;
        $category->delete();

         if($imageName != null){
            unlink('storage/categories/' . $imageName);
         }

         $this->resetUI();
         $this->emit('category-deleted', 'Category deleted successfully');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }
}
