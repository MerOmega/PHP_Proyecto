var nombre = document.querySelector('input[name="nombre"]');
var apellido = document.querySelector('input[name="apellido"]');
function valid(event){
    if(nombre.value===""){
        alert("El nombre no puede estar vacio");
        nombre.style.border='1px solid red';
        nombre.value="";

    }
}

nombre.addEventListener('blur', function(event){
    valid(event);
})

