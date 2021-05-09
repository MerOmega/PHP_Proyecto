<?php 
//Archivo dedicado a la paginación del listado obtenido por la busqueda del usuario de un producto por nombre

                //si el orden no es definido por el usuario,
                //se guarda en una sesion un orden por defecto
                if(!isset($_SESSION['sort_user_defined'])){
                    $_SESSION['sort_user_defined']='ORDER BY precio DESC';
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
                
                $string=$_SESSION['sort_user_defined'];
                $search = $conn->real_escape_string($_SESSION['buscador']);
                $date=date('Y-m-d');
                //consulta sql que busca en la bd 
                $sql= "SELECT COUNT(*) FROM  productos WHERE nombre LIKE '%$search%' AND (idUsuarioComprador<=>NULL) AND (DATE(caducidad)>'$date') $string";       
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

                
                $string= $_SESSION['sort_user_defined'];
                $search = $conn->real_escape_string($_SESSION['buscador']);
                echo "$date";
                $sql= "SELECT * FROM  productos WHERE nombre LIKE '%$search%' AND (idUsuarioComprador<=>NULL) AND (DATE(caducidad)>'$date') $string $limit";
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