<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once '../db/Quizz.php';

?>

<!doctype html>
<html lang="es">
<?php include '../plantillas/head.php'; ?>
<body class="contenedor-principal">
<?php include '../plantillas/header.php'; ?>
<main class="main">
    <div class="contenedor-formulario-cuestionario">
        <h1 class="titulo-formulario-cuestionario">Editar cuestionario</h1>
        <?php
        $quizz = Quizz::getInstance();
        $quiz_id = $_GET['id'];
        $cuestionario = $quizz->obtenerQuizPorId($quiz_id);
        ?>
        <form action="../quizz/quizz-editar.php" method="post" class="formulario-cuestionario">
            <input type="hidden" name="quiz_id" value="<?php echo $cuestionario['quiz_id']; ?>">
            <div class="input-container">
                <input type="text" name="titulo" id="titulo" class="input-formulario-cuestionario" required placeholder=" " value="<?php echo $cuestionario['titulo']; ?>">
                <label for="titulo" class="label-formulario-cuestionario">Título</label>
            </div>
            <div class="input-container">
                <textarea name="descripcion" id="descripcion" class="input-formulario-cuestionario" required placeholder=" "><?php echo $cuestionario['descripcion']; ?></textarea>
                <label for="descripcion" class="label-formulario-cuestionario">Descripción</label>
            </div>
            <input type="submit" value="Editar cuestionario" class="boton-formulario-cuestionario">
        </form>
        <?php
        if (isset($_GET["error-edicion"])) {
            echo '<span class="error-creacion">' . $_GET["error-edicion"] . "</span>";
        }
        ?>
    </div>
</main>
<?php include '../plantillas/footer.php'; ?>
</body>
</html>
