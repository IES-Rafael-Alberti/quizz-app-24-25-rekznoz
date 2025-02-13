<?php
require_once 'pdo.php';

class Usuario
{
    private static $instance = null;
    private $conn;

    // Constructor para establecer la conexión
    private function __construct()
    {
        global $conn; // Asumimos que $conn es una conexión PDO ya establecida
        $this->conn = $conn;
    }

    // Método para obtener la instancia del modelo (Patrón Singleton)
    public static function getInstance(): ?Usuario
    {
        if (self::$instance === null) {
            self::$instance = new Usuario();
        }
        return self::$instance;
    }

    // Crear Usuario con password_hash
    public function crearUsuario($usuario, $contrasena, $rol = 'estudiante')
    {
        try {
            $sql = "INSERT INTO usuarios (usuario, secreto, rol) VALUES (:usuario, :contrasena, :rol)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $contrasenaEncriptada = password_hash($contrasena, PASSWORD_DEFAULT);
            $stmt->bindParam(':contrasena', $contrasenaEncriptada);
            $stmt->bindParam(':rol', $rol);
            $stmt->execute();
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Verificar si el usuario existe
    public function verificarUsuario($usuario)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener Usuario para login y verificar la contraseña con password_verify
    public function obtenerUsuario($usuario, $contrasena)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioData && password_verify($contrasena, $usuarioData['secreto'])) {
            return $usuarioData;
        }

        return false; // Usuario no encontrado o contraseña incorrecta
    }

    // Obtener todos los usuarios
    public function obtenerUsuarios()
    {
        $sql = "SELECT usuario_id, usuario, rol, fecha_creado FROM usuarios";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar usuario (solo cambia el rol, no la contraseña)
    public function actualizarUsuario($usuario_id, $nuevoRol)
    {
        try {
            $sql = "UPDATE usuarios SET rol = :rol WHERE usuario_id = :usuario_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':rol', $nuevoRol);
            $stmt->bindParam(':usuario_id', $usuario_id);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Eliminar usuario
    public function eliminarUsuario($usuario_id)
    {
        try {
            $sql = "DELETE FROM usuarios WHERE usuario_id = :usuario_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
