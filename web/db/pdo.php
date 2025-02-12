<?php

$servidor = '192.168.1.9';
$puerto = '3306';
$usuario = 'root';
$clave = 'lolman';
$bd = 'quizz';

try {
    $options = [
        PDO::ATTR_EMULATE_PREPARES => false, // Desactivar emulación de sentencias
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Activar excepciones para errores
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Modo de recuperación de datos por defecto
    ];

    // Conexión a la base de datos usando PDO
    $conn = new PDO("mysql:host=$servidor;dbname=$bd;port=$puerto;charset=utf8", $usuario, $clave, $options);

    // Establecer el modo de error
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    echo "Error de conexión: " . $e->getMessage();
    exit;
}
