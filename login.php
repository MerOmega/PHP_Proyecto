<!doctype html>
<html>
<link rel="stylesheet" type="text/css" href="main.css?v=1.1">
<head>
 <title>Ingreso</title>
</head>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
            $num =$this->validar($conn);
            if($num==1){
                $_SESSION['nombredeusuario']=$this->getter_usuario();
                header('location:index.php');
            }else{
                throw new Exception("Usuario y/o Contraseña");
            }
        }

        function ingreso($conn){
            try{
            $this->autorizar($conn);
            }
            catch(Exception $e){
                $error=$e->getMessage();
                echo "<script>Swal.fire({
                    title: 'Error!',
                    text: '".$e->getMessage()."',
                    icon: 'error',
                    confirmButtonText: 'Bueno :('
                  })</script>";
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
            $usuario->ingreso($conn);   
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