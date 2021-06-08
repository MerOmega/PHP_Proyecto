
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
 require("userbanner.php")
?>
</main>
</body>

</html>