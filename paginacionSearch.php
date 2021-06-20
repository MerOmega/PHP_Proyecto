<?php 
//Archivo dedicado a la paginación del listado obtenido por la busqueda del usuario de un producto por nombre

                //si el orden no es definido por el usuario,
                //se guarda en una sesion un orden por defecto
                if(!isset($_SESSION['sort_user_defined'])){
                    $_SESSION['sort_user_defined']='ORDER BY precio DESC';
                }

                function procesoFiltroCategory($var1){
                    $date=date('Y-m-d');
                    //se verifica si el usuario elige nuevamente ver todos los productos
                    if($_SESSION['category_user']=="show_all"){
                       //se muestran los productos no caducados y no comprados
                        $_SESSION['category_user']="WHERE (P.idUsuarioComprador<=>NULL) AND (DATE(caducidad)>'$date')";
                    }
                    else{
                        //si no se buscará en la bd los productos de la categoria var1
                        $_SESSION['category_user'] ="WHERE (C.nombre ='$var1') AND (P.idUsuarioComprador<=>NULL) AND (DATE(caducidad)>'$date')
                        AND P.nombre LIKE  '".$_SESSION['buscador']."'";
                    }
                }


                //funcion que se encarga de obtener y
                //guardar en una sesion la condicion sql requerida para el orden elegido por el usuario
                function procesoFiltroSort(){
                    switch($_SESSION['sort_user']){
                        case "precioAs":
                            $_SESSION['sort_user_defined']='ORDER BY precio DESC';
                                    break;
                            case "precioDesc":
                                $_SESSION['sort_user_defined']='ORDER BY precio ASC';
                                break;
                            case "fechaAs":
                                $_SESSION['sort_user_defined']='ORDER BY caducidad ASC';
                                    break;
                            case "fechaDes":
                                $_SESSION['sort_user_defined']='ORDER BY caducidad DESC';
                                    break;
                    }
                } 
                //si el usuario eligió y envió un orden se guarda en la sesion sort_user  
                if(isset($_POST['sort'])){
                    $_SESSION['sort_user']=$_POST['sort']; 
                    procesoFiltroSort();  //se procesa que orden eligió el usuario
                }
                if(!isset($_SESSION['buscador'])){
                    $sql="SELECT COUNT(1) from dual WHERE false";
                }else{
                   if(isset($_POST['categorias'])){
                        //se guarda la categoria elegida en una sesion
                        $_SESSION['category_user']=$_POST['categorias'];
                        //se procesa la categoria elegida para saber cual fue
                        procesoFiltroCategory($_POST['categorias']);
                    }  
                    //verifica que este definida la categoria a buscar 
                    if(isset($_SESSION['category_user'])){
                        //guarda en las variables categoria y string las condiciones de la consulta sql
                            $categoria=$_SESSION['category_user'];
                            $string=$_SESSION['sort_user_defined'];
                            //se realiza la consulta sql para buscar en la bd los productos con la categoria solicitada y en orden
                            $sql= "SELECT COUNT(*)FROM productos P INNER JOIN categorias_productos C ON 
                            (P.idCategoriaProducto = C.idCategoriaProducto) $categoria $string";  
                    }else{
                    //si no hay una categoria seleccionada ordena por el orden definido por defecto
                    $string=$_SESSION['sort_user_defined'];
                    $search = $conn->real_escape_string($_SESSION['buscador']);
                    $date=date('Y-m-d');
                    //consulta sql que filtra los productos que no hayan sido comprados y no esten caducados, y ordenados por 
                    $sql= "SELECT COUNT(*) FROM  productos WHERE nombre LIKE '%$search%' AND (idUsuarioComprador<=>NULL) AND (DATE(caducidad)>'$date') $string";      
                    }
                      
                }     
                //obtengo la cantidad total de elementos 
                $result = $conn->query($sql);
                $row = mysqli_fetch_row($result);
               
                $rows = $row[0];
                echo "<br>Cantidad de productos: ".$rows;
                //Cantidad de elementos a mostrar
                $page_rows = 5;
                //Saco la cuenta de cuantas paginas voy a mostrar, ceil redondea
                $last = ceil($rows/$page_rows);
                //Tengo solamente una pagina para mostrar
                if($last<1){
                    $last=1;
                }
                //Arranca en la pagina 1
                $pagenum =1;
                //Filtro para que no escriban algo distinto de numeros
                if(isset($_GET['pn'])){
                    $pagenum=preg_replace('#[^0-9]#','',$_GET['pn']);
                }
                //Controla que no se salga de rango
                if($pagenum<1){
                    $pagenum=1;
                }else if($pagenum>$last){
                    $pagenum=$last;
                }
                //Saltea y muestra los proximos 5
                $saltea=($pagenum-1)*$page_rows;

                $limit = 'LIMIT ' .$saltea.','.$page_rows;
                
        

                if(!isset($_SESSION['buscador'])){
                    $sql="SELECT 1 from dual WHERE false";
                }else{
                    if(isset($_POST['categorias'])){
                        //se guarda la categoria elegida en una sesion
                        $_SESSION['category_user']=$_POST['categorias'];
                        //se procesa la categoria elegida para saber cual fue
                        procesoFiltroCategory($_POST['categorias']);
                    }  
                    //verifica que este definida la categoria a buscar 
                    if(isset($_SESSION['category_user'])){
                        //guarda en las variables categoria y string las condiciones de la consulta sql
                            $categoria=$_SESSION['category_user'];
                            $string=$_SESSION['sort_user_defined'];
                            //se realiza la consulta sql para buscar en la bd los productos con la categoria solicitada y en orden
                            $sql= "SELECT P.* FROM productos P INNER JOIN categorias_productos C ON 
                            (P.idCategoriaProducto = C.idCategoriaProducto) $categoria $string";  
                    }else{
                    //si no hay una categoria seleccionada ordena por el orden definido por defecto
                    $string=$_SESSION['sort_user_defined'];
                    $search = $conn->real_escape_string($_SESSION['buscador']);
                    $date=date('Y-m-d');
                    //consulta sql que filtra los productos que no hayan sido comprados y no esten caducados, y ordenados por 
                    $sql= "SELECT P.*  productos WHERE nombre LIKE '%$search%' AND (idUsuarioComprador<=>NULL) AND (DATE(caducidad)>'$date') $string";      
                    }
                }
                $result = $conn->query($sql);
                $texto="Pagina <b>$pagenum</b> of <b>$last</b>";
                $paginCtrls='';

                

                //mas de 1 pagina
                if($last!=1){
                    if($pagenum>1){
                        $previo = $pagenum-1;
                        $paginCtrls .='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previo.'">Previo</a>';
                        
                        for($i=$pagenum-2;$i<$pagenum;$i++){
                            if($i>0){
                                $paginCtrls .='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a>';
                        
                            }
                        }

                    }
                    $paginCtrls.='<p>'.$pagenum.'</p>';
                    for($i=$pagenum+1;$i<=$last;$i++){
                        $paginCtrls .='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a>';
                            if($i>=$pagenum+2){
                                break;
                            }
                    }
                    if($pagenum!=$last){
                        $next =$pagenum+1;
                         $paginCtrls .='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">Siguiente</a>';

                    }
                }
                
?>