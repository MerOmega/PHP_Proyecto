<!doctype html>
<html>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

<?php
    session_start(); 
    $nombre=$desc=$precio=$cat=$cadu=$img=0;
?>
<head>
    <title>
        Compra Barato - Perfil Usuario
    </title>
    <link rel="stylesheet" type="text/css" href="main.css?v=1.1">
    <link rel="stylesheet" type="text/css" href="panel.css?v=1.1">
    <meta name="viewport" content="width=device-width">
</head>
<body>
<header>
<!---->
 <div class="cabecera">
         <h1><a href="index.php">CompraBarato!</a></h1>
        <div class="buscador">
   
            <form action="search.php" method="POST"> 
                <input type="text" name="buscador" placeholder="Busca aqui..."> 
                <button type="submit" name="submit-search">Buscar</button>
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
    <?php
    require("BD.php");
        $id=obtenerid($_SESSION['nombredeusuario'],$conn);
        $sql="SELECT * FROM productos WHERE idUsuarioVendedor='$id' ORDER BY nombre DESC";
        $result = $conn->query($sql);
    ?>
    <div id="cont_tabla">
        <table class="tabla">
        <tr class="tabla_cabecera">
            <th>Nombre</th>
            <th >Descripcion</th>
            <th nowrap>Precio</th>
            <th>Categoria</th>
            <th>caducidad</th>
            <th>Imagen</th>
            <th>Borrar</th>    
        </tr>
        
        <div >
        <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
        ?>
            <tr class="tabla_producto">
                <td >
                <div class="scroll"  data-modal-target=#nom<?php echo $nombre ?>>
                <p><?php echo ($row["nombre"])?></p>
                </div>
                    <div class="pop" id="nom<?php echo($nombre)?>">
                        <?php $nombre++ ?>
                        <div class="pophead">
                                    <div class="titulo"> Cambio de Nombre</div>
                                    <button data-close-button class="close">&times;</button>
                        </div>
                        <div class="popbody">
                        <form name="formulario" action="panel.php" method="POST" >
                            <textarea type="text" rows="5" cols="45" name="nombre" placeholder="Ingrese nombre" ><?php echo $row["nombre"] ?></textarea><br>
                            
                            <button value="<?php echo($row["idProducto"]) ?>" type="submit" name="submit" class="boton">Cambiar</button>
                        </form>
                        </div>
                    </div>
                </div>
                </td>

                <td> 
                <div class="scroll desc" data-modal-target=#desc<?php echo $desc ?>>  
                    <p > <?php echo $row["descripcion"]?></p>
                </div>
                <div class="pop" id="desc<?php echo($desc)?>">
                        <?php $desc++ ?>
                        <div class="pophead">
                                    <div class="titulo"> Cambio de Descripcion</div>
                                    <button data-close-button class="close">&times;</button>
                        </div>
                        <div class="popbody">
                        <form name="formulario" action="panel.php" method="POST" >
                            <textarea type="text" rows="5" cols="45" name="descripcion" placeholder="Ingrese la descripcion" ><?php echo $row["descripcion"] ?></textarea>
                            <button type="submit"  value="<?php echo($row["idProducto"]) ?>"  name="submit" class="boton">Cambiar</button>
                        </form>
                        </div>
                    </div>
                </div>
                </td>

                
                <td>
                <div data-modal-target=#precio<?php echo $precio ?>>
                    <p><?php echo $row["precio"]?></p>
                </div>
                <div class="pop" id="precio<?php echo($precio)?>">
                        <?php $precio++ ?>
                        <div class="pophead">
                                    <div class="titulo"> Cambio de precio</div>
                                    <button data-close-button class="close">&times;</button>
                        </div>
                        <div class="popbody">
                        <form name="formulario" action="panel.php" method="POST" >
                        <input type="text" name="precio" placeholder="Precio"><br><br>
                            <button type="submit" value="<?php echo($row["idProducto"]) ?>"  name="submit" class="boton">Cambiar</button>
                        </form>
                        </div>
                    </div>
                </div>
                </td>


                <td> 
                <div data-modal-target=#cat<?php echo $cat ?>>
                 <p><?php echo ($row["idCategoriaProducto"])?><p>
                </div>
                    <div class="pop" id="cat<?php echo($cat)?>">
                        <?php $cat++ ?>
                        <div class="pophead">
                                    <div class="titulo"> Cambio de Categoria</div>
                                    <button data-close-button class="close">&times;</button>
                        </div>
                        <div class="popbody">
                        <form name="formulario" action="panel.php" method="POST" >
                        <div id="sorted">
                                <?php 
                                //consulta sql para obtener todas las categorias de productos
                                $sql2= "SELECT * FROM categorias_productos";?>
                                </div>
                                <?php
                                //busqueda en la bd de la consulta sql
                                $result2 = $conn->query($sql2);
                                ?>
                            </div> 
                            <div id="contenedor_categorias">
                                <select name="categorias">
                                <?php while($datos=mysqli_fetch_array( $result2 )){ ?>
                                <option value="<?php echo $datos['idCategoriaProducto'] ?>"><?php echo $datos['nombre']?></option>
                                <?php } ?>
                                </select>
                                </div> <br>
                            <button type="submit" value="<?php echo($row["idProducto"]) ?>"  name="submit" class="boton">Cambiar</button>
                        </form>
                        </div>
                    </div>
                </div>
                </td>


                <td>
                <div data-modal-target=#cadu<?php echo $cadu?>>
                    <p><?php echo $row["caducidad"] ?> </p>
                </div>
                    <div class="pop" id="cadu<?php echo($cadu)?>">
                            <?php $cadu++ ?>
                            <div class="pophead">
                                        <div class="titulo"> Cambio de fecha</div>
                                        <button data-close-button class="close">&times;</button>
                            </div>
                            <div class="popbody">
                            <form name="formulario" action="panel.php" method="POST" >
                                <input type="date" id="date" name="caducidad" min="<?php date('Y-m-d')?>" max="2099-12-31">
                                <button type="submit" value="<?php echo($row["idProducto"]) ?>"  name="submit" class="boton">Cambiar</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </td>


                <td >
                <div data-modal-target=#img<?php echo $img ?>>
                 <p><?php echo '<img src="data:image;base64,'.base64_encode($row["contenidoimagen"]).'" alt="Image" style="width="20px; height=30" >';?> </p>
                </div>
                <div>
                    <div class="pop" id="img<?php echo($img)?>">
                            <?php $img++ ?>
                            <div class="pophead">
                                        <div class="titulo"> Cambio de Imagen</div>
                                        <button data-close-button class="close">&times;</button>
                            </div>
                            <div class="popbody">
                            <form name="formularioImagen" action="panel.php"  method="POST" enctype="multipart/form-data" novalidate>
                                <input type="file"  name="uploadfile"><br><br>
                                <button type="submit" value="<?php echo($row["idProducto"]) ?>"  name="upload" class="boton">Cambiar</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </td>


                <td>
                <?php if($row["idUsuarioComprador"]==NULL){ ?> 
                <form  name="borrado" action="panel.php"  method="POST">
                <button type="submit" value="<?php echo($row["idProducto"]) ?>"  name="delete" class="boton">&times;</button> 
                </form>
                <?php }

                else {echo("Articulo Comprado!");}?></td>
            <?php 
                }
            }
            ?>
            </tr>  
        </div>
        <div id="overlay"></div>
        </table>
        
    </div>

