
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
                            <option value="<?php echo $datos['nombre'] ?>"><?php echo $datos['nombre'] ?></option>
                            <?php } ?>
                            </select>
        </div> <br>
        <label>Descripcion del producto</label><br>
        <textarea type="text" rows="5" cols="60" name="descripcion" placeholder="Ingrese la descripcion" ></textarea><br><br>
        <input type="file"  name="uploadfile"><br><br>
        <button type="submit" name="upload">Agregar!</button>
    </form>
    
<?php 
 require("userbanner.php");
 if (isset($_POST['upload'])) {
 
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];   
        $folder = "image/".$filename;
    $sql="INSERT INTO productos (idProducto, idCategoriaProducto, idUsuarioVendedor, idUsuarioComprador, nombre, descripcion, precio, publicacion,caducidad,contenidoimagen,tipoImagen) VALUES ('24', '2', '1', NULL, 'Cosaseg', 'asdasdsa', '1233', '2021-06-12', '2021-06-19','$filename','jpg'";
    mysqli_query($conn,$sql) or die('Error: '.mysqli_error($conn));;
    if (move_uploaded_file($tempname, $folder))  {
        $msg = "Image uploaded successfully";
    }else{
        $msg = "Failed to upload image";
  }
}
?>
   

</main>
</body>
</html>