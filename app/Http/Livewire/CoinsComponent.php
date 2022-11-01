<?php

namespace App\Http\Livewire;


use Livewire\Component;
use App\Models\Denomination;
use Illuminate\Support\Facades\Storage; //lo necesitamos para poder manejar archivos e imagenes fdentro de nuestro proyecto
use Livewire\WithFileUploads; //trait para subir imagen al backend
use Livewire\WithPagination;

class CoinsComponent extends Component
{
 
    use WithFileUploads;
    use WithPagination;

    public $type,$value,  $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;


    public function mount()
    {
        //usualmente se usa esta funcion para inicializar propiedades o informacion que se va a renderizar en la vista principal del componente
        $this->pageTitle = 'Listado';
        $this->componentName = 'Denominations';
        $this->type='Elegir';
    }

    public function paginationView()
    {
        //vista personalizada paginate
        return 'vendor.livewire.bootstrap';
    }

   

    public function render()
    {
        if(strlen($this->search) > 0)
            $data = Denomination::where('type','like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = Denomination::orderBy('id','desc')->paginate($this->pagination);
           
        return view('livewire.denomination.coins', ['data' => $data])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    

    public function Edit($id)
    {
          // en el array pongo solo los campos necesarios para optimizar la busqueda
        $record = Denomination::findOrFail($id,['id','type','value','image']);
        $this->type = $record->type;
        $this->value = $record->value;
        $this->selected_id = $record->id;
        $this->image = null;

        //emito un evento
        $this->emit('show-modal', 'Show modal !');
    }

    public function Store()
    {
        $rules = [
            'type' => 'required|not_in:Elegi',
            'value' => 'required|unique:denominations',

        ];

        $messages = [
            'type.required' => 'Type is required',
            'type.not_in' => 'Choose a value other than the one chosen',
            'value.required' => 'Value is required',
            'value.unique' => 'Value is unique'
        ];

        $this->validate($rules, $messages);

        $denomination = Denomination::create([
           'type' => $this->type,
           'value' => $this->value
        ]);

    
        if($this->image){
            $customFileName = uniqid() . '_' . $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $denomination->image = $customFileName;
            $denomination->save();
        }

        //limpio la modal
        $this->resetUI();

        $this->emit('item-added', 'Denomination registred successfully');


    }

    public function Update()
    {
        $rules = [
            'type' => 'required|not_in:Elegi',
            'value' => "required|unique:denominations,valie,{$this->selected_id}"

        ];

        $messages = [
            'type.required' => 'Type is required',
            'type.not_in' => 'Choose a value other than the one chosen',
            'value.required' => 'Value is required',
            'value.unique' => 'Value is unique'
        ];

        $this->validate($rules, $messages);

        $denomination = Category::find($this->selected_id);
        $denomination->update([
            'type' => $this->type,
            'value' => $this->value
        ]);

        if($this->image){
            $customFileName = uniqid() . '_' . $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $imageName = $category->image ;

                $denomination->image = $customFileName;
                $denomination->save();

                    if($imageName != null){
                    
                        if(file_exist('storage/denominations/' . $imageName)){
                            unlink('storage/denominations/' . $imageName);
                        }
            
                    }
         }

         $this->resetUI();
         $this->emit('item-updated', 'Denomination updated successfully');
    }

    // $listeners para cuando el front envíe una peticion de un evento al back
    protected $listeners = [
        //tras bambalinas (en el front) se le pasa el id al Destroy 
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Denomination $denomination)
    {
        $id = $denomination->id;
        $denomination = Denomination::findOrFail($id);
       // dd($category); //printf para ver la info
        $imageName = $denomination->image;
        $denomination->delete();

         if($imageName != null){
            unlink('storage/denominations/' . $imageName);
         }

         $this->resetUI();
         $this->emit('item-deleted', 'Denomination deleted successfully');
    }

    public function resetUI()
    {
        $this->value = '';
        $this->type = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }
}
