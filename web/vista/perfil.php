<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once '../db/Quizz.php';
require_once '../db/QuizResultado.php';

?>

<!doctype html>
<html lang="es">
<?php include '../plantillas/head.php'; ?>
<body class="contenedor-principal">
<?php include '../plantillas/header.php'; ?>
<main class="main">
    <div class="inicio-perfil">
        <p>Bienvenido, <?php echo $_SESSION['usuario']; ?></p>
        <?php
        if ($_SESSION['rol'] === 'admin' || $_SESSION['rol'] === 'instructor') {
            echo '<a href="agregar-quizz.php">Agregar cuestionario</a>';
        }
        ?>
    </div>
    <div class="contenedor-cuestionarios">
        <h1 class="titulo-mis-cuestionarios">Mis cuestionarios</h1>
        <?php
        $quizz = Quizz::getInstance();
        $quizzResultado = QuizResultado::getInstance();
        $usuario_id = $_SESSION['id'];
        $cuestionarios = $quizz->obtenerQuizzesPorUsuario($usuario_id);
        $cuestionariosRealizados = $quizzResultado->obtenerResultadosPorUsuario($usuario_id);
        $informacionQuizz = $quizz->obtenerTodosLosQuizzes();


        if ($_SESSION['rol'] === 'admin' || $_SESSION['rol'] === 'instructor') {
            if (empty($cuestionarios)) {
                echo '<p class="sin-cuestionarios">No tienes cuestionarios.</p>';
            } else {
                foreach ($cuestionarios as $cuestionario) {
                    echo '<div class="cuestionario">';
                    echo '<h2 class="titulo-cuestionario">' . $cuestionario['titulo'] . '</h2>';
                    echo '<p class="descripcion-cuestionario">' . $cuestionario['descripcion'] . '</p>';
                    echo '<a href="editar-quizz.php?id=' . $cuestionario['quiz_id'] . '" class="boton-cuestionario">Editar cuestionario</a>';
                    echo '<a href="ver-quizz.php?id=' . $cuestionario['quiz_id'] . '" class="boton-cuestionario">Ver cuestionario</a>';
                    echo '<a href="../quizz/quizz-borrar.php?id=' . $cuestionario['quiz_id'] . '" class="boton-cuestionario">Eliminar cuestionario</a>';
                    echo '</div>';
                }
            }
        }

        if ($_SESSION['rol'] === 'admin' || $_SESSION['rol'] === 'estudiante') {
            if (empty($cuestionariosRealizados)) {
                echo '<p class="sin-cuestionarios">No has realizado cuestionarios.</p>';
            } else {
                foreach ($cuestionariosRealizados as $cuestionarioRealizado) {
                    foreach ($informacionQuizz as $infoQuizz) {
                        if ($cuestionarioRealizado['quiz_id'] === $infoQuizz['quiz_id']) {
                            echo '<div class="cuestionario">';
                            echo '<h2 class="titulo-cuestionario">' . $infoQuizz['titulo'] . '</h2>';
                            echo '<p class="descripcion-cuestionario">' . $infoQuizz['descripcion'] . '</p>';
                            echo '<p class="puntuacion-cuestionario">Puntuación: ' . $cuestionarioRealizado['puntuacion'] . '</p>';
                            echo '<a href="ver-quizz.php?id=' . $infoQuizz['quiz_id'] . '" class="boton-cuestionario">Ver cuestionario</a>';
                            echo '</div>';
                        }
                    }
                }
            }
        }
        ?>

    </div>
</main>
<?php include '../plantillas/footer.php'; ?>
</body>
</html>
