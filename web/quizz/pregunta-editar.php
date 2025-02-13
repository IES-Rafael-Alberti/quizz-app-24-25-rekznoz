<?php
require_once '../db/Pregunta.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../vista/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quiz_id = $_POST['quiz_id'];
    $pregunta_ids = $_POST['pregunta_id'];
    $preguntas_texto = $_POST['pregunta_texto'];
    $opciones_a = $_POST['opcion_a'];
    $opciones_b = $_POST['opcion_b'];
    $opciones_c = $_POST['opcion_c'];
    $opciones_d = $_POST['opcion_d'];
    $opciones_correctas = $_POST['opcion_correcta'];

    $preguntasInstancia = Pregunta::getInstance();
    $error = false;

    // Recorrer cada pregunta y actualizar
    for ($i = 0; $i < count($pregunta_ids); $i++) {
        $actualizado = $preguntasInstancia->actualizarPregunta(
            $pregunta_ids[$i],
            $preguntas_texto[$i],
            $opciones_a[$i],
            $opciones_b[$i],
            $opciones_c[$i],
            $opciones_d[$i],
            $opciones_correctas[$i]
        );

        if (!$actualizado) {
            $error = true;
        }
    }

    if ($error) {
        header('Location: ../vista/editar-preguntas.php?id=' . $quiz_id . '&error-edicion=No se pudieron actualizar todas las preguntas.');
    } else {
        header('Location: ../vista/perfil.php');
    }
    exit;
}
