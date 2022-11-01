<div class="mt-5">

    <div wire:ignore>
          <select id="select2-dropdown" class="form-control">
            <option value="">Select product </option>
            @foreach($products as $p)
            <option value="{{ $p->id }}"> {{ $p->name }}</option>
            @endforeach
          </select>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    $('#select2-dropdown').select2() //inicializar
    //campuramos values cuando cambia el evento
    //we camp values ​​when the event changes
    $('#select2-dropdown').on('change', function(e){
        var pId = $('#select2-dropdown').select2("val") //get product id
        var pName = $('#select2-dropdown option:selected').text() //get product name
        //se lo mandamos al componente
        @this.set('productSelectedId', pId) //set product id selected 
        @this.set('productSelectedName', pName) //set product name selected
    });
});
</script>
