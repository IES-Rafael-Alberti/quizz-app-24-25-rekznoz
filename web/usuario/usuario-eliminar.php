<?php
require_once '../db/Usuario.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../vista/login.php');
    exit;
}

if ($_SESSION['rol'] !== 'admin') {
    header('Location: ../vista/index.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: ../vista/lista-usuarios.php');
    exit;
}

$usuarioInstancia = Usuario::getInstance();
$usuario = $usuarioInstancia->eliminarUsuario($_GET['id']);

header('Location: ../vista/lista-usuarios.php');
