<?php
require_once '../db/Usuario.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../vista/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_POST['usuario_id'];

    $usuario = Usuario::getInstance();

    $usuario->actualizarUsuario($usuario_id, $_POST['rol']);
    header('Location: ../vista/lista-usuarios.php');
    exit;
}