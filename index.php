<!doctype html>
<html>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

<?php session_start(); 
    if(!isset($_SESSION['nombredeusuario'])){
            $_SESSION['nombredeusuario']="Invitado";
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
                        <option value="">Todas las categorias</option>
                        <?php while($datos=mysqli_fetch_array( $result )){ ?>
                        <option value="<?php echo $datos['nombre'] ?>"><?php echo $datos['nombre'] ?></option>
                        <?php } ?>
                        </select>
            <button type="submit" name="seleccion" class="boton">Enviar</button>
        </form>
        
            
        <form>
        <select id="sort">
                <option value="precioAs">Precio Mayor a menor</option>
                <option value="precioDesc">Precio Menor a Mayor</option>
                <option value="fechaAs">Caducidad mas cercana</option>
                <option value="fechaDes">Caducidad mas lejana</option>
            </select>
            <button type="submit" name="seleccion_filtro" class="boton">Enviar</button>
         </form>
     </div>

     <div>
        <!-- Consulta a la base-->
                
                <?php                 
                
                $sql= "SELECT COUNT(*) FROM productos ORDER BY idProducto";
               

                $result = $conn->query($sql);
                $row = mysqli_fetch_row($result);
               
                $rows = $row[0];
                $page_rows = 5;
                $last = ceil($rows/$page_rows);
                if($last<1){
                    $last=1;
                }
                $pagenum =1;
                if(isset($_GET['pn'])){
                    $pagenum=preg_replace('#[^0-9]#','',$_GET['pn']);
                }

                if($pagenum<1){
                    $pagenum=1;
                }else if($pagenum>$last){
                    $pagenum=$last;
                }
                $limit = 'LIMIT ' .($pagenum-1)*$page_rows.','.$page_rows;

                $sql= "SELECT * FROM productos ORDER BY idProducto $limit";
                
                $result = $conn->query($sql);
                $texto="Pagina <b>$pagenum</b> of <b>$last</b>";
                $paginCtrls='';
                //mas de 1 pagina
                if($last!=1){
                    if($pagenum>1){
                        $previo = $pagenum-1;
                        $paginCtrls .='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previo.'">Previo</a> &nbsp; &nbsp; ';
                        
                        for($i=$pagenum-2;$i<$pagenum;$i++){
                            if($i>0){
                                $paginCtrls .='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
                        
                            }
                        }

                    }
                    $paginCtrls.=''.$pagenum.' &nbsp; ';
                    for($i=$pagenum+1;$i<=$last;$i++){
                        $paginCtrls .='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
                            if($i>=$pagenum+2){
                                break;
                            }
                    }
                    if($pagenum!=$last){
                        $next =$pagenum+1;
                        $paginCtrls .='&nbsp; &nbsp;<a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">Siguiente</a> &nbsp; ';
                        
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