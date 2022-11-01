<!-- wire:ignore.self Es esto lo que nos va a permitir que esta ventana modal no se cierre cada vez que el se vuelva a renderizar -->
<div>
  <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" id="theModal">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-white">
              <b>{{$componentName}}</b> | {{$selected_id > 0 ? 'EDITAR' : 'CREAR'}}
          </h5>
            <h6 class="text-center text-warning" wire:loading>
              POR FAVOR ESPERE
            </h6>
        </div>
        
        <div class="modal-body">

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

           <input type="text" wire:model.lazy="roleName" class="form-control" placeholder="Ej: Admin">

        </div>
           @error('roleName') <span class="text-danger er ">{{$message}}</span> @enderror
        </div>
    </div>
       



          <!-- data-dismiss lo que nos va a permitir es que cuando hagamos un click en el cierre la modal que estamos mostrando en ese momento para el usuario -->

         </div>
        <div class="modal-footer">

            <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info" data-dismiss="modal" >
                CERRAR
            </button>
      
            @if($selected_id < 1 ) 
            <button type="button" wire:click.prevent="CreateRole()" class="btn btn-dark close-modal">
                    GUARDAR</button>
            @else
            <button type="button" wire:click.prevent="UpdateRole()" class="btn btn-dark close-modal">
                    ACTUALIZAR</button>
            @endif

        </div>

      </div>

    </div>

  </div>
</div>