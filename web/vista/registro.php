<!doctype html>
<html lang="es">
<?php include '../plantillas/head.php'; ?>
<body class="contenedor-principal">
<?php include '../plantillas/header.php'; ?>
<main class="main">
    <div class="contenedor-formulario-registro">
        <h1 class="titulo-formulario-registro">Registro</h1>
        <form action="../usuario/usuario-registro.php" method="post" class="formulario-registro">
            <div class="input-container">
                <input type="text" name="usuario" id="usuario" class="input-formulario-registro" required placeholder=" ">
                <label for="usuario" class="label-formulario-registro">Usuario</label>
            </div>
            <div class="input-container">
                <input type="password" name="contrasena" id="contrasena" class="input-formulario-registro" required placeholder=" ">
                <label for="contrasena" class="label-formulario-registro">Contraseña</label>
            </div>
            <div class="input-container">
                <input type="password" name="contrasena2" id="contrasena2" class="input-formulario-registro" required placeholder=" ">
                <label for="contrasena2" class="label-formulario-registro">Repetir contraseña</label>
            </div>
            <input type="submit" value="Iniciar sesión" class="boton-formulario-registro">
        </form>
        <?php
        if (isset($_GET["error-registro"])) {
            echo '<span class="error-registro">' . $_GET["error-registro"] . "</span>";
        }
        ?>
    </div>
</main>
<?php include '../plantillas/footer.php'; ?>
</body>
</html>