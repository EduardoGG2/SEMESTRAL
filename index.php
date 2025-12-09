<?php
session_start();

// Si NO hay sesión → volver al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

// Si hay sesión → dashboard
header("Location: dashboard.php");
exit;
?>
