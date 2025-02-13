<?php
require_once 'PDO.php';

class Quizz
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
    public static function getInstance(): ?Quizz
    {
        if (self::$instance === null) {
            self::$instance = new Quizz();
        }

        return self::$instance;
    }

    // ✅ Crear un nuevo quiz
    public function crearQuiz($titulo, $descripcion, $creado_por): false|string
    {
        $sql = "INSERT INTO quizzes (titulo, descripcion, creado_por) VALUES (:titulo, :descripcion, :creado_por)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':creado_por', $creado_por);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    // 📌 Obtener un quiz por su ID
    public function obtenerQuizPorId($quiz_id)
    {
        $sql = "SELECT * FROM quizzes WHERE quiz_id = :quiz_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quiz_id', $quiz_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // 📜 Obtener todos los quizzes
    public function obtenerTodosLosQuizzes()
    {
        $sql = "SELECT * FROM quizzes";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    // ✏️ Actualizar un quiz
    public function actualizarQuiz($quiz_id, $titulo, $descripcion)
    {
        $sql = "UPDATE quizzes SET titulo = :titulo, descripcion = :descripcion WHERE quiz_id = :quiz_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quiz_id', $quiz_id);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        return $stmt->execute();
    }

    // Obtener Quiz por titulo
    public function obtenerQuizPorTitulo($titulo)
    {
        $sql = "SELECT * FROM quizzes WHERE titulo = :titulo";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->execute();
        return $stmt->fetch();
    }

    // 🗑️ Eliminar un quiz
    public function eliminarQuiz($quiz_id)
    {
        $sql = "DELETE FROM quizzes WHERE quiz_id = :quiz_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quiz_id', $quiz_id);
        return $stmt->execute();
    }
}
