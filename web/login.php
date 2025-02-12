<!doctype html>
<html lang="es">
<?php include 'plantillas/head.php'; ?>
<body class="contenedor-principal">
<?php include 'plantillas/header.php'; ?>
<main class="main">
    <div class="contenedor-formulario-login">
        <h1 class="titulo-formulario-login">Iniciar sesión</h1>
        <form action="usuario/usuario-login.php" method="post" class="formulario-login">
            <div class="input-container">
                <input type="text" name="usuario" id="usuario" class="input-formulario-login" required placeholder=" ">
                <label for="usuario" class="label-formulario-login">Usuario</label>
            </div>
            <div class="input-container">
                <input type="password" name="contrasena" id="contrasena" class="input-formulario-login" required placeholder=" ">
                <label for="contrasena" class="label-formulario-login">Contraseña</label>
            </div>
            <input type="submit" value="Iniciar sesión" class="boton-formulario-login">
        </form>
        <?php
            if (isset($_GET["error-login"])) {
                echo '<span class="error-login">' . $_GET["error-login"] . "</span>";
            }
        ?>
    </div>
</main>
<?php include 'plantillas/footer.php'; ?>
</body>
</html>