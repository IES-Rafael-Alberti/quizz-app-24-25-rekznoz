<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

require_once './db/Quizz.php';

?>

<!doctype html>
<html lang="es">
<?php include 'plantillas/head.php'; ?>
<body class="contenedor-principal">
<?php include 'plantillas/header.php'; ?>
<main class="main">
    <h1 class="titulo-mis-cuestionarios">Mis cuestionarios</h1>
    <div class="contenedor-cuestionarios">
        <?php
        $quizz = Quizz::getInstance();
        $usuario_id = $_SESSION['id'];
        $cuestionarios = $quizz->obtenerQuizzesPorUsuario($usuario_id);

        if (empty($cuestionarios)) {
            echo '<p class="sin-cuestionarios">No tienes cuestionarios.</p>';
        } else {
            foreach ($cuestionarios as $cuestionario) {
                echo '<div class="cuestionario">';
                echo '<h2 class="titulo-cuestionario">' . $cuestionario['titulo'] . '</h2>';
                echo '<p class="descripcion-cuestionario">' . $cuestionario['descripcion'] . '</p>';
                echo '<a href="editar-quizz.php?id=' . $cuestionario['quiz_id'] . '" class="boton-cuestionario">Editar cuestionario</a>';
                //echo '<a href="cuestionario.php?id=' . $cuestionario['quiz_id'] . '" class="boton-cuestionario">Ver cuestionario</a>';
                echo '</div>';
            }
        }
        ?>
    </div>
</main>
<?php include 'plantillas/footer.php'; ?>
</body>
</html>
