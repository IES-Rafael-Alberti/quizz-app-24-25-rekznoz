<?php
require_once '../db/Quizz.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

if (isset($_GET['titulo']) && isset($_GET['descripcion'])) {

    $usuario_id = $_SESSION['id'];
    $titulo = $_GET['titulo'];
    $descripcion = $_GET['descripcion'];
    $quizz = Quizz::getInstance();

    $quizz->obtenerQuizPorTitulo($titulo);

    if ($quizz->obtenerQuizPorTitulo($titulo) == null) {
        $quizz->crearQuiz($titulo, $descripcion, $usuario_id);
        header('Location: ../index.php');
    } else {
        header('Location: ../agregar-quizz.php?error-creacion=El cuestionario ya existe.');
    }

} else {
    header('Location: ../agregar-quizz.php?error-creacion=Error al crear el cuestionario.');
}