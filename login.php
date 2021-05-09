<!doctype html>
<html>
<link rel="stylesheet" type="text/css" href="main.css?v=1.1">
<head>
 <title>Ingreso</title>

</head>
<body>
    <header>
        <div class="cabecera">
        <nav class="main-nav">
                <a href="index.php">Inicio</a>
                <a href="#">Contacto</a>
        </nav>
        </div>
    </header>
    <?php
        session_start();
        if(isset($_POST["username"]) && isset($_POST["password"])){
        require('BD.php');
        $username=$_POST['username'];
        $password=$_POST['password'];
        $sql= "SELECT * FROM usuarios where binary nombredeusuario= binary '$username' and binary clave=binary '$password'";
        $result = $conn->query($sql);
        $num=mysqli_num_rows($result);
        if($num==1){
            $_SESSION['nombredeusuario']=$username;
            header('location:index.php');
        }else{
            header('location:registro.php');
        }
    }
    ?>

    <section id="inicio">
        <form name="registration" action="login.php" method="POST">
          <div>  <label>Usuario</label> <input type="text" name="username" placeholder="Usuario..." required><br> </div>
          <div>  <label>Contraseña</label> <input type="password" name="password" placeholder="Contraseña..." required><br></div>
            <button type="submit" name="submit" class="boton">Iniciar</button>
        </form>
    </section>
    

</body>
</html>