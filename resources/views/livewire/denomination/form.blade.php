@include('common.modalHead')


<div class="row">
<div class="col-sm-12 col-md-6">
    <div class="form-group">
    <label for="">Type</label>
    <select wire:model="type" class="form-control">
        <option value="Elegir">Elegir</option>
        <option value="BILLETE">BILLETE</option>
        <option value="MONEDA">MONEDA</option>
        <option value="OTRO">OTRO</option>
    </select>
    @error('type') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>
</div>
    <div class="col-sm-12 col-md6">
         <label >Value</label>
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

           <input type="number" wire:model.lazy="value" class="form-control" placeholder="Ej: $100">

        </div>
           @error('value') <span class="text-danger er ">{{$message}}</span> @enderror
    </div>

    <div class="col-sm-12">
        <div class="form-group custom-file">

            <input type="file" class="custom-file-input form-control" wire:model="image"
                    accept="image/x-png, image/jpeg, image/gif">
               
                    <label class="custom-file-label">Image {{$image}}</label>
                    @error('image') <span class="text-danger er ">{{$message}}</span> @enderror
        </div>
    </div>


</div>

@include('common.modalFooter')