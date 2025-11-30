<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: dashboard.html");
    exit;
}

header("Location: dashboard.html");
?>
