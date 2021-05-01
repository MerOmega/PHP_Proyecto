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
                    <a href="#">Categorias</a>
                    <a href="#">Contacto</a>
                </div>
                <div id="usuarios">
                    <a href="login.php">Iniciar Sesion</a>
                    <a href="">Crear Cuenta</a>
                    <a href="logout.php">Log Out</a>
                </div>
        </nav>
    </div>
</header>

<main class="contenedor_main">

    

        <div>
            <h2>PRODUCTOS</h2>
        </div>


    <div class="wrapper" >
        <!-- Consulta a la base-->
            <?php
                require('coneccion.php'); //enlazo la base
                $sql= "SELECT * FROM productos ORDER BY precio";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                
                while($row = $result->fetch_assoc()) {
                   ?>
                   <div class="blackbox">
                   <?php
                    echo '<img src="data:image;base64,'.base64_encode($row["contenidoimagen"]).'" alt="Image" style="width="100px; height=150" >'
                    ?>
                    <p><?php echo "Articulo: " . $row["nombre"]?></p>
                    
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

    <script type="text/javascript">  
        var sesionactual='<?php echo $_SESSION['nombredeusuario'] ?>';
        function cambioUsuario(){
            if(sesionactual=="Invitado"){
               $("#usuarios").replaceWith('<div id="usuarios"> <a href="login.php">Iniciar Sesion</a> <a href="">Crear Cuenta</a> <a href="logout.php">Log Out</a> </div> ');

            }else{
                $("#usuarios").replaceWith( '<div id="usuarios"> <a href="#">Hola <?php echo $_SESSION['nombredeusuario']; ?></a> <a href="logout.php">Log Out</a> </div>');
            }
            
        }
        
        cambioUsuario(sesionactual);
    </script>
</main>
</body>

</html>