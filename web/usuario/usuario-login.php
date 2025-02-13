<?php
require_once '../db/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validación básica de los datos recibidos
    $usuario = filter_var($_POST['usuario']);
    $contrasena = $_POST['contrasena']; // No hace falta sanitizar la contraseña, ya que no se almacena directamente

    if (empty($usuario) || empty($contrasena)) {
        // Redirigir si los campos están vacíos
        header('Location: ../login.php?error-login=Campos vacíos');
        exit;
    }

    $model = Usuario::getInstance();

    // Verificar si el usuario existe
    $usuarioData = $model->verificarUsuario($usuario);
    if ($usuarioData) {
        // Verificar la contraseña
        if (password_verify($contrasena, $usuarioData['secreto'])) {
            session_start();
            $_SESSION['usuario'] = $usuario;
            $_SESSION['id'] = $usuarioData['id'];
            header('Location: ../perfil.php');
        } else {
            header('Location: ../login.php?error-login=Contraseña incorrecta');
        }
    } else {
        header('Location: ../login.php?error-login=Usuario no encontrado');
    }
    exit;
}
