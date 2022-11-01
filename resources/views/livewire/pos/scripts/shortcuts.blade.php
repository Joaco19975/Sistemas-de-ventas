<?php
//nos va a permitir definir las teclas de acceso rapido para por ejemplo cancelar una venta etc
?>

<script>
    var listener = new window.keypress.Listener();
    //EVENTOS DEL TECLADO

    listener.simple_combo("f9", function(){
        livewire.emit('saveSale')
    })
    listener.simple_combo("f8", function(){
        //limpio caja de texto
        document.getElementById('cash').value = ''
        //pone el cursor en la caja
        document.getElementById('cash').focus()
    })
    listener.simple_combo("f4", function(){
        var total = parseFloat(document.getElementById('hiddenTotal').value)
        if(total > 0)
        {
            Confirm(0, 'clearCart', '¿Seguro de eliminar el carrito?')
        }else {
            noty('AGREGA PRODUCTOS A LA VENTA')
        }
       
    })

</script>