<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once '../db/Quizz.php';

if ($_GET['id']) {
    $quizz = Quizz::getInstance();
    $quizz->eliminarQuiz($_GET['id']);

    header('Location: ../vista/perfil.php');
}