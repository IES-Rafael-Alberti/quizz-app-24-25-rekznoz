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
    <div class="contenedor-cuestionarios-hacer">
        <h1 class="titulo-cuestionarios-hacer">Cuestionarios</h1>
        <div class="contenedor-cuestionarios-hacer">
            <?php
            require_once '../db/Quizz.php';
            $quizz = Quizz::getInstance();
            $cuestionarios = $quizz->obtenerTodosLosQuizzes();
            foreach ($cuestionarios as $cuestionario) {
                ?>
                <div class="cuestionario-hacer">
                    <h2 class="titulo-cuestionario-hacer"><?php echo $cuestionario['titulo']; ?></h2>
                    <p class="descripcion-cuestionario-hacer"><?php echo $cuestionario['descripcion']; ?></p>
                    <a href="ver-quizz.php?id=<?php echo $cuestionario['quiz_id']; ?>" class="boton-cuestionario-hacer">Hacer cuestionario</a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</main>
<?php include '../plantillas/footer.php'; ?>
</body>
</html>
