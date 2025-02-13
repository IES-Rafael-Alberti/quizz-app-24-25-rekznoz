<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
require_once '../db/Pregunta.php';

$quiz_id = $_GET['id'];
$preguntasInstancia = Pregunta::getInstance();
$preguntas = $preguntasInstancia->obtenerPreguntasPorQuiz($quiz_id);
?>

<!doctype html>
<html lang="es">
<?php include '../plantillas/head.php'; ?>
<body class="contenedor-principal">
<?php include '../plantillas/header.php'; ?>
<main class="main">
    <div class="contenedor-formulario-preguntas">
        <h1 class="titulo-formulario-preguntas">Editar preguntas</h1>
        <form action="../quizz/pregunta-editar.php" method="post" class="formulario-preguntas">
            <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">

            <?php foreach ($preguntas as $pregunta): ?>
                <input type="hidden" name="pregunta_id[]" value="<?php echo $pregunta['pregunta_id']; ?>">

                <div class="input-container">
                    <input type="text" name="pregunta_texto[]" id="pregunta<?php echo $pregunta['pregunta_id']; ?>"
                           class="input-formulario-preguntas" required placeholder=" "
                           value="<?php echo htmlspecialchars($pregunta['pregunta_texto']); ?>">
                    <label for="pregunta<?php echo $pregunta['pregunta_id']; ?>" class="label-formulario-preguntas">
                        Pregunta
                    </label>
                </div>

                <!-- Opciones de respuesta -->
                <?php foreach (['A', 'B', 'C', 'D'] as $opcion): ?>
                    <div class="input-container">
                        <input type="text" name="opcion_<?php echo strtolower($opcion); ?>[]" required placeholder=" "
                               value="<?php echo htmlspecialchars($pregunta['opcion_' . strtolower($opcion)]); ?>">
                        <label>Opción <?php echo $opcion; ?></label>
                    </div>
                <?php endforeach; ?>

                <!-- Selección de la respuesta correcta -->
                <div class="input-container">
                    <label>Respuesta correcta:</label>
                    <select name="opcion_correcta[]" required>
                        <option value="A" <?php echo ($pregunta['opcion_correcta'] == 'A') ? 'selected' : ''; ?>>Opción A</option>
                        <option value="B" <?php echo ($pregunta['opcion_correcta'] == 'B') ? 'selected' : ''; ?>>Opción B</option>
                        <option value="C" <?php echo ($pregunta['opcion_correcta'] == 'C') ? 'selected' : ''; ?>>Opción C</option>
                        <option value="D" <?php echo ($pregunta['opcion_correcta'] == 'D') ? 'selected' : ''; ?>>Opción D</option>
                    </select>
                </div>
                <hr>
            <?php endforeach; ?>

            <input type="submit" value="Guardar cambios" class="boton-formulario-preguntas">
        </form>

        <?php if (isset($_GET["error-edicion"])): ?>
            <span class="error-creacion"><?php echo $_GET["error-edicion"]; ?></span>
        <?php endif; ?>
    </div>
</main>
<?php include '../plantillas/footer.php'; ?>
</body>
</html>
