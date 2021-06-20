<!doctype html>
<html>
<?php session_start(); ?>
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
<!---->
 <div class="cabecera">
         <h1><a href="index.php">CompraBarato!</a></h1>
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
        //conexion con la bd
        require('BD.php');
        //verifica si el usuario realizo un clic en el boton buscar
            if(isset($_POST['submit-search'])){
                    //se verifica que no se haya enviado un nombre vacio
                    if(!empty($_POST['buscador'])){
                        $_SESSION['submited']=$_POST['submit-search']; //guarda el valor del form en una sesion
                        $_SESSION['buscador']=$_POST['buscador']; //guarda el nombre del producto buscado en una sesion
                        $search = $conn->real_escape_string($_SESSION['buscador']); //Filtra characteres para usar en la consulta
                        $date=date('Y-m-d');
                        //consulta que filtra los productos que contengan el nombre buscado y que no esten comprados
                        $sql= "SELECT * FROM productos WHERE (nombre LIKE '%$search%') AND (idUsuarioComprador<=>NULL) AND (DATE(caducidad)>'$date')";
                        $result=$conn->query($sql);
                    }else{
                        echo "<p>Ningun resultado que mostrar</p>";
                        unset($_SESSION['buscador']);
                    }
            }else{
                if(!isset( $_SESSION['submited'])){
                echo "<p>Ningun resultado que mostrar</p>";
                }
            }
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
                            <div class="caduca"><p><?php echo $row["caducidad"] ?></p></div>                   
                            <?php echo "-Precio:"." ".$row["precio"];   
                            ?>
                        </div>
                    <?php
                }
                }                 
                ?> 
        </div>

        <?php if(isset($_SESSION['buscador'])){
           echo "<form action='search.php' method='post' >
                    <select name='sort' >
                            <option value='precioAs'>Precio Mayor a menor</option>
                            <option value='precioDesc'>Precio Menor a Mayor</option>
                            <option value='fechaAs'>Caducidad mas cercana</option>
                            <option value='fechaDes'>Caducidad mas lejana</option>
                        </select>
                        <button type='submit' class='boton'>Seleccionar</button>
            </form>";
            }
        ?>

        <?php
         require('BD.php'); //enlazo la base
         ?>
         <div id="sorted">
         <?php 
         //consulta sql para obtener todas las categorias de productos
         $sql= "SELECT * FROM categorias_productos";?>
         </div>
         <?php
         //busqueda en la bd de la consulta sql
         $result = $conn->query($sql);
         ?>

        <?php if(isset($_SESSION['buscador'])){
        echo '<form action="search.php" method="post">
         <select name="categorias">
         <option value="show_all">Todas las categorias</option>'
         ?>
         <?php while($datos=mysqli_fetch_array( $result)){ ?>
         <option value="<?php echo $datos['nombre'] ?>"><?php echo $datos['nombre'] ?></option>
         <?php } ?>
         </select>
        <button type="submit" class="boton">Seleccionar</button>
        </form>
        <?php
         }
         ?>
        <?php 
            require("paginacionSearch.php");
        ?>
        <p> <?php echo $texto; ?> </p>
        <div id="pag_control" ><?php echo $paginCtrls; ?></div>

    

       <?php
       require("userbanner.php")
       ?>
</main>
</body>

</html>