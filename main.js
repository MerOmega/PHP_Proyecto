var item = document.querySelector(".wrapper");
var i = 2;
var limite= item.children.length;

for(i;i<item.children.length;i++){
        item.children[i].style.display='none';
}
i=2;

function buttonClickMore(){
    if(i<=limite){
        var j=i; /*j debe llegar hasta i*/
        j+=2;
        if((limite-j)<0 || (limite-j)==0){  // si =0 son iguales, si su resta es menor me pase
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

