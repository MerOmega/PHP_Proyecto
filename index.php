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
                <form action="index.php" method="post">
                    <select name="categorias">
                    <option value="">Seccione una categoria</option>
                    <option value="Electrodomesticos">Electrodomesticos</option>
                    <option value="Instrumentos">Instrumentos</option>
                    </select>
                    <button type="submit" name="seleccion" class="boton">Enviar</button>
                    </form>
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

    <select id="sort">
        <option value="precioAs">Precio Mayor a menor</option>
        <option value="precioDesc">Precio Menor a Mayor</option>
        <option value="fechaAs">Caducidad mas cercana</option>
        <option value="fechaDes">Caducidad mas lejana</option>
    </select>
    
    <div>
        <!-- Consulta a la base-->
            <?php
                require('coneccion.php'); //enlazo la base
                ?>
                <div id="sorted">
                <?php $sql= "SELECT * FROM productos ORDER BY precio";?>
                </div>
                <?php
                $result = $conn->query($sql);
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
                            <div style="display: none;" class="caduca"><p><?php echo $row["caducidad"] ?></p></div>
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
    <!-- Consulta a la base-->
        <?php
        if(isset($_POST["seleccion"])){
            require('coneccion.php'); //enlazo la base
            if(isset($_POST['categorias'])){
                $categoria=$_POST['categorias'];
                echo "$categoria";
                $sql= "SELECT P.*FROM productos P INNER JOIN categorias_productos C ON 
                (P.idCategoriaProducto = C.idCategoriaProducto) WHERE (C.nombre = '$categoria')";
            
                 $result = $conn->query($sql);

                if ($result->num_rows > 0) {
            
                while($row = $result->fetch_assoc()) {
                ?>
                    <div class="blackbox">
                    <?php
                        echo '<img src="data:image;base64,'.base64_encode($row["contenidoimagen"]).'" alt="Image" style="width="100px; height=150" >';
                        
                        ?>
                        <p><?php echo "Articulo: " . $row["nombre"] . " ID: ". $row["idProducto"]?></p>
                        <div style="display: none;" class="caduca"><p><?php echo $row["caducidad"] ?></p></div>
                        <div style="display: none;" class="disponible"><p><?php echo $row["idUsuarioComprador"] ?></p></div>
                        <?php echo " - Desc: " ." " . $row["descripcion"] . "-Precio:"." ".$row["precio"];   
                        
                        
                        ?>
                    </div>
                <?php
               }
                } else {
                    echo "0 results";
                }
        }
        } 
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
    <div>
        <div class="mostrar">
            <button type="button" id="showMore">Mostrar mas</button>
            <button type="button" id="showLess">Mostrar Menos</button>
        </div>
    </div>
    <script type="text/javascript" src="main.js"></script>
</main>
</body>

</html>