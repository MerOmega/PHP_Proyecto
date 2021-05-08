<?php 
                if(isset($_POST['sort'])){
                    $_SESSION['sort_user']=$_POST['sort']; 
                    procesoFiltroSort();
                }
                if(isset($_POST['categorias'])){
                    $_SESSION['category_user']=$_POST['categorias'];
                    procesoFiltroCategory($_POST['categorias']);
                }

                if(isset($_SESSION['category_user'])){
                        $categoria=$_SESSION['category_user'];
                        $string=$_SESSION['sort_user_defined'];
                        $sql= "SELECT COUNT(*)FROM productos P INNER JOIN categorias_productos C ON 
                        (P.idCategoriaProducto = C.idCategoriaProducto) $categoria $string";  
                }else{
                $string=$_SESSION['sort_user_defined'];
                $sql= "SELECT COUNT(*) FROM productos WHERE (idUsuarioComprador<=>NULL) $string";       
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

                if(isset($_SESSION['category_user'])){
                        $categoria=$_SESSION['category_user'];
                        $string=$_SESSION['sort_user_defined'];
                        $sql= "SELECT P.*FROM productos P INNER JOIN categorias_productos C ON 
                        (P.idCategoriaProducto = C.idCategoriaProducto) $categoria $string $limit";           
                }else{
                    $string= $_SESSION['sort_user_defined'];
                    $sql= "SELECT * FROM productos WHERE (idUsuarioComprador<=>NULL) $string $limit";
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