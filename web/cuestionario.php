<?php
require_once 'db/Quizz.php';
session_start();

if (isset($_GET['id'])) {
    $quizId = $_GET['id'];
    $quizz = Quizz::getInstance();
    $quiz = $quizz->obtenerQuizz($quizId);
    //$preguntas = $quizz->obtenerPreguntas($quizId);
} else {
    die("El cuestionario no existe.");
}
?>
<!doctype html>
<html lang="es">
<?php include 'plantillas/head.php'; ?>
<body class="contenedor-principal">
<?php include 'plantillas/header.php'; ?>
<main class="main">
    <h1><?php echo $quiz['title']; ?></h1>
    <p><?php echo $quiz['description']; ?></p>
    <form action="resultado.php" method="post">
        <?php
        // foreach ($preguntas as $pregunta) {
        //     echo "<h2>{$pregunta['question']}</h2>";
        //     echo "<input type='radio' name='pregunta_{$pregunta['question_id']}' value='1'>{$pregunta['option1']}<br>";
        //     echo "<input type='radio' name='pregunta_{$pregunta['question_id']}' value='2'>{$pregunta['option2']}<br>";
        //     echo "<input type='radio' name='pregunta_{$pregunta['question_id']}' value='3'>{$pregunta['option3']}<br>";
        //     echo "<input type='radio' name='pregunta_{$pregunta['question_id']}' value='4'>{$pregunta['option4']}<br>";
        // }
        ?>
        <button type="submit">Enviar</button>
    </form>
</main>
<?php include 'plantillas/footer.php'; ?>
</body>
</html>
