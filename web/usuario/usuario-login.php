<?php
require_once '../db/pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validación básica de los datos recibidos
    $usuario = filter_var($_POST['usuario']);
    $contrasena = $_POST['contrasena']; // No hace falta sanitizar la contraseña, ya que no se almacena directamente

    if (empty($usuario) || empty($contrasena)) {
        // Redirigir si los campos están vacíos
        header('Location: ../login.php?error-login=Campos vacíos');
        exit;
    }

    // Consulta para verificar si el usuario existe
    $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        // Iniciar sesión si las credenciales son correctas
        session_start();
        $_SESSION['usuario'] = $usuario['usuario'];
        $_SESSION['id'] = $usuario['id'];
        header('Location: ../index.php');
        exit;
    } else {
        // Redirigir con error si las credenciales son incorrectas
        header('Location: ../login.php?error-login=Usuario o contraseña incorrectos');
        exit;
    }
}
