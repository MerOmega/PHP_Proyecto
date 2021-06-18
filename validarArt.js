var precio = document.querySelector("input[name=precio]");


function filtrarPrecio(precio){
    var campo=(/^[0-9.]+$/);
    var esValido=true;
    var motivo;
    precio.value=precio.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
    if(!campo.test(String(precio.value))){
        esValido=false;
        motivo=",ingrese solo numeros";
    }
    cartel(esValido,precio,motivo);
}

function cartel(valido,variable,motivo){
    if(variable.value===""){            /**En ningun caso puede estar vacio el campo asi que lo agregue en esta funcion que es mas general */
        valido=false;
        motivo='ser vacio';
    }
    if(valido===false){
        eliminarNodo(variable);
        var mensaje= "Error: No puede "+motivo;
        var child=document.createElement("p");
        child.textContent=mensaje;
        variable.parentNode.insertBefore(child,variable.nextSibling);
        variable.style.border='1px solid red';      //Si tira error marca un recuadro rojo
        variable.value="";
    }else{
        variable.style.border='1px solid black';
        eliminarNodo(variable);
    }
}

function eliminarNodo(variable){    /*Elimina el mensaje de error*/
    try{
        variable.parentElement.querySelector("p").remove(variable.parentElement.querySelector("p"));
    }
    catch(error){
            /**No hay nodo para eliminar */
    }
}

precio.addEventListener('blur',()=>{
    filtrarPrecio(precio);
});