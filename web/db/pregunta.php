<?php
require_once './db/pdo.php'; // Asegúrate de que la conexión a la base de datos esté disponible

class Pregunta
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
    public static function getInstance(): ?Pregunta
    {
        if (self::$instance === null) {
            self::$instance = new Pregunta();
        }

        return self::$instance;
    }

    // Crear una nueva pregunta
    public function crearPregunta($quiz_id, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option)
    {
        $sql = "INSERT INTO Preguntas (quiz_id, question_text, option_a, option_b, option_c, option_d, correct_option) 
                VALUES (:quiz_id, :question_text, :option_a, :option_b, :option_c, :option_d, :correct_option)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quiz_id', $quiz_id);
        $stmt->bindParam(':question_text', $question_text);
        $stmt->bindParam(':option_a', $option_a);
        $stmt->bindParam(':option_b', $option_b);
        $stmt->bindParam(':option_c', $option_c);
        $stmt->bindParam(':option_d', $option_d);
        $stmt->bindParam(':correct_option', $correct_option);

        try {
            $stmt->execute();
            return $this->conn->lastInsertId(); // Devuelve el ID de la nueva pregunta
        } catch (PDOException $e) {
            return "Error al crear la pregunta: " . $e->getMessage();
        }
    }

    // Obtener todas las preguntas de un cuestionario
    public function obtenerPreguntasPorQuizz($quiz_id)
    {
        $sql = "SELECT * FROM Preguntas WHERE quiz_id = :quiz_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quiz_id', $quiz_id);
        $stmt->execute();
        return $stmt->fetchAll(); // Devuelve todas las preguntas del cuestionario
    }

    // Obtener una pregunta por su ID
    public function obtenerPregunta($question_id)
    {
        $sql = "SELECT * FROM Preguntas WHERE question_id = :question_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':question_id', $question_id);
        $stmt->execute();
        return $stmt->fetch(); // Devuelve la pregunta con el ID especificado
    }
}
