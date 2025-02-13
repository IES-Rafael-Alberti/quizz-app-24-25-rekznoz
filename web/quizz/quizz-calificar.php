<?php
require_once '../db/Quizz.php';
require_once '../db/Pregunta.php';
require_once '../db/QuizResultado.php';
require_once '../db/UsuarioRespuesta.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quizId = $_POST['quiz_id'];

    $quizz = Quizz::getInstance();
    $preguntas = Pregunta::getInstance();
    $usuarioRespuesta = UsuarioRespuesta::getInstance();
    $quizResultado = QuizResultado::getInstance();

    $quiz = $quizz->obtenerQuizPorId($quizId);
    $preguntas = $preguntas->obtenerPreguntasPorQuiz($quizId);

    $totalPreguntas = count($preguntas);
    $puntuacion = 0;

    foreach ($preguntas as $pregunta) {
        $preguntaId = $pregunta['pregunta_id'];
        $opcionSeleccionada = $_POST['pregunta_' . $preguntaId];
        $esCorrecto = $pregunta['opcion_correcta'] === $opcionSeleccionada;

        $usuarioRespuesta->crearRespuesta($_SESSION['usuario_id'], $quizId, $preguntaId, $opcionSeleccionada, $esCorrecto);

        if ($esCorrecto) {
            $puntuacion++;
        }
    }

    $quizResultado->crearResultado($_SESSION['usuario_id'], $quizId, $puntuacion, $totalPreguntas);

    header('Location: ../vista/ver-quizz.php?id=' . $quizId);
    exit;
}