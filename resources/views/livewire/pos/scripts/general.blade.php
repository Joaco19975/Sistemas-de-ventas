<script>
    $('.tblscroll').nicescroll({
        cursorcolor: "#515365",
        cursorwidth: "30px",
        background: "rgba(20, 20, 20, 0.3)",
        cursorborder: "0px",
        cursorborderradius: 3
    })


    function Confirm(id, eventName, text){

     /*   if(products > 0)
        {
            swal('NO SE PUEDE ELIMINAR LA CATEGORIA PORQUE TIENE PRODUCTOS RELACIONADOS');
            return;
        }*/

            //PROMESAS
            swal({
                title: 'Confirm',
                text: 'Confirm delete this record?',
                type: text,
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
                    window.livewire.emit(eventName, id)
                    swal.close()
                }
            })
        }
</script>