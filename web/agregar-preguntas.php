<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}
?>

<!doctype html>
<html lang="es">
<?php include 'plantillas/head.php'; ?>
<body class="contenedor-principal">
<?php include 'plantillas/header.php'; ?>
<main class="main">
    <div class="contenedor-formulario-preguntas">
        <h1 class="titulo-formulario-preguntas">Agregar preguntas</h1>
        <form action="quizz/pregunta-crear.php" method="post" class="formulario-preguntas">
            <input type="hidden" name="quiz_id" value="<?php echo $_GET['quiz_id']; ?>">

            <?php for ($i = 1; $i <= $_GET['numero_preguntas']; $i++): ?>
                <div class="input-container">
                    <input type="text" name="pregunta<?php echo $i; ?>" id="pregunta<?php echo $i; ?>" class="input-formulario-preguntas" required placeholder=" ">
                    <label for="pregunta<?php echo $i; ?>" class="label-formulario-preguntas">Pregunta <?php echo $i; ?></label>
                </div>

                <!-- Opciones de respuesta -->
                <?php foreach (['A', 'B', 'C', 'D'] as $opcion): ?>
                    <div class="input-container">
                        <input type="text" name="opcion_<?php echo $opcion . '_' . $i; ?>" required placeholder=" ">
                        <label>Opción <?php echo $opcion; ?></label>
                    </div>
                <?php endforeach; ?>

                <!-- Selección de la respuesta correcta -->
                <div class="input-container">
                    <label>Respuesta correcta:</label>
                    <select name="correcta<?php echo $i; ?>" required>
                        <option value="A">Opción A</option>
                        <option value="B">Opción B</option>
                        <option value="C">Opción C</option>
                        <option value="D">Opción D</option>
                    </select>
                </div>
                <hr>
            <?php endfor; ?>

            <input type="submit" value="Crear preguntas" class="boton-formulario-preguntas">
        </form>

        <?php if (isset($_GET["error-creacion"])): ?>
            <span class="error-creacion"><?php echo $_GET["error-creacion"]; ?></span>
        <?php endif; ?>
    </div>
</main>
<?php include 'plantillas/footer.php'; ?>
</body>
</html>
