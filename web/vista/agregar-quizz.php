<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
?>

<!doctype html>
<html lang="es">
<?php include '../plantillas/head.php'; ?>
<body class="contenedor-principal">
<?php include '../plantillas/header.php'; ?>
<main class="main">
    <div class="contenedor-formulario-cuestionario">
        <h1 class="titulo-formulario-cuestionario">Agregar cuestionario</h1>
        <form action="../quizz/quizz-crear.php" method="post" class="formulario-cuestionario">
            <div class="input-container">
                <input type="text" name="titulo" id="titulo" class="input-formulario-cuestionario" required placeholder=" ">
                <label for="titulo" class="label-formulario-cuestionario">Título</label>
            </div>
            <div class="input-container">
                <textarea name="descripcion" id="descripcion" class="input-formulario-cuestionario" required placeholder=" "></textarea>
                <label for="descripcion" class="label-formulario-cuestionario">Descripción</label>
            </div>
            <div class="input-container">
                <input type="number" name="numero_preguntas" id="numero_preguntas" class="input-formulario-cuestionario" required placeholder=" ">
                <label for="numero_preguntas" class="label-formulario-cuestionario">Número de preguntas</label>
            </div>
            <input type="submit" value="Crear cuestionario" class="boton-formulario-cuestionario">
        </form>
        <?php
        if (isset($_GET["error-creacion"])) {
            echo '<span class="error-creacion">' . $_GET["error-creacion"] . "</span>";
        }
        ?>
    </div>
</main>
<?php include '../plantillas/footer.php'; ?>
</body>
</html>
