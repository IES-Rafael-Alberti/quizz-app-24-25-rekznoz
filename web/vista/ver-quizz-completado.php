<?php
session_start();

if (!isset($_GET['id'])) {
    die("El cuestionario no existe.");
}

require_once '../db/Quizz.php';
require_once '../db/Pregunta.php';
require_once '../db/UsuarioRespuesta.php';

$quizId = $_GET['id'];
$usuarioId = $_SESSION['id'] ?? null; // Asegúrate de tener el ID del usuario en sesión

$quizz = Quizz::getInstance();
$preguntas = Pregunta::getInstance();
$usuarioRespuesta = UsuarioRespuesta::getInstance();

$quiz = $quizz->obtenerQuizPorId($quizId);
$preguntas = $preguntas->obtenerPreguntasPorQuiz($quizId);

// Obtener respuestas guardadas del usuario
$respuestasUsuario = $usuarioRespuesta->obtenerRespuestasPorUsuario($usuarioId, $quizId);
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

        <?php foreach ($preguntas as $pregunta): ?>
            <?php
            $respuestaSeleccionada = null;
            $esCorrecto = false;
            $opcionCorrecta = strtoupper($pregunta['opcion_correcta']);
            foreach ($respuestasUsuario as $respuesta) {
                if ($respuesta['pregunta_id'] === $pregunta['pregunta_id']) {
                    $respuestaSeleccionada = $respuesta['opcion_seleccionada'];
                    $esCorrecto = $respuesta['es_correcto'];
                    break;
                }
            }
            $opcionCorrecta = $pregunta['opcion_correcta'];
            ?>

            <div class="pregunta">
                <p class="pregunta-texto"><?php echo $pregunta['pregunta_texto']; ?></p>
                <div class="opciones">
                    <p <?php echo ($respuestaSeleccionada === 'A') ? 'class="seleccionada"' : ''; ?>>
                        A) <?php echo $pregunta['opcion_a']; ?>
                        <?php echo ($respuestaSeleccionada === 'A') ? ($esCorrecto ? ' ✅ Correcto' : ' ❌ Incorrecto') : ''; ?>
                    </p>
                    <p <?php echo ($respuestaSeleccionada === 'B') ? 'class="seleccionada"' : ''; ?>>
                        B) <?php echo $pregunta['opcion_b']; ?>
                        <?php echo ($respuestaSeleccionada === 'B') ? ($esCorrecto ? ' ✅ Correcto' : ' ❌ Incorrecto') : ''; ?>
                    </p>
                    <p <?php echo ($respuestaSeleccionada === 'C') ? 'class="seleccionada"' : ''; ?>>
                        C) <?php echo $pregunta['opcion_c']; ?>
                        <?php echo ($respuestaSeleccionada === 'C') ? ($esCorrecto ? ' ✅ Correcto' : ' ❌ Incorrecto') : ''; ?>
                    </p>
                    <p <?php echo ($respuestaSeleccionada === 'D') ? 'class="seleccionada"' : ''; ?>>
                        D) <?php echo $pregunta['opcion_d']; ?>
                        <?php echo ($respuestaSeleccionada === 'D') ? ($esCorrecto ? ' ✅ Correcto' : ' ❌ Incorrecto') : ''; ?>
                    </p>
                </div>
                <?php if (!$esCorrecto): ?>
                    <p class="respuesta-correcta">Respuesta correcta: <strong><?php echo $opcionCorrecta; ?></strong></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php include '../plantillas/footer.php'; ?>
</body>
</html>

