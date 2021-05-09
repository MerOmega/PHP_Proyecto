<?php 
//archivo dedicado a la paginacion de los productos luego de filtrar por categoria o al realizar un orden

               //si el usuario seleccionó un orden, verifica que lo hizo
               if(isset($_POST['sort'])){
                 //se guarda el orden seleccionado en una sesion  
                    $_SESSION['sort_user']=$_POST['sort'];
                    //se procesa el orden enviado para saber cual fue 
                    procesoFiltroSort();
                }
                //si el usuario seleccionó una categoria, verifica que lo hizo
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
                $date=date('Y-m-d');
                //consulta sql que filtra los productos que no hayan sido comprados y no esten caducados, y ordenados por 
                $sql= "SELECT COUNT(*) FROM productos WHERE (idUsuarioComprador<=>NULL) AND (DATE(caducidad)>'$date') $string";       
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

                //se fija si hay una categoria seleccionada
                if(isset($_SESSION['category_user'])){
                        $categoria=$_SESSION['category_user'];
                        $string=$_SESSION['sort_user_defined'];
                        //realiza la consulta y los limita para mostrar 5 por pagina
                        $sql= "SELECT P.*FROM productos P INNER JOIN categorias_productos C ON 
                        (P.idCategoriaProducto = C.idCategoriaProducto) $categoria $string $limit";           
                }else{
                    $string= $_SESSION['sort_user_defined'];
                    $date=date('Y-m-d');
                    //realiza la consulta y los limita para mostrar 5 por pagina
                    $sql= "SELECT * FROM productos WHERE (idUsuarioComprador<=>NULL) AND (DATE(caducidad)>'$date') $string $limit";
                }
                
                $result = $conn->query($sql); //resultado de la consultado procesado en el index.php
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