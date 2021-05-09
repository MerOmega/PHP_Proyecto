<!doctype html>
<html>
<?php session_start(); ?>
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
            <form action="search.php" method="POST"> 
                <input type="text" name="buscador" placeholder="Busca aqui..."> 
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
<main class="contenedor_main">
        <div>
            <h2>PRODUCTOS</h2>
        </div>
        
        <?php
        require('coneccion.php');
            if(isset($_POST['submit-search'])){
                    if($_POST['buscador']!=""){
                        //Filtra characteres 
                        $_SESSION['submited']=$_POST['submit-search'];
                        $_SESSION['buscador']=$_POST['buscador'];
                        $search = $conn->real_escape_string($_SESSION['buscador']);
                        $sql= "SELECT * FROM productos WHERE nombre LIKE '%$search%' OR descripcion LIKE '%$search%' AND (idUsuarioComprador<=>NULL)";
                        $result=$conn->query($sql);
                    }else{
                        echo "<p>Ningun resultado que mostrar</p>";
                    }
            }else{
                if(!isset( $_SESSION['submited'])){
                echo "<p>Ningun resultado que mostrar</p>";
                }
            }
        ?>

        <form action="search.php" method="post" >
                <select name="sort" >
                        <option value="precioAs">Precio Mayor a menor</option>
                        <option value="precioDesc">Precio Menor a Mayor</option>
                        <option value="fechaAs">Caducidad mas cercana</option>
                        <option value="fechaDes">Caducidad mas lejana</option>
                    </select>
                    <button type="submit" class="boton">Enviar</button>
          </form>
          <?php 
            require("paginacionSearch.php");
        ?>
        <div class="wrapper" > 
        <?php
                if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                   ?>
                    <div class="blackbox">
                    <?php
                            echo '<a href="producto.php?id='.$row["idProducto"].'"><img src="data:image;base64,'.base64_encode($row["contenidoimagen"]).'" alt="Image" style="width="100px; height=150" ></a>';
                            ?>
                            <p><?php echo "Articulo: " . $row["nombre"] . " ID: ". $row['idProducto']?></p>                         
                            <?php echo "-Precio:"." ".$row["precio"];   
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