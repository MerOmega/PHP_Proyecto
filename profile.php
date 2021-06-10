
<!doctype html>
<html>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script defer src="popup.js"></script>
<?php
    session_start(); 
?>
<head>
    <title>
        Compra Barato - Perfil Usuario
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
    ?>
    <h2>Panel de usuario</h2>
    <?php
        if(isset ($_SESSION["nombredeusuario"])){
            $usuario=$_SESSION["nombredeusuario"];
            $sql = "SELECT * FROM usuarios WHERE nombredeusuario='$usuario'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    ?>
                    <div class="wrapperInfo">
                        <div class="contenedorInfo">
                        <?php
                        $id=$row["idUsuario"];
                        $apellido=$row['apellido'];     
                        $nombre=$row['nombre'];
                        $telefono=$row['telefono'];
                        $email=$row['email'];
                        ?>
                            <div class='row'>
                                <?php echo("<p data-modal-target="."#pop>$nombre</p>");?>
                                <div class="pop" id="pop">
                                    <div class="pophead">
                                        <div class="titulo"> Ejemplo</div>
                                        <button data-close-button class="close">&times;</button>
                                    </div>
                                    <div class="popbody">
                                        <form id="cambio"  style="text-align:center;" name="profile" action="profile.php" method="POST" novalidate>
                                        <input type="text" name="nombre" placeholder="Ingrese nombre"><br><br>
                                        <button type="submit" name="submit" class="boton">Cambiar</button>
                                        </form>
                                    </div>   
                                </div>
                            </div>
                            <div id="overlay"></div>
                            <div class='row'>
                                <?php echo("<p  data-modal-target="."#popApe".">$apellido</p>");?>
                                    <div class="pop" id="popApe">
                                        <div class="pophead">
                                            <div class="titulo"> Cambio de Apellido</div>
                                            <button data-close-button class="close">&times;</button>
                                        </div>
                                        <div class="popbody">
                                            <form id="cambio"  style="text-align:center;" name="profile" action="profile.php" method="POST" novalidate>
                                            <input type="text" name="apellido" placeholder="Ingrese apellido"><br><br>
                                            <button type="submit" name="submit" class="boton">Cambiar</button>
                                            </form>
                                        </div>   
                                    </div>
                             </div>
                             <div class='row'>
                             <?php echo("<p data-modal-target="."#popContra>Contraseña</p>");?>
                                    <div class="pop" id="popContra">
                                        <div class="pophead">
                                            <div class="titulo"> Cambio de Contraseña</div>
                                            <button data-close-button class="close">&times;</button>
                                        </div>
                                        <div class="popbody">
                                            <form id="cambio"  style="text-align:center;" name="profile" action="profile.php" method="POST" novalidate>
                                            <input type="text" name="contra" placeholder="Ingrese Contraseña"><br><br>
                                            <button type="submit" name="submit" class="boton">Cambiar</button>
                                            </form>
                                        </div>   
                                    </div>
                             </div>
                             <div class='row'>
                             <?php echo("<p data-modal-target="."#popMail>$email</p>");?>
                                    <div class="pop" id="popMail">
                                        <div class="pophead">
                                            <div class="titulo"> Cambio de Email</div>
                                            <button data-close-button class="close">&times;</button>
                                        </div>
                                        <div class="popbody">
                                            <form id="cambio"  style="text-align:center;" name="profile" action="profile.php" method="POST" novalidate>
                                            <input type="text" name="email" placeholder="Ingrese email"><br><br>
                                            <button type="submit" name="submit" class="boton">Cambiar</button>
                                            </form>
                                        </div>   
                                    </div>
                             </div>
                             <div class='row'>
                             <?php echo("<p data-modal-target="."#popTel>Telefono</p>");?>
                                    <div class="pop" id="popTel">
                                        <div class="pophead">
                                            <div class="titulo"> Cambio de Telefono</div>
                                            <button data-close-button class="close">&times;</button>
                                        </div>
                                        <div class="popbody">
                                            <form id="cambio"  style="text-align:center;" name="profile" action="profile.php" method="POST" novalidate>
                                            <input type="text" name="telefono" placeholder="Ingrese telefono"><br><br>
                                            <button type="submit" name="submit" class="boton">Cambiar</button>
                                            </form>
                                        </div>   
                                    </div>
                             </div>
                             <div class='row'>
                             <?php echo("<p data-modal-target="."#popUser>Usuario:"."$usuario</p>");?>
                                    <div class="pop" id="popUser">
                                        <div class="pophead">
                                            <div class="titulo"> Cambio de Usuario</div>
                                            <button data-close-button class="close">&times;</button>
                                        </div>
                                        <div class="popbody">
                                            <form id="cambio"  style="text-align:center;" name="profile" action="profile.php" method="POST" novalidate>
                                            <input type="text" name="usuario" placeholder="Ingrese usuario"><br><br>
                                            <button type="submit" name="submit" class="boton">Cambiar</button>
                                            </form>
                                        </div>   
                                    </div>
                             </div>
                        
                        </div>
                    </div>
                    <?php
                }
            }
        }
    ?>

<?php 
 require("userbanner.php");
       if(isset($_POST["submit"])){
            if(isset($_POST["nombre"]) && !empty($_POST["nombre"])){
                $nombre=$_POST["nombre"];
                $sql="UPDATE usuarios SET nombre='$nombre' WHERE idUsuario='$id'";
                mysqli_query($conn,$sql);
                //Necesita refresh
                ?>
                
                <?php
            }else if(isset($_POST["apellido"]) && !empty($_POST["apellido"]) ) {
                echo($_POST["apellido"]);
            }
        }
?>

<script>
function reloadThePage(){
    window.location.reload();
} 
</script>
</main>
</body>

</html>