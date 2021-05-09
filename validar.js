var nombre = document.querySelector('input[name="nombre"]');
var apellido = document.querySelector('input[name="apellido"]');
var user = document.querySelector('input[name=user]');
var pass = document.querySelector('input[name=clave]');
var mail = document.querySelector('input[name=email]');
var tele = document.querySelector('input[name=telefono]');

function validAlfa(variable){
    var letters = /^[A-Za-z ]+$/; /*Acepta Mayusculas y espacio*/
    var esValido=true;
    var motivo;
    if(!letters.test(String(variable.value))){
        esValido=false;
        motivo='contener caracteres invalidos';
    }
    
    cartel(esValido,variable,motivo);
}

function validAlfaNum(variable){
    var lettersandNum = /^[A-Za-z0-9 ]+$/; /*Acepta Mayusculas minusculas numeros y espacio*/
    var esValido=true;
    var motivo;
    if(!lettersandNum.test(String(variable.value))){
        esValido=false;
        motivo='contener caracteres invalidos';
    }
    cartel(esValido,variable,motivo);
}

function validPass(pass){
    var string = pass.value;
    var campoAlfaMayus=/^[A-Z]$/;   
    var campoAlfaminus=/^[a-z]$/;
    var especiales = /^[0-9!@#\$%\^\&*\)\(+=._-]$/;/*Caracteres especiales aceptados*/
    var esValido=true;
    var motivo;
    var mayus=0
    var minus=0
    var num=0;
    if(string.length>=6){
        for(var i=0;i<string.length;i++){
            if(campoAlfaMayus.test(String(string[i])) ){
                mayus++;
            }else if(campoAlfaminus.test(String(string[i])) ){
                minus++;
            }else if(especiales.test(String(string[i])) ){
                num++;
            }
        }
    }else{
        esValido=false;
        motivo=' tener una longitud menor a 6 caracteres';
    }
    if((mayus==0 || minus==0 || num==0) && esValido==true ){
        esValido=false;
        motivo='No contiene todos los caracteres necesarios 1 Mayus, 1 Minus, 1 Char especial';
    }
    cartel(esValido,pass,motivo);
}

function validMail(mail){
    var campo=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/; /*aceptar 1ergrupo@2dogrupo.3ergrupo  donde el 2er grupo puede tener una extension de entre 2 y 4 chars ej .com .co etc*/
    var esValido=true;
    var motivo;
    if(!campo.test(String(mail.value))){
        esValido=false;
        motivo="formato de mail no valido";
    }
    cartel(esValido,mail,motivo);
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


    function validTelef(tel){  
            var campo=(/^[0-9]+$/); /*aceptar 1ergrupo@2dogrupo.3ergrupo  donde el 2er grupo puede tener una extension de entre 2 y 4 chars ej .com .co etc*/
            var esValido=true;
            var motivo;
            if(!campo.test(String(tel.value))){
                esValido=false;
                motivo=",ingrese solo numeros";
            }
            cartel(esValido,tel,motivo);
        
    }

//mail.parentElement.querySelector("p").removeChild(parentElement.querySelector("p"));
nombre.addEventListener('blur', function(){
    validAlfa(nombre);
})

apellido.addEventListener('blur',function(){
    validAlfa(apellido);
});

user.addEventListener('blur',function(){
    validAlfaNum(user);
})

pass.addEventListener('blur',function(){
    validPass(pass);
})

mail.addEventListener('blur',function(){
    validMail(mail);
});

tele.addEventListener('blur',function(){
    validTelef(tele);
});
/**http://www.javascriptkit.com/javatutors/redev2.shtml patrones */