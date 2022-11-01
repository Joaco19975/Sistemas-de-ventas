@include('common.modalHead')


<div class="row">

    <div class="col-sm-12">
        <div class="input-group">
               
           <div class="input-group-preprend">
                 
           <span class="input-group-text">

             <span class="fas fa-edit">

             </span>

           </span>

           </div>
 
        <!-- cuando utilizamos el lazy model si nosotros escribimos algo(input), se va a mandar al backend cuando la caja de texto pierda el foco,
            sino cada vez que escribamos un caracter se actualiza o renderiza el componente y eso incrementa la carga de peticiones hacia el
             servidor -->

           <input type="text" wire:model.lazy="name" class="form-control" placeholder="Ej: Cursos">

        </div>
           @error('name') <span class="text-danger er ">{{$message}}</span> @enderror
    </div>

    <div class="col-sm-12-mt-3">
        <div class="form-group custom-file">

            <input type="file" class="custom-file-input form-control" wire:model="image"
                    accept="image/x-png, image/jpeg, image/gif">
               
                    <label class="custom-file-label">Image {{$image}}</label>
                    @error('image') <span class="text-danger er ">{{$message}}</span> @enderror
        </div>
    </div>


</div>

@include('common.modalFooter')