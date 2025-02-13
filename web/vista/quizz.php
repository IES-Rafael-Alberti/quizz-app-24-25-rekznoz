<?php
session_start();
?>

<!doctype html>
<html lang="es">
<?php include '../plantillas/head.php'; ?>
<body class="contenedor-principal">
<?php include '../plantillas/header.php'; ?>
<main class="main">
    <p>Cuestionarios disponibles</p>
    <ul>
        <?php
        require_once '../db/Quizz.php';
        $quizz = Quizz::getInstance();
        $quizzes = $quizz->obtenerTodosLosQuizzes();
        foreach ($quizzes as $quiz) {
            echo "<li><a href='cuestionario.php?id={$quiz['quiz_id']}'>{$quiz['title']}</a></li>";
        }
        ?>
    </ul>
</main>
<?php include '../plantillas/footer.php'; ?>
</body>
</html>
