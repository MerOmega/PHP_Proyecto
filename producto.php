<!doctype html>
<html>

<?php
    session_start();
?>

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
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        require('coneccion.php');

        $sql= "SELECT * FROM productos WHERE (idProducto = '$id')";

        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                
                $nombre=$row['nombre'];
                $precio=$row["precio"];
                $publicacion=$row["publicacion"];
                $caducidad=$row["caducidad"];
                $imagen=$row["contenidoimagen"];
                
               
            }
            
        }else{
            echo "0 results";
        }
        
    }else{
        echo "No encontre el ID";
    }
?>
<div class="contenedor_imagen">
<?php

    echo '<div class="imagen_prod"><p>'.$nombre.'</p>';
    echo '<img src="data:image;base64,'.base64_encode($imagen).'" alt="Image" style="width="100px; height=150" ></div>';
    
?>
</div>

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