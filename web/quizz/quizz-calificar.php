<?php
require_once '../db/Quizz.php';
require_once '../db/Pregunta.php';
require_once '../db/QuizResultado.php';
require_once '../db/UsuarioRespuesta.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quizId = $_POST['quiz_id'];
    $usuarioId = $_SESSION['id'];

    $quizz = Quizz::getInstance();
    $preguntas = Pregunta::getInstance();
    $usuarioRespuesta = UsuarioRespuesta::getInstance();
    $quizResultado = QuizResultado::getInstance();

    $quiz = $quizz->obtenerQuizPorId($quizId);
    $preguntas = $preguntas->obtenerPreguntasPorQuiz($quizId);

    $totalPreguntas = count($preguntas);
    $puntuacion = 0;

    // Obtener respuestas previas del usuario para este test
    $respuestasPrevias = $usuarioRespuesta->obtenerRespuestasPorUsuario($usuarioId, $quizId);
    $respuestasMap = [];

    foreach ($respuestasPrevias as $respuesta) {
        $respuestasMap[$respuesta['pregunta_id']] = $respuesta;
    }

    foreach ($preguntas as $pregunta) {
        $preguntaId = $pregunta['pregunta_id'];
        $opcionSeleccionada = $_POST['pregunta_' . $preguntaId];
        $esCorrecto = (strtoupper(trim($pregunta['opcion_correcta'])) === strtoupper(trim($opcionSeleccionada)));

        if (isset($respuestasMap[$preguntaId])) {
            $usuarioRespuesta->actualizarRespuesta($respuestasMap[$preguntaId]['respuesta_id'], $opcionSeleccionada, $esCorrecto);
        } else {
            // Si no existe, crearla
            $usuarioRespuesta->crearRespuesta($usuarioId, $quizId, $preguntaId, $opcionSeleccionada, $esCorrecto);
        }

        if ($esCorrecto) {
            $puntuacion++;
        }
    }

    // Verificar si ya hay un resultado previo
    $intentos = $quizResultado->obtenerIntentosPorUsuario($usuarioId, $quizId);

    if ($intentos) {
        $quizResultado->actualizarResultado($intentos['resultado_id'], $puntuacion, $totalPreguntas, $intentos['intentos'] + 1);
    } else {
        $quizResultado->crearResultado($usuarioId, $quizId, $puntuacion, $totalPreguntas);
    }

    header('Location: ../vista/ver-quizz.php?id=' . $quizId);
    exit;
}
?>
