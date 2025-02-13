<?php
require_once 'PDO.php';

class QuizResultado
{
    private static $instance = null;
    private $conn;

    // Constructor privado para Singleton
    private function __construct()
    {
        global $conn; // Se asume que $conn es una conexión PDO establecida
        $this->conn = $conn;
    }

    // Obtener la instancia del modelo
    public static function getInstance(): ?QuizResultado
    {
        if (self::$instance === null) {
            self::$instance = new QuizResultado();
        }

        return self::$instance;
    }

    // Crear un nuevo resultado de cuestionario
    public function crearResultado($usuario_id, $quiz_id, $puntuacion, $total_preguntas): false|string
    {
        $porcentaje = ($puntuacion / $total_preguntas) * 100;

        $sql = "INSERT INTO quiz_resultados (usuario_id, quiz_id, intentos, puntuacion, total_preguntas, porcentaje) 
                VALUES (:usuario_id, :quiz_id, :intentos, :puntuacion, :total_preguntas, :porcentaje)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
        $stmt->bindValue(':intentos', 1, PDO::PARAM_INT);
        $stmt->bindParam(':puntuacion', $puntuacion, PDO::PARAM_INT);
        $stmt->bindParam(':total_preguntas', $total_preguntas, PDO::PARAM_INT);
        $stmt->bindParam(':porcentaje', $porcentaje, PDO::PARAM_STR);

        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    // Obtener todos los resultados de un usuario
    public function obtenerResultadosPorUsuario($usuario_id)
    {
        $sql = "SELECT * FROM quiz_resultados WHERE usuario_id = :usuario_id ORDER BY fecha_completado DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un resultado específico por ID
    public function obtenerResultado($resultado_id)
    {
        $sql = "SELECT * FROM quiz_resultados WHERE resultado_id = :resultado_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':resultado_id', $resultado_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener Intentos de un usuario en un quiz
    public function obtenerIntentosPorUsuario($usuario_id, $quiz_id)
    {
        try {
            $sql = "SELECT * FROM quiz_resultados WHERE usuario_id = :usuario_id AND quiz_id = :quiz_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Actualizar un resultado de cuestionario
    public function actualizarResultado($resultado_id, $puntuacion, $total_preguntas, $intentos)
    {

        $porcentaje = ($puntuacion / $total_preguntas) * 100;

        $sql = "UPDATE quiz_resultados 
                SET intentos = :intentos, puntuacion = :puntuacion, total_preguntas = :total_preguntas, porcentaje = :porcentaje 
                WHERE resultado_id = :resultado_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':intentos', $intentos, PDO::PARAM_INT);
        $stmt->bindParam(':puntuacion', $puntuacion, PDO::PARAM_INT);
        $stmt->bindParam(':total_preguntas', $total_preguntas, PDO::PARAM_INT);
        $stmt->bindParam(':porcentaje', $porcentaje, PDO::PARAM_STR);
        $stmt->bindParam(':resultado_id', $resultado_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Eliminar un resultado de cuestionario
    public function eliminarResultado($resultado_id)
    {
        $sql = "DELETE FROM quiz_resultados WHERE resultado_id = :resultado_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':resultado_id', $resultado_id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
