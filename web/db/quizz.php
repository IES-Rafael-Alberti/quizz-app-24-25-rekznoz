<?php
require_once './db/pdo.php'; // Asegúrate de que la conexión a la base de datos esté disponible

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

    // Crear un nuevo cuestionario
    public function crearQuizz($title, $description)
    {
        $sql = "INSERT INTO Cuestionarios (title, description) VALUES (:title, :description)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);

        try {
            $stmt->execute();
            return $this->conn->lastInsertId(); // Devuelve el ID del nuevo cuestionario
        } catch (PDOException $e) {
            return "Error al crear el cuestionario: " . $e->getMessage();
        }
    }

    // Obtener un cuestionario por su ID
    public function obtenerQuizz($quiz_id)
    {
        $sql = "SELECT * FROM Cuestionarios WHERE quiz_id = :quiz_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quiz_id', $quiz_id);
        $stmt->execute();
        return $stmt->fetch(); // Devuelve el cuestionario encontrado
    }

    // Obtener todos los cuestionarios
    public function obtenerTodosLosQuizzes()
    {
        $sql = "SELECT * FROM Cuestionarios";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(); // Devuelve todos los cuestionarios
    }
}
