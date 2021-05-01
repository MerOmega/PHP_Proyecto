var item = document.querySelector(".wrapper");
var limite= item.children.length;
var limiteInf = 5;

var i = limiteInf;
for(i;i<item.children.length;i++){
        item.children[i].style.display='none';
}
i=5;

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

