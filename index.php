<?php
session_start();

// Si NO hay sesión → login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: publics/js/login.html");
    exit;
}

// Si hay sesión → dashboard
header("Location: dashboard.html");
exit;
?>
