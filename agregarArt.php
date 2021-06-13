<!doctype html>
<html>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

<?php
    session_start(); 
?>
<head>
    <title>
        Compra Barato - Perfil Usuario
    </title>
    <link rel="stylesheet" type="text/css" href="main.css?v=1.1">
    <link rel="stylesheet" type="text/css" href="agregart.css?v=1.1">
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
    ?>
    <h2>Agregue su producto!</h2>
    <form id="addprod" style="text-align:center;" name="registro" action="agregarArt.php" method="POST"  enctype="multipart/form-data" novalidate>
        <label>Titulo de su publicacion</label><br>
        
        <input type="text" name="titulo" placeholder="Ingrese titulo del producto"><br><br>

        <label>Seleccione categoria</label><br>
        <div id="sorted">
                <?php 
                //consulta sql para obtener todas las categorias de productos
                $sql= "SELECT * FROM categorias_productos";?>
                </div>
                <?php
                //busqueda en la bd de la consulta sql
                $result = $conn->query($sql);
                ?>
    </div> 
        <!--Fomulario seleccionador para elegir categorias-->
        <div id="contenedor_categorias">
                            <select name="categorias">
                            <?php while($datos=mysqli_fetch_array( $result )){ ?>
                            <option value="<?php echo $datos['idCategoriaProducto'] ?>"><?php echo $datos['nombre']?></option>
                            <?php } ?>
                            </select>
        </div> <br>
        <label>Descripcion del producto</label><br>
        <textarea type="text" rows="5" cols="60" name="descripcion" placeholder="Ingrese la descripcion" ></textarea><br>
        <label>Precio $:</label>
        <input type="text" name="precio" style="margin-left: 10px;">
        <br><br>
        <input type="date" id="date" name="caducidad" min="<?php date('Y-m-d')?>" max="2099-12-31">
        <br><br>
        <input type="file"  name="uploadfile"><br><br>
        <button type="submit" name="upload">Agregar!</button>
    </form>
    
<?php 
 require("userbanner.php");
 if (isset($_POST['upload'])) {
        if( cumple() ){
        $nombre=$_POST["titulo"];
        $desc=$_POST["descripcion"];
        $idcat=$_POST["categorias"];
        $precio=$_POST["precio"];
        $caducidad=$_POST["caducidad"];
        //fecha actual
        $date=date('Y-m-d');
        $id=obtenerid($_SESSION['nombredeusuario'],$conn);
        $filename = $_FILES["uploadfile"]["name"];
        $tmp_name = $_FILES["uploadfile"]["tmp_name"]; 
        $allowTypes = array('jpg','png','jpeg'); 
        //obtengo la extension del archivo
        $extension= pathinfo($filename,PATHINFO_EXTENSION);
        if(in_array($extension, $allowTypes)){
            $folder = "image/".$filename;
            $blob=addslashes(file_get_contents($tmp_name));
            $sql="INSERT INTO productos (idCategoriaProducto, idUsuarioVendedor, nombre, descripcion, precio, publicacion,caducidad,contenidoimagen,tipoImagen)
            VALUES ('$idcat','$id','$nombre','$desc','$precio','$date','$caducidad','$blob','$extension')";
            mysqli_query($conn,$sql);
        }else{
            echo("Formato de archivo no valido");
        }
    
    }
    else{
        echo("No puede haber campos en blanco");
    }
}
?>
   
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

    function cumple(){
        $existe=true;
        if((!empty($_POST["titulo"]) && !empty($_POST["descripcion"]) && !empty($_POST["categorias"]) && !empty($_POST["precio"]) && !empty($_POST["caducidad"]) && !empty($_POST["uploadfile"])  ) ){
            $existe=false;
        }
        return $existe;
    }

?>
<!-- Bloquea los dias anteriores al actual donde selecciono la fecha -->
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

</main>
</body>
</html>