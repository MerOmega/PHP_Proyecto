<!doctype html>
<html>

<?php
    session_start();
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital@1&display=swap');
</style>

<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<head>
    <title>
        Compra Barato
    </title>
    <link rel="stylesheet" type="text/css" href="main.css?v=1.1">
    <meta name="viewport" content="width=device-width">
</head>
<body>
<header>
<div class="cabecera">
        <h1><a href="index.php">CompraBarato!</a></h1>
        <div class="buscador">
            <form action="search.php" method="POST"> 
                <input type="text" name="search" placeholder="Busca aqui..."> 
                <button type="submit" name="submit-search">Search</button>
            </form>
        </div>
  </div>
    <div class="main-nav">
        <nav>
                
                <div id="interfaz">
                    <a href="index.php">Inicio</a>
                </div>
                <div id="usuarios">
                    <a href="login.php">Iniciar Sesion</a>
                    <a href="registrar.php">Crear Cuenta</a>
                    <a href="logout.php">Log Out</a>
                </div>
        </nav>
    </div>
</header>

<?php
//se verifica si el usuario realizo clic en la imagen del producto desde el listado 
    //si se recibio el id del producto
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        require('BD.php');
        //se busca en la bd y se obtienen todos sus datos
        $sql= "SELECT * FROM productos WHERE (idProducto = '$id')";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){ 
                $nombre=$row['nombre'];
                $precio=$row["precio"];
                $descripcion=$row['descripcion'];
                $publicacion=$row["publicacion"];
                $caducidad=$row["caducidad"];
                $imagen=$row["contenidoimagen"];
                $idCategoria=$row['idCategoriaProducto'];
                $idVendedor=$row['idUsuarioVendedor'];
            }
            
        }else{
            echo "0 results";
        }
        
    }else{
        echo "No encontre el ID";
    }
?>

    <?php 
            //se busca en la bd el nombre de la categoria del producto detallado
            $sql="SELECT * FROM categorias_productos WHERE (idCategoriaProducto='$idCategoria')";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    $nombreCat=$row['nombre'];               
                }
            }
            //se busca en la bd el nombre del usuario vendedor del producto
            $sql="SELECT * FROM usuarios WHERE (idUsuario='$idVendedor')";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    $usVendedor=$row['nombredeusuario'];               
                }
            }
    ?>

<div class="contenedor_imagen">
    <div class="contenedor_muestra">
        <?php
            echo '<div class="texto_prod"><p>'.$nombre.'</p><br>';
            echo '<img src="data:image;base64,'.base64_encode($imagen).'" alt="Image" style="width="200px; height=300" ></div>';
            echo "<p>Fecha la publicacion: ".$publicacion."</p>";
            echo "<p>Fecha de caducidad de la publicacion: ".$caducidad."</p>" ?>
        
        </div>

        <div class="contenedor_precio">
            <p class="precio"> <?php echo "Precio: $".$precio ?> </p>
            <div>
             <br><br><br>
             <p><?php echo "Categoria: ".$nombreCat;?></p>   
             <p><?php echo "Vendedor: ".$usVendedor?></p>
            </div>
        </div>
</div>
<p class="descripcion"><?php echo "Descripcion del producto: <br><br>".$descripcion ?></p>

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