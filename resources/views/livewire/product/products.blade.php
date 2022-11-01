<div class="row sales layout-top-spacing">

    <div class="col-sm-12">

        <div class="widget widget-chart-one">

            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
                    </li>
                </ul>
             </div>
            
                 @include('common.searchbox')

                 <div class="widget-content">

                   <div class="table-responsive">

                    <table class="table table-bordered table striped mt-1">

                       <thead class="text-white" style="background:#3b3f5c">

                         <tr>
                            <th class="table-th text-white ">DESCRIPTION</th>
                            <th class="table-th text-white text-center">BARCODE</th>
                            <th class="table-th text-white text-center">CATEGORY</th>
                            <th class="table-th text-white text-center">PRICE</th>
                            <th class="table-th text-white text-center">STOCK</th>
                            <th class="table-th text-white text-center">INV. MIN</th>
                            <th class="table-th text-white text-center">IMAGE</th>
                            <th class="table-th text-white text-center">ACTIONS</th>
                         </tr>
                    
                        </thead>

                        <tbody>

                         @foreach($data as $product)

                            <tr>

                                <td><h6 class="text-left">{{$product->name}}</h6></td>
                                <td><h6 class="text-center">{{$product->barcode}}</h6></td>
                                <td><h6 class="text-center">{{$product->category}}</h6></td>
                                <td><h6 class="text-center">{{$product->price}}</h6></td>
                                <td><h6 class="text-center">{{$product->stock}}</h6></td>
                                <td><h6 class="text-center">{{$product->alerts}}</h6></td>
                                <td class="text-center">
                                    <span>
                                        <img src="{{ asset('storage/products/' . $product->imagen) }}" alt="" height="70" width="80" class="rounded">
                                    </span>
                                </td>

                                <td class="text-center">
                                    <a href="javascript:void(0)" 
                                    wire:click.prevent="Edit({{$product->id}})"
                                    class="btn btn-dark mtmobile" title="Edit">
                                        <i class="fas fa-edit"></i>-
                                    </a>
                                    <a href="javascript:void(0)"
                                    onclick="Confirm('{{$product->id}}')"
                                     class="btn btn-dark " title="Delet">
                                        <i class="fas fa-trash"></i>-
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                    {{$data->links()}}
              
                   </div>

                 </div>

        </div>

    </div>

    @include('livewire.product.form')

</div>

<script>
 //   Listo para poder escuchar los eventos dentro de nuestro front emitidos desde el back cuando nuestro DOM este listo

 document.addEventListener('DOMContentLoaded', function(){
          //Disponible para cuando escuchemos los eventos que se emiten desde los controladores poderlos agarrar acá
            //El objeto window representa la ventana que contiene un documento DOM; la propiedad document apunta al DOM document cargado en esa ventana
            window.livewire.on('product-added', msg =>{
                $('#TheModal').modal('hide'); //hiden para que se cierre la modal
            });
            window.livewire.on('product-updated', msg =>{
                $('#TheModal').modal('hide'); //hiden para que se cierre la modal
            });
            window.livewire.on('product-deleted', msg =>{
                //noty
            });
            window.livewire.on('modal-show', msg =>{
                $('#theModal').modal('show');
            });
            window.livewire.on('modal-hide', msg =>{
                $('#theModal').modal('hide');
            });
            $('#theModal').on('hidden.bs.modal', function(e) {
                //todos los elementos con la clase er
                $('.er').css('display','none');
            });



 });


        function Confirm(id){
                //PROMESAS
                swal({
                    title: 'Confirm',
                    text: 'Confirm delete this record?',
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Close',
                    cancelButtonColor: '#fff',
                    confirmButtonColor: '#3B3F5C',
                    confirmButtonText: 'Accept'
                }).then(function(result){
                    //then significa "Cuando se resuelva", osea cuando alguien toque el boton "Accept"
                    //validamos el resultado
                    //si tiene un valor el resultado (si confirma)
                    if(result.value){
                        window.livewire.emit('deleteRow', id)
                        swal.close()
                    }
                })
            }


</script>