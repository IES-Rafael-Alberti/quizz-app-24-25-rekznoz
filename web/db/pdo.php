<?php

$servidor = 'db';
$usuario = 'rafa';
$clave = 'asdasd';
$bd = 'quizz';

try {
    $options = [
        PDO::ATTR_EMULATE_PREPARES => false, // Desactivar emulación de sentencias
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Activar excepciones para errores
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Modo de recuperación de datos por defecto
    ];

    // Conexión a la base de datos usando PDO
    $conn = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $usuario, $clave, $options);

    // Establecer el modo de error
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    echo "Error de conexión: " . $e->getMessage();
    exit;
}
