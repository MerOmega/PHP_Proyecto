<!doctype html>
<html>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

<?php 
    session_start(); 
    if(!isset($_SESSION['nombredeusuario'])){
            $_SESSION['nombredeusuario']="Invitado";
    }
    //si no se elige un orden para mostrar el listado, por defecto los ordena por precio desc
    if(!isset($_SESSION['sort_user_defined'])){
        $_SESSION['sort_user_defined']='ORDER BY precio DESC';
    }
    
//funcion que se encarga de obtener el order elegido por el usuario y guardarlo en una sesion
    function procesoFiltroSort(){
    switch($_SESSION['sort_user']){
        case "precioAs":
            //se guarda parte de la consulta sql para luego aplicar el orden en la consulta general
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
//funcion que procesa la categoria elegida por el usuario
function procesoFiltroCategory($var1){
    $date=date('Y-m-d');
    //se verifica si el usuario elige nuevamente ver todos los productos
    if($_SESSION['category_user']=="show_all"){
       //se muestran los productos no caducados y no comprados
        $_SESSION['category_user']="WHERE (P.idUsuarioComprador<=>NULL) AND (DATE(caducidad)>'$date')";
    }
    else{
        //si no se buscará en la bd los productos de la categoria var1
        $_SESSION['category_user'] = "WHERE (C.nombre ='$var1') AND (P.idUsuarioComprador<=>NULL) AND (DATE(caducidad)>'$date')";
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
        <div>
            <h2>PRODUCTOS</h2>
        </div>
        <div>
        <!-- Consulta a la base-->
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
    </div> 

        <!--Fomulario seleccionador para elegir categorias-->
        <div id="contenedor_categorias">
            <form action="index.php" method="post">
                            <select name="categorias">
                            <option value="show_all">Todas las categorias</option>
                            <?php while($datos=mysqli_fetch_array( $result )){ ?>
                            <option value="<?php echo $datos['nombre'] ?>"><?php echo $datos['nombre'] ?></option>
                            <?php } ?>
                            </select>
                <button type="submit" class="boton">Seleccionar</button>
            </form>

             <!--Fomulario seleccionador para elegir el metodo de orden de los productos-->
            <form action="index.php" method="post" >
                <select name="sort" >
                        <option value="precioAs">Precio Mayor a menor</option>
                        <option value="precioDesc">Precio Menor a Mayor</option>
                        <option value="fechaAs">Caducidad mas cercana</option>
                        <option value="fechaDes">Caducidad mas lejana</option>
                    </select>
                    <button type="submit" class="boton">Seleccionar</button>
                </form>
            
     </div>

     <div>      
         <!--Para realizar la paginación de los productos se llama al archivo paginación.php-->  
         <!-- Consulta a la base-->  
               <?php require('paginacion.php');?>

    </div> 

 <!--Contenedor que contiene el listado de productos-->
    <div class="wrapper" > 
                <?php
                //Si el numero de filas es mayor a 0, se obtuvieron filas de la consulta sql previa
                if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                   ?>
                   <!--Contenedor que contiene cada producto del listado-->
                    <div class="blackbox">
                    <?php
                            //link <a> integrado a la imagen y que redirecciona a la vista con detalle del producto
                            echo '<a href="producto.php?id='.$row["idProducto"].'"><img src="data:image;base64,'.base64_encode($row["contenidoimagen"]).'" alt="Image" style="width="100px; height=150" ></a>';
                            ?>
                            <p><?php echo "Articulo: " . $row["nombre"]?></p>
                            <div class="caduca"><p><?php echo $row["caducidad"] ?></p></div>
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

    <div id="pag_control"><?php echo $paginCtrls; ?></div>

    <script type="text/javascript">  
        var sesionactual='<?php echo $_SESSION['nombredeusuario'] ?>'; 
        function cambioUsuario(){
            if(sesionactual!="Invitado"){
                $("#usuarios").replaceWith( '<div id="usuarios"> <div class="desplegable" style="width: 120px;"><a href="#">Hola <?php echo $_SESSION['nombredeusuario']; ?>&#9207;</a><div class="desplegable_cont"><a>Editar Perfil</a> <a>Publicar Articulo</a></div></div> <a href="logout.php">Log Out</a> </div>');
            }
        }
        cambioUsuario(sesionactual);
    </script>
    
</main>
</body>

</html>