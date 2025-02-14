<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['rol'] !== 'admin') {
    header('Location: index.php');
    exit;
}

require_once '../db/Usuario.php';
?>

<!doctype html>
<html lang="es">
<?php include '../plantillas/head.php'; ?>
<body class="contenedor-principal">
<?php include '../plantillas/header.php'; ?>
<main class="main">
    <div class="contenedor-lista-usuarios">
        <h1 class="titulo-lista-usuarios">Lista de usuarios</h1>
        <table class="tabla-lista-usuarios">
            <thead>
            <tr>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php
            require_once '../db/Usuario.php';
            $usuariosInstancia = Usuario::getInstance();
            $usuarios = $usuariosInstancia->obtenerUsuarios();
            foreach ($usuarios as $usuario) {
                ?>
                <tr>
                    <td><?php echo $usuario['usuario']; ?></td>
                    <td>
                        <form action="../usuario/usuario-actualizar-rol.php" method="post" class="contenedor-actualizar-rol">
                            <input type="hidden" name="usuario_id" value="<?php echo $usuario['usuario_id']; ?>">
                            <select name="rol" required>
                                <option value="admin" <?php echo ($usuario['rol'] === 'admin') ? 'selected' : ''; ?>>Administrador</option>
                                <option value="estudiante" <?php echo ($usuario['rol'] === 'estudiante') ? 'selected' : ''; ?>>Estudiante</option>
                                <option value="instructor" <?php echo ($usuario['rol'] === 'instructor') ? 'selected' : ''; ?>>Instructor</option>
                            </select>
                            <input type="submit" value="Actualizar rol" class="boton-accion">
                        </form>
                    </td>
                    <td>
                        <a href="../usuario/usuario-eliminar.php?id=<?php echo $usuario['usuario_id']; ?>" class="boton-accion">Eliminar</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</main>
<?php include '../plantillas/footer.php'; ?>
</body>
</html>