<?php
function obtenerid($nombre,$conn){
    $sql="SELECT * FROM usuarios WHERE nombredeusuario='$nombre'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id=$row["idUsuario"];
        }

    }
    return $id;
    }

    require("userbanner.php");

    if(isset($_POST["submit"])){
        $idProd=$_POST["submit"];
        if(isset($_POST["nombre"]) && !empty($_POST["nombre"])){
            $nombre=$_POST["nombre"];
            ?> <script> console.log(<?php echo $_POST["submit"] ?>)</script> <?php
            $sql="UPDATE productos SET nombre='$nombre' WHERE idProducto='$idProd'";
            //Necesita refresh
        }else if(isset($_POST["descripcion"]) && !empty($_POST["descripcion"]) ) {
            $desc=$_POST["descripcion"];
            $sql="UPDATE productos SET descripcion='$desc' WHERE idProducto='$idProd'";
        }else if(isset($_POST["precio"]) && !empty($_POST["precio"])){
            $precio=$_POST["precio"];
            $sql="UPDATE productos SET precio='$precio' WHERE idProducto='$idProd'";
        }else if(isset($_POST["categorias"]) && !empty($_POST["categorias"])){
            $categoria=$_POST["categorias"];
            $sql="UPDATE productos SET idCategoriaProducto='$categoria' WHERE idProducto='$idProd'";
        }else if(isset($_POST["caducidad"]) && !empty($_POST["caducidad"])){
            $caducidad=$_POST["caducidad"];
            $sql="UPDATE productos SET caducidad='$caducidad' WHERE idProducto='$idProd'";
        }
        mysqli_query($conn,$sql);
        ?>
        <script>
           window.location.href = window.location.href
            </script>
        <?php
    }

    if(isset($_POST["upload"])){
        if(empty($_POST["uploadfile"])){       
        $idProd=$_POST["upload"];
            $maxsize = 400000;//400KB
            //fecha actual
            $date=date('Y-m-d');
            $id=obtenerid($_SESSION['nombredeusuario'],$conn);
            $filename = $_FILES["uploadfile"]["name"];
            
            $tmp_name = $_FILES["uploadfile"]["tmp_name"]; 
            ?><script>
             console.log(<?php echo $filename ?>);
            </script> <?php
            $allowTypes = array('jpg','png','jpeg'); 
            //obtengo la extension del archivo
            $extension= pathinfo($filename,PATHINFO_EXTENSION);
            if(in_array($extension, $allowTypes) && $_FILES["uploadfile"]["size"]<=$maxsize){
                $blob=addslashes(file_get_contents($tmp_name));
                $sql="UPDATE productos SET contenidoimagen='$blob' , tipoImagen='$extension' WHERE idProducto='$idProd'";
                mysqli_query($conn,$sql);  
            }          
    ?>
    <script>
           window.location.href = window.location.href
    </script>
    <?php
        }
    }

    if(isset($_POST["delete"])){
        $idProd = $_POST["delete"];
        $sql="DELETE FROM productos WHERE idProducto='$idProd'";
        mysqli_query($conn,$sql);
        ?> 
        <script>
           window.location.href = window.location.href
        </script>
        <?php
    }
?>

<script>
$(function(){
    var dtToday = new Date();
    
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();
    
    var maxDate = year + '-' + month + '-' + day;
    $('#date').attr('min', maxDate);
});</script>
<script type="text/javascript" src="popup.js"></script>
</main>
</body>
</html>