<?php
require_once '../db/Quizz.php';
require_once '../db/Pregunta.php';
session_start();

if (isset($_GET['id'])) {
    $quizId = $_GET['id'];

    $quizz = Quizz::getInstance();
    $preguntas = Pregunta::getInstance();

    $quiz = $quizz->obtenerQuizPorId($quizId);
    $preguntas = $preguntas->obtenerPreguntasPorQuiz($quizId);

} else {
    die("El cuestionario no existe.");
}
?>
<!doctype html>
<html lang="es">
<?php include '../plantillas/head.php'; ?>
<body class="contenedor-principal">
<?php include '../plantillas/header.php'; ?>
<main class="main">
    <div class="contenedor-cuestionario-quizz">
        <h1 class="titulo-cuestionario-quizz"><?php echo $quiz['titulo']; ?></h1>
        <p class="descripcion-cuestionario-quizz"><?php echo $quiz['descripcion']; ?></p>
        <form action="../quizz/quizz-calificar.php" method="post">
            <input type="hidden" name="quiz_id" value="<?php echo $quizId; ?>">
            <?php foreach ($preguntas as $pregunta): ?>
                <div class="pregunta">
                    <p class="pregunta-texto"><?php echo $pregunta['pregunta_texto']; ?></p>
                    <div class="opciones">
                        <label>
                            <input type="radio" name="pregunta_<?php echo $pregunta['pregunta_id']; ?>" value="a">
                            <?php echo $pregunta['opcion_a']; ?>
                        </label>
                        <label>
                            <input type="radio" name="pregunta_<?php echo $pregunta['pregunta_id']; ?>" value="b">
                            <?php echo $pregunta['opcion_b']; ?>
                        </label>
                        <label>
                            <input type="radio" name="pregunta_<?php echo $pregunta['pregunta_id']; ?>" value="c">
                            <?php echo $pregunta['opcion_c']; ?>
                        </label>
                        <label>
                            <input type="radio" name="pregunta_<?php echo $pregunta['pregunta_id']; ?>" value="d">
                            <?php echo $pregunta['opcion_d']; ?>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="boton-cuestionario-quizz">Calificar cuestionario</button>
        </form>
    </div>
</main>
<?php include '../plantillas/footer.php'; ?>
</body>
</html>
