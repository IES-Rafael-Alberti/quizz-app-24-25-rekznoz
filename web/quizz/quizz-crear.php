<?php
require_once '../db/Quizz.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../vista/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario_id = $_SESSION['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $numero_preguntas = $_POST['numero_preguntas'];
    $quizz = Quizz::getInstance();

    if ($quizz->obtenerQuizPorTitulo($titulo)) {
        header('Location: ../vista/agregar-quizz.php?error-creacion=El cuestionario ya existe.');
        exit;
    }

    $quizzCreado = $quizz->crearQuiz($titulo, $descripcion, $usuario_id);

    if ($quizzCreado) {
        header('Location: ../vista/agregar-preguntas.php?quiz_id=' . $quizzCreado . '&numero_preguntas=' . $numero_preguntas);
        exit;
    } else {
        header('Location: ../vista/agregar-quizz.php?error-creacion=Error al crear el cuestionario.');
        exit;
    }

} else {
    header('Location: ../vista/agregar-quizz.php?error-creacion=Error al crear el cuestionario.');
    exit;
}