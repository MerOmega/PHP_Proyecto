<!doctype html>
<html>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

<?php 
    session_start(); 
    if(!isset($_SESSION['nombredeusuario'])){
            $_SESSION['nombredeusuario']="Invitado";
    }
    if(!isset($_SESSION['sort_user_defined'])){
        $_SESSION['sort_user_defined']='ORDER BY precio DESC';
    }

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
function procesoFiltroCategory($var1){
    if($_SESSION['category_user']=="show_all"){
        $_SESSION['category_user']='';
    }
    else{
        $_SESSION['category_user'] = "WHERE (C.nombre ='$var1') AND (P.idUsuarioComprador<=>NULL)";
    }
}

?>

<head>
    <title>
        Compra Barato
    </title>
    <link rel="stylesheet" type="text/css" href="main.css?v=1.1">
    <meta name="viewport" content="width=device-width">
</head>
<body>
<header>
<!---->
 <div class="cabecera">
         <h1>CompraBarato!</h1>
        <div class="buscador">
   
            <form > 
                <input type="search" id="query" name="b" placeholder="Busca aqui..."> 
                <button>Search</button>
            </form>
        </div>
  </div>
    <div class="main-nav">
        <nav>
                
                <div id="interfaz">
                    <a href="#">Contacto</a>
                </div>
                <div id="usuarios">
                    <a href="login.php">Iniciar Sesion</a>
                    <a href="registrar.php">Crear Cuenta</a>
                    <a href="logout.php">Log Out</a>
                </div>
        </nav>
    </div>
</header>

<main class="contenedor_main">
        <div>
            <h2>PRODUCTOS</h2>
        </div>
        <div>
        <!-- Consulta a la base-->
            <?php
                require('coneccion.php'); //enlazo la base
                ?>
                <div id="sorted">
                <?php $sql= "SELECT * FROM categorias_productos";?>
                </div>
                <?php
                $result = $conn->query($sql);
                ?>
    </div> 

        <div id="contenedor_categorias">
            <form action="index.php" method="post">
                            <select name="categorias">
                            <option value="show_all">Todas las categorias</option>
                            <?php while($datos=mysqli_fetch_array( $result )){ ?>
                            <option value="<?php echo $datos['nombre'] ?>"><?php echo $datos['nombre'] ?></option>
                            <?php } ?>
                            </select>
                <button type="submit" class="boton">Enviar</button>
            </form>
            <form action="index.php" method="post" >
                <select name="sort" >
                        <option value="precioAs">Precio Mayor a menor</option>
                        <option value="precioDesc">Precio Menor a Mayor</option>
                        <option value="fechaAs">Caducidad mas cercana</option>
                        <option value="fechaDes">Caducidad mas lejana</option>
                    </select>
                    <button type="submit" class="boton">Enviar</button>
                </form>
            
     </div>

     <div>
         <!-- Consulta a la base-->          
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
                echo "Cantidad de productos: ".$rows;
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
                    $paginCtrls.=''.$pagenum.'';
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

    </div> 


    <div class="wrapper" > 
                <?php
                if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                   ?>
                    <div class="blackbox">
                    <?php
                            echo '<img src="data:image;base64,'.base64_encode($row["contenidoimagen"]).'" alt="Image" style="width="100px; height=150" >';
                            ?>
                            <p><?php echo "Articulo: " . $row["nombre"] . " ID: ". $row['idProducto']?></p>
                            <div class="caduca"><p><?php echo $row["caducidad"] ?></p></div>
                            <div style="display: none;" class="disponible"><p><?php echo $row["idUsuarioComprador"] ?></p></div>
                            <?php echo " - Desc: " ." " . $row["descripcion"] . "-Precio:"." ".$row["precio"];   
                            ?>
                        </div>
                    <?php
                }
                } else {
                echo "0 results";
                }
                
                ?>                    
    </div>    

    <p> <?php echo $texto; ?> </p>

    <div id="pag_control" ><?php echo $paginCtrls; ?></div>
    <script type="text/javascript">  
        var sesionactual='<?php echo $_SESSION['nombredeusuario'] ?>'; 
        function cambioUsuario(){
            if(sesionactual!="Invitado"){
                $("#usuarios").replaceWith( '<div id="usuarios"> <a href="#">Hola <?php echo $_SESSION['nombredeusuario']; ?></a> <a href="logout.php">Log Out</a> </div>');
            }
        }
        cambioUsuario(sesionactual);
    </script>
    
</main>
</body>

</html>