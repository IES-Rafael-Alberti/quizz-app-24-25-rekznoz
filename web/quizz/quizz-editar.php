<?php
require_once '../db/Quizz.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../vista/login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quizId = $_POST['quiz_id'];

    $quizz = Quizz::getInstance();

    $quiz = $quizz->obtenerQuizPorId($quizId);

    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];

    $quizz->actualizarQuiz($quizId, $titulo, $descripcion);
    header('Location: ../vista/editar-preguntas.php?id=' . $quizId);
    exit;

}

