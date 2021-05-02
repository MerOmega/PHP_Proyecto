<!doctype html>
<html>
<head>
    <title>
        Compra Barato
    </title>
    <link rel="stylesheet" type="text/css" href="main.css?v=1.1">
    <meta name="viewport" content="width=device-width"> 
</head>
<body>
<header>
<div>
    <h2 style="text-align:center;">Registro</h2>
</div>
</header>
 <div>

 <form style="text-align:center;" name="registro" action="registrar.php" method="POST">

    <input type="text" name="user" placeholder="Ingrese nombre de usuario"><br><br>
    <input type="text" name="nombre" placeholder="Ingrese nombre" ><br><br>
    <input type="text" name="apellido" placeholder="Ingrese apellido"><br><br>
    <input type="password" name="clave" placeholder="Ingrese clave"><br><br>
    <input type="email" name="email" placeholder="Ingrese email"><br><br>
    <input type="text" name="telefono" placeholder="Ingrese telefono"><br><br>

    <button type="submit" name="submit" class="boton">Registrar</button>

</form>

<a href="index.php">Inicio</a>

</div>

<?php
if(isset($_POST["submit"])){
 if(!empty($_POST["user"]) && !empty($_POST["nombre"]) && !empty($_POST["apellido"]) && !empty($_POST["clave"]) && !empty($_POST["email"]) && !empty($_POST["telefono"])){
    require('coneccion.php');
    $usuario=$_POST['user'];
    $nombre=$_POST['nombre'];
    $apellido= $_POST['apellido'];
    $clave= $_POST['clave'];
    $email=$_POST['email'];
    $telefono=$_POST['telefono'];
    $sql= "INSERT INTO usuarios (nombredeusuario, clave, apellido, nombre, email, telefono) 
    VALUES ('$usuario','$nombre','$apellido','$clave','$email','$telefono')";
    if($conn->query($sql) === true){
        echo "nuevo registro";
    }
    else {
        echo "Error: " . $sql . "<br>" . $sql->error;
    }
    }
    else{
        echo "complete todos los campos";
    }
}
?>


</body>

</html>