var item = document.querySelector(".wrapper");
var limite= item.children.length;
var limiteInf = 5;
var i = limiteInf;
/*Evalua que elemento ya caduco, si estan caducados los elimina*/
evaluarCaducidad(i);
//* inicial la pagina mostrando los primeros 5 elementos de la tabla *//
for(i;i<item.children.length;i++){
        item.children[i].style.display='none';
}
i=5;

function evaluarCaducidad(index){
    var j=index;
    var caduco = document.querySelectorAll(".caduca");
    var vendido = document.querySelectorAll(".disponible");
    /*Obtengo la fecha actual */
    var today = new Date();
    var d = String(today.getDate()).padStart(2, '0');
    var m = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var y = today.getFullYear();
    today = y + '-' + m + '-' + d;
    today=today.split("-");
    

    for (j=0; j<limite;j++){
        /**Comparo la fecha convirtiendo el ultimo hijo, es decir <p> que no es visible en la pagina, lo convierto a un arreglo */
        var res=caduco[j].lastElementChild.textContent.split("-");
        var nodo = caduco[j].parentElement;
        if( parseInt( res[0]) < parseInt(today[0]) || parseInt( res[1]) < parseInt(today[1]) || parseInt( res[2]) < parseInt(today[2]) ){
            nodo.remove();  
        }else if(vendido[j].lastElementChild.textContent!=""){
            nodo.remove();
        }
    }
        limite= item.children.length;/*Actualiza la cantidad de Hijos que tiene en ese momento */
}

function buttonClickLess(){
    if(i>limiteInf){
        var j=i-limiteInf;
        if(i%5!=0){
            while( (i%5!=0) ){
                item.children[i-1].style.display='none';
                i--;
                
            }
        }else{
            for(i;i>j;i--){ 
                try{
                item.children[i-1].style.display='none';
                }catch(error){
                    console.log("Nada mas para sacar");
                }

        }
        }
    }
    
    }

function buttonClickMore(){
    if(i<=limite){
        var j=i; /*j debe llegar hasta i*/
        j+=5;
        if((limite-j)<0 || (limite-j)==0){ 
            j=limite;
        }
        for(i=0;i<j;i++){   //I recorre todo los hijos de item (ver si se puede optimizar)
                try{
                item.children[i].style.display='inline';
                }catch(error){
                    console.log("Nada mas para agregar");
                }

        }
    }
}

document.getElementById('showMore').addEventListener('click',function(){
    buttonClickMore();
});

document.getElementById('showLess').addEventListener('click',function(){
    buttonClickLess();
});

