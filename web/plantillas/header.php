<header class="header">
    <nav class="navbar">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="index.php" class="nav-link">Inicio</a>
            </li>
            <?php
            // Comprobar si el usuario está logueado
            if (isset($_SESSION['usuario'])) {
                // Mostrar opciones para usuarios logueados
                echo '<li class="nav-item">
                        <a href="perfil.php" class="nav-link">Perfil</a>
                      </li><li class="nav-item">
                        <a href="usuario/usuario-logout.php" class="nav-link">Cerrar sesión</a>
                      </li>';
            } else {
                // Mostrar opciones para usuarios no logueados
                echo '<li class="nav-item">
                        <a href="login.php" class="nav-link">Iniciar sesión</a>
                      </li>
                      <li class="nav-item">
                        <a href="registro.php" class="nav-link">Registrarse</a>
                      </li>';
            }
            ?>
        </ul>
    </nav>
</header>
