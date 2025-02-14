<?php
session_start();
session_destroy();
if (isset($_SESSION["usuario"])) {
    header("Location: ../vista/index.php");
    exit;
}