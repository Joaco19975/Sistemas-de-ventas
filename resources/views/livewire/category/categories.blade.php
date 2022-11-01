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
                            <th class="table-th text-dark text-white ">DESCRIPTION</th>
                            <th class="table-th text-dark text-white ">IMAGE</th>
                            <th class="table-th text-dark text-white ">ACTIONS</th>
                         </tr>
                    
                        </thead>

                        <tbody>
                            @foreach($categories as $category)

                            <tr>

                                <td><h6 class="text-center">{{$category->name}}</h6></td>
                                <td class="text-center">
                                    <span>
                                        <img src="{{ asset('storage/categories/' . $category->imagen) }}" alt="" height="70" width="80" class="rounded">
                                    </span>
                                </td>

                                <td class="text-center">

                                    <a href="javascript:void(0)"
                                     wire:click="Edit({{$category->id}})"
                                     class="btn btn-dark mtmobile"
                                     title="Edit">
                                    <!--    <i class="fas fa-edit"></i>-->
                                    </a>
                                    <!--   veo cada categoria cuantos productos asociados tiene  usando $category->products->count() -->
                                        <a href="javascript:void(0)"
                                            onClick="Confirm('{{$category->id}}', 
                                            {{$category->products->count()}} )"
                                            class="btn btn-dark"
                                            title="Delete">
                                        <!--  <i class="fas fa-trash"></i> -->
                                        </a>
                             
                                        {{$category->imagen}}

                                </td>

                            </tr>
                           @endforeach

                           
                        </tbody>

                    </table>
                    
                    <!-- GENERO PAGINACION -->
                    {{$categories->links()}}
              
                   </div>

                 </div>

        </div>

    </div>

    @include('livewire.category.form')

</div>

<script>
 //   Listo para poder escuchar los eventos dentro de nuestro front emitidos desde el back cuando nuestro DOM este listo

        document.addEventListener('DOMContentLoaded', function() {
            //Disponible para cuando escuchemos los eventos que se emiten desde los controladores poderlos escucharlos acá
            //El objeto window representa la ventana que contiene un documento DOM; la propiedad document apunta al DOM document cargado en esa ventana
            window.livewire.on('show-modal', msg =>{
                $('#theModal').modal('show');
                noty(msg)
            });
            window.livewire.on('category-added', msg =>{
                $('#TheModal').modal('hide'); //hiden para que se cierre la modal
                noty(msg)
            });
            window.livewire.on('category-updated', msg =>{
                $('#TheModal').modal('hide'); //hiden para que se cierre la modal
                noty(msg)
            });



                });

                
 function Confirm(id, products){
    if(products > 0 ){
        console.log("NO SE PUEDE ELIMINAR CATEGORIYA CON PRODUCTO ASOCIADO")
        return
    }
    
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
