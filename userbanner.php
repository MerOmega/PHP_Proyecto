<script type="text/javascript">  
        var sesionactual='<?php echo $_SESSION['nombredeusuario'] ?>'; 
        function cambioUsuario(){
            if(sesionactual!="Invitado"){
                $("#usuarios").replaceWith( '<div id="usuarios"> <div class="desplegable" style="width: 120px;"><a href="#">Hola <?php echo $_SESSION['nombredeusuario']; ?>&#9207;</a><div class="desplegable_cont"><a href="profile.php">Editar Perfil</a> <a href="agregarArt.php">Publicar Articulo</a><a href="panel.php">Modificar Articulo</a><a href="Compras.php?nomusuario=<?php echo $_SESSION["nombredeusuario"]?>">Mis compras</a></div></div> <a href="logout.php">Log Out</a> </div>');
            }
        }
        cambioUsuario(sesionactual);
    </script>
    