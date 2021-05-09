<!doctype html>
<html>
<link rel="stylesheet" type="text/css" href="main.css?v=1.1">
<head>
 <title>Ingreso</title>
</head>

<?php 
    class Usuario extends Exception{
        private $usuario;
        private $contraseña;

        function agregar_usuario($var1){
            $this->usuario=$var1;
        }

        function agregar_cont($var1){
            $this->contraseña=$var1;
        }

        function getter_usuario(){
            return $this->usuario;
        }
        function validar($conn){
            if(isset($this->usuario) && isset($this->contraseña)){
            $sql= "SELECT * FROM usuarios where binary nombredeusuario= binary '$this->usuario' and binary clave=binary '$this->contraseña'";
            $result = $conn->query($sql);
            $num=mysqli_num_rows($result);
            return $num;
            }else{
                return 0;
            }
        }

        function autorizar($conn){
            try{
               $this->validar($conn);
            }catch(Exception $e){
                echo $e->message;
                echo "asdsdas";
            }
        }

}
?>


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
        require('BD.php');
        $usuario = new Usuario();
        if(isset($_POST['username'])&&isset($_POST['password'])){
            $usuario->agregar_usuario($_POST['username']);
            $usuario->agregar_cont($_POST['password']);
            $num=$usuario->validar($conn);
        
        if($num==1){
            $_SESSION['nombredeusuario']=$usuario->getter_usuario();
            header('location:index.php');
        }else{
            /*header('location:registrar.php');*/
        }
    }
    ?>

    <section id="inicio">
        <form name="registration" action="login.php" method="POST" novalidate>
          <div>  <label>Usuario</label> <input type="text" name="username" placeholder="Usuario..." ><br> </div>
          <div>  <label>Contraseña</label> <input type="password" name="password" placeholder="Contraseña..." ><br></div>
            <button type="submit" name="submit" class="boton">Iniciar</button>
        </form>
    </section>
    

</body>
</html>