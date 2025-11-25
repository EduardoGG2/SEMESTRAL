<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.html");
    exit;
}

header("Location: index.html");
exit;
