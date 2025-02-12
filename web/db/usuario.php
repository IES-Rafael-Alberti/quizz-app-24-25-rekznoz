<?php
require_once '../db/pdo.php';

class Usuario
{
    private static $instance = null;
    private $conn;

    // Constructor para establecer la conexión
    private function __construct()
    {
        global $conn;  // Asumimos que $conn es una conexión PDO ya establecida
        $this->conn = $conn;
    }

    // Método para obtener la instancia del modelo
    public static function getInstance(): ?Usuario
    {
        if (self::$instance === null) {
            self::$instance = new Usuario();
        }

        return self::$instance;
    }

    // Crear Usuario usando password_hash
    public function crearUsuario($usuario, $contrasena): false|string
    {
        $sql = "INSERT INTO usuarios (username, password) VALUES (:usuario, :contrasena)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $contrasenaEncriptada = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt->bindParam(':contrasena', $contrasenaEncriptada);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    // Verificar si el usuario existe
    public function verificarUsuario($usuario)
    {
        $sql = "SELECT * FROM usuarios WHERE username = :usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Obtener Usuario para login y verificar la contraseña con password_verify
    public function obtenerUsuario($usuario, $contrasena)
    {
        $sql = "SELECT * FROM usuarios WHERE username = :usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($contrasena, $usuario['password'])) {
            return $usuario;
        }

        return false; // Usuario no encontrado o contraseña incorrecta
    }
}
