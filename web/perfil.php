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
    <p>Bienvenido, <?php echo $_SESSION['usuario']; ?></p>
    <a href="agregar-quizz.php">Agregar cuestionario</a>
</main>
<?php include 'plantillas/footer.php'; ?>
</body>
</html>
