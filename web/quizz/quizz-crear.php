<?php
require_once '../db/Quizz.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario_id = $_SESSION['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $quizz = Quizz::getInstance();

    $quizz->obtenerQuizPorTitulo($titulo);

    if ($quizz->obtenerQuizPorTitulo($titulo)) {
        header('Location: ../agregar-quizz.php?error-creacion=El cuestionario ya existe.');
        exit;
    }

    $quizz->crearQuiz($titulo, $descripcion, $usuario_id);

    if ($quizz->crearQuiz($titulo, $descripcion, $usuario_id)) {
        header('Location: ../perfil.php');;
    } else {
        header('Location: ../agregar-quizz.php?error-creacion=Error al crear el cuestionario.');
    }

    exit;

} else {
    header('Location: ../agregar-quizz.php?error-creacion=Error al crear el cuestionario.');
    exit;
}