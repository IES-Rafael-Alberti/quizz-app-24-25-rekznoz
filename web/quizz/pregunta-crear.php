<?php
session_start();
require_once '../db/PDO.php';
require_once '../db/Pregunta.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

// Verificar si los datos fueron enviados correctamente
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $quiz_id = $_POST['quiz_id'];

    try {
        $preguntaModel = Pregunta::getInstance();

        // Iterar sobre las preguntas enviadas
        foreach ($_POST as $key => $value) {
            if (str_starts_with($key, 'pregunta')) {
                $num_pregunta = str_replace('pregunta', '', $key);
                $pregunta_texto = trim($_POST[$key]);
                $opcion_a = trim($_POST["opcion_A_$num_pregunta"]);
                $opcion_b = trim($_POST["opcion_B_$num_pregunta"]);
                $opcion_c = trim($_POST["opcion_C_$num_pregunta"]);
                $opcion_d = trim($_POST["opcion_D_$num_pregunta"]);
                $opcion_correcta = $_POST["correcta$num_pregunta"];

                // Insertar la pregunta
                $preguntaModel->crearPregunta($quiz_id, $pregunta_texto, $opcion_a, $opcion_b, $opcion_c, $opcion_d, $opcion_correcta);
            }
        }

        // Redirigir con éxito
        header("Location: ../perfil.php?mensaje=Preguntas agregadas correctamente!");
        exit;

    } catch (Exception $e) {
        header("Location: ../quizz/agregar-preguntas.php?quiz_id=$quiz_id&error-creacion=Error: " . $e->getMessage());
        exit;
    }
} else {
    header('Location: ../perfil.php');
    exit;
}
