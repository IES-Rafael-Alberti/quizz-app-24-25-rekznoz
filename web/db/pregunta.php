<?php
require_once 'PDO.php';

class Pregunta
{
    private static $instance = null;
    private $conn;

    // Constructor privado para establecer la conexión
    private function __construct()
    {
        global $conn;  // Asumimos que $conn es una conexión PDO ya establecida
        $this->conn = $conn;
    }

    // Obtener la instancia del modelo
    public static function getInstance(): ?Pregunta
    {
        if (self::$instance === null) {
            self::$instance = new Pregunta();
        }

        return self::$instance;
    }

    // Crear una nueva pregunta
    public function crearPregunta($quiz_id, $pregunta_texto, $opcion_a, $opcion_b, $opcion_c, $opcion_d, $opcion_correcta): false|string
    {
        $sql = "INSERT INTO preguntas (quiz_id, pregunta_texto, opcion_a, opcion_b, opcion_c, opcion_d, opcion_correcta) 
                VALUES (:quiz_id, :pregunta_texto, :opcion_a, :opcion_b, :opcion_c, :opcion_d, :opcion_correcta)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
        $stmt->bindParam(':pregunta_texto', $pregunta_texto);
        $stmt->bindParam(':opcion_a', $opcion_a);
        $stmt->bindParam(':opcion_b', $opcion_b);
        $stmt->bindParam(':opcion_c', $opcion_c);
        $stmt->bindParam(':opcion_d', $opcion_d);
        $stmt->bindParam(':opcion_correcta', $opcion_correcta);

        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    // Obtener una pregunta por su ID
    public function obtenerPregunta($pregunta_id)
    {
        $sql = "SELECT * FROM preguntas WHERE pregunta_id = :pregunta_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':pregunta_id', $pregunta_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener todas las preguntas de un quiz
    public function obtenerPreguntasPorQuiz($quiz_id)
    {
        $sql = "SELECT * FROM preguntas WHERE quiz_id = :quiz_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar una pregunta
    public function actualizarPregunta($pregunta_id, $pregunta_texto, $opcion_a, $opcion_b, $opcion_c, $opcion_d, $opcion_correcta): bool
    {
        $sql = "UPDATE preguntas 
                SET pregunta_texto = :pregunta_texto, opcion_a = :opcion_a, opcion_b = :opcion_b, 
                    opcion_c = :opcion_c, opcion_d = :opcion_d, opcion_correcta = :opcion_correcta
                WHERE pregunta_id = :pregunta_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':pregunta_id', $pregunta_id, PDO::PARAM_INT);
        $stmt->bindParam(':pregunta_texto', $pregunta_texto);
        $stmt->bindParam(':opcion_a', $opcion_a);
        $stmt->bindParam(':opcion_b', $opcion_b);
        $stmt->bindParam(':opcion_c', $opcion_c);
        $stmt->bindParam(':opcion_d', $opcion_d);
        $stmt->bindParam(':opcion_correcta', $opcion_correcta);

        return $stmt->execute();
    }

    // Eliminar una pregunta por ID
    public function eliminarPregunta($pregunta_id): bool
    {
        $sql = "DELETE FROM preguntas WHERE pregunta_id = :pregunta_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':pregunta_id', $pregunta_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
