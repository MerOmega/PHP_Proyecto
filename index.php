<!doctype html>
<html>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

<?php 
    session_start(); 
    if(!isset($_SESSION['nombredeusuario'])){
            $_SESSION['nombredeusuario']="Invitado";
    }
    if(!isset($_SESSION['sort_user_defined'])){
        $_SESSION['sort_user_defined']='ORDER BY precio DESC';
    }
    
function procesoFiltroSort(){
    switch($_SESSION['sort_user']){
        case "precioAs":
            $_SESSION['sort_user_defined']='ORDER BY precio DESC';
                    break;
            case "precioDesc":
                $_SESSION['sort_user_defined']='ORDER BY precio ASC';
                break;
            case "fechaAs":
                $_SESSION['sort_user_defined']='ORDER BY caducidad ASC';
                    break;
            case "fechaDes":
                $_SESSION['sort_user_defined']='ORDER BY caducidad DESC';
                    break;
    }
}
function procesoFiltroCategory($var1){
    if($_SESSION['category_user']=="show_all"){
        $_SESSION['category_user']='';
    }
    else{
        $_SESSION['category_user'] = "WHERE (C.nombre ='$var1') AND (P.idUsuarioComprador<=>NULL)";
    }
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
   
            <form action="search.php" method="POST"> 
                <input type="text" name="buscador" placeholder="Busca aqui..."> 
                <button type="submit" name="submit-search">Search</button>
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
                            <option value="show_all">Todas las categorias</option>
                            <?php while($datos=mysqli_fetch_array( $result )){ ?>
                            <option value="<?php echo $datos['nombre'] ?>"><?php echo $datos['nombre'] ?></option>
                            <?php } ?>
                            </select>
                <button type="submit" class="boton">Enviar</button>
            </form>
            <form action="index.php" method="post" >
                <select name="sort" >
                        <option value="precioAs">Precio Mayor a menor</option>
                        <option value="precioDesc">Precio Menor a Mayor</option>
                        <option value="fechaAs">Caducidad mas cercana</option>
                        <option value="fechaDes">Caducidad mas lejana</option>
                    </select>
                    <button type="submit" class="boton">Enviar</button>
                </form>
            
     </div>

     <div>
         <!-- Consulta a la base-->          
               <?php require('paginacion.php');?>

    </div> 


    <div class="wrapper" > 
                <?php
                if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                   ?>
                    <div class="blackbox">
                    <?php
                            echo '<a href="producto.php?id='.$row["idProducto"].'"><img src="data:image;base64,'.base64_encode($row["contenidoimagen"]).'" alt="Image" style="width="100px; height=150" ></a>';
                            ?>
                            <p><?php echo "Articulo: " . $row["nombre"]?></p>
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