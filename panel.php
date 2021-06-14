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
    <link rel="stylesheet" type="text/css" href="panel.css?v=1.1">
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
        $id=obtenerid($_SESSION['nombredeusuario'],$conn);
        $sql="SELECT * FROM productos WHERE idUsuarioVendedor='$id' ORDER BY nombre DESC";
        $result = $conn->query($sql);
    ?>
    <div id="cont_tabla">
        <table class="tabla">
        <tr class="tabla_cabecera">
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Categoria</th>
            <th>caducidad</th>
            <th>Imagen</th>
            <th>Borrar</th>    
        </tr>
        
        <div >
        <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
        ?>
            <tr class="tabla_producto">
                <td class="scroll"><div><?php echo $row["nombre"] ?></div></td>
                <td class="scroll"><div class="desc"><?php echo $row["descripcion"]?></div></td>
                <td><?php echo $row["precio"] ?></td>
                <td><?php echo $row["idCategoriaProducto"] ?></td>
                <td><?php echo $row["caducidad"] ?></td>
                <td><?php echo '<img src="data:image;base64,'.base64_encode($row["contenidoimagen"]).'" alt="Image" style="width="20px; height=30" >';?></td>
                <td><?php if($row["idUsuarioComprador"]==NULL){ echo('<button type='."submit"."class="."boton".">&times;</button>");}
                else {echo("Articulo Comprado");}?></td>
            <?php 
                }
            }
            ?>
            </tr>  
        </div>
        
        </table>
    </div>

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

    require("userbanner.php")
?>
</main>
</body>
</html>