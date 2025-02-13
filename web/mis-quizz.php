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

</main>
<?php include 'plantillas/footer.php'; ?>
</body>
</html>
