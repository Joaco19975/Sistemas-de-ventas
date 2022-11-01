
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