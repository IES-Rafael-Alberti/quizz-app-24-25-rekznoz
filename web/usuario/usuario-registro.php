<?php
require_once '../db/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitizar y validar datos de entrada
    $usuario = filter_var($_POST['usuario']);
    $contrasena = $_POST['contrasena'];
    $contrasena2 = $_POST['contrasena2'];

    // Verificar que las contraseñas coincidan
    if ($contrasena !== $contrasena2) {
        header('Location: ../registro.php?error-registro=Las contraseñas no coinciden');
        exit;
    }

    // Validar que el usuario no esté vacío
    if (empty($usuario) || empty($contrasena)) {
        header('Location: ../registro.php?error-registro=Campos vacíos');
        exit;
    }

    $model = Usuario::getInstance();

    // Verificar si el usuario ya existe
    $usuarioExistente = $model->verificarUsuario($usuario);
    if ($usuarioExistente) {
        header('Location: ../registro.php?error-registro=El usuario ya existe');
        exit;
    }

    // Crear el nuevo usuario
    $id = $model->crearUsuario($usuario, $contrasena);
    if ($id) {
        session_start();
        $_SESSION['usuario'] = $usuario;
        $_SESSION['id'] = $id;
        header('Location: ../index.php');
        exit;
    } else {
        header('Location: ../registro.php?error-registro=Error al crear el usuario');
        exit;
    }

}
