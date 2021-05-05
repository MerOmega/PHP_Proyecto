var nombre = document.querySelector('input[name="nombre"]');
var apellido = document.querySelector('input[name="apellido"]');
var user = document.querySelector('input[name=user]');
var pass = document.querySelector('input[name=clave]');
var mail = document.querySelector('input[name=email]');

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
    var lettersandNum = /^[A-Za-z0-9 ]+$/; /*Acepta Mayusculas y espacio*/
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
    var especiales = /^[0-9!@#\$%\^\&*\)\(+=._-]$/;
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
    if(mayus==0 || minus==0 || num==0){
        esValido=false;
        motivo='No contiene todos los caracteres necesarios';
    }
    cartel(esValido,pass,motivo);
}

function validMail(mail){
    var campo=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
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
        alert("Error: No puede "+motivo);
        variable.style.border='1px solid red';
        variable.value="";
    }else{
        variable.style.border='1px solid black';
    }
}

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

/**http://www.javascriptkit.com/javatutors/redev2.shtml patrones */