<?php
require_once 'pdo.php';

class UsuarioRespuesta
{
    private static $instance = null;
    private $conn;

    // Constructor privado para la conexión PDO
    private function __construct()
    {
        global $conn;  // Se asume que $conn es una conexión PDO establecida
        $this->conn = $conn;
    }

    // Obtener la instancia del modelo (Singleton)
    public static function getInstance(): ?UsuarioRespuesta
    {
        if (self::$instance === null) {
            self::$instance = new UsuarioRespuesta();
        }

        return self::$instance;
    }

    // Crear una respuesta de usuario
    public function crearRespuesta($usuario_id, $quiz_id, $pregunta_id, $opcion_seleccionada, $es_correcto)
    {
        $sql = "INSERT INTO usuarios_respuestas (usuario_id, quiz_id, pregunta_id, opcion_seleccionada, es_correcto) 
                VALUES (:usuario_id, :quiz_id, :pregunta_id, :opcion_seleccionada, :es_correcto)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
        $stmt->bindParam(':pregunta_id', $pregunta_id, PDO::PARAM_INT);
        $stmt->bindParam(':opcion_seleccionada', $opcion_seleccionada);
        $stmt->bindParam(':es_correcto', $es_correcto, PDO::PARAM_BOOL);

        return $stmt->execute();
    }

    // Obtener respuestas de un usuario para un quiz específico
    public function obtenerRespuestasPorUsuario($usuario_id, $quiz_id)
    {
        $sql = "SELECT * FROM usuarios_respuestas WHERE usuario_id = :usuario_id AND quiz_id = :quiz_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una respuesta específica
    public function obtenerRespuestaPorId($respuesta_id)
    {
        $sql = "SELECT * FROM usuarios_respuestas WHERE respuesta_id = :respuesta_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':respuesta_id', $respuesta_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar una respuesta
    public function actualizarRespuesta($respuesta_id, $opcion_seleccionada, $es_correcto)
    {
        $sql = "UPDATE usuarios_respuestas 
                SET opcion_seleccionada = :opcion_seleccionada, es_correcto = :es_correcto 
                WHERE respuesta_id = :respuesta_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':respuesta_id', $respuesta_id, PDO::PARAM_INT);
        $stmt->bindParam(':opcion_seleccionada', $opcion_seleccionada);
        $stmt->bindParam(':es_correcto', $es_correcto, PDO::PARAM_BOOL);

        return $stmt->execute();
    }

    // Eliminar una respuesta
    public function eliminarRespuesta($respuesta_id)
    {
        $sql = "DELETE FROM usuarios_respuestas WHERE respuesta_id = :respuesta_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':respuesta_id', $respuesta_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
