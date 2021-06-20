<!doctype html>
<html>

<?php
session_start();
$nombre = $desc = $precio = $cat = $cadu = $img = 0;
?>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

<head>
    <title>

        Compra Barato
    </title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" type="text/css" href="panel.css?v=1.1">
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
                    <a href="index.php">Inicio</a>
                </div>
                <div id="usuarios">

                    <a href="profile.php"> Hola <?php echo $_SESSION['nombredeusuario'] ?></a>
                    <a href="logout.php">Log Out</a>
                </div>
            </nav>
        </div>
    </header>
    <?php
    if (isset($_GET['id'])) {
        $idproducto = $_GET['id'];
        $nombrecomprador = $_SESSION["nombredeusuario"];
        $sql = "SELECT idUsuario FROM usuarios WHERE (nombredeusuario = '$nombrecomprador' )";
        require('BD.php');
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $idcomprador = $row['idUsuario'];
            }

            $sql = "UPDATE productos SET idUsuarioComprador = $idcomprador WHERE idProducto = '$idproducto'";
            if ($conn->query($sql) == TRUE) {
    ?>
                <script>
                    Swal.fire({
                        title: 'Exito!',
                        text: 'Ha realizado la compra exitosamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    })
                </script>

    <?php

            } else {
                echo "Hubo problemas";
            }
        }
    }

    ?>

    <body>

        <div id="cont_tabla">
            <table class="tabla">
                <tr class="tabla_cabecera">
                    <th>Nombre</th>
                    <th nowrap>Descripcion </th>
                    <th>precio </th>
                </tr>
                <?php
                if (isset($_GET['nomusuario'])) {
                    $user = $_GET['nomusuario'];
                    require('BD.php');
                    $sql = "SELECT idUsuario FROM usuarios WHERE (nombredeusuario = '$user')";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $iduser = $row['idUsuario'];
                        }
                    }

                    $sql = "SELECT * FROM productos WHERE ('$iduser' = idUsuarioComprador)";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                ?>
                            <tr>
                                <td data-modal-target=#nom<?php echo $nombre ?>>
                                    <div class="scroll desc">
                                        <p> <?php echo $row["nombre"] ?></p>
                                    </div>
                                </td>
                                <td data-modal-target=#desc<?php echo $desc ?>>
                                    <div class="scroll desc">
                                        <p> <?php echo $row["descripcion"] ?></p>
                                    </div>
                                </td>
                                <td data-modal-target=#precio<?php echo $precio ?>>
                                    <div class="scroll desc">
                                        <p> <?php echo $row["precio"] ?></p>
                                    </div>
                                </td>
                        <?php
                        }
                    }
                        ?>
                            </tr>
            </table>
        </div>
    <?php
                }
    ?>

    </body>

    <?php
    require("userbanner.php");
    ?>

</html>