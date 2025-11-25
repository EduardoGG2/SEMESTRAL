<?php
session_start();
require "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $usuario  = trim($_POST["usuario"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, usuario, password, rol FROM usuarios_login WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $row = $result->fetch_assoc();

        // Comparación simple (luego lo cambiamos a HASH si quieres)
        if ($row["password"] === $password) {

            // Guardar datos en sesión
            $_SESSION["usuario_id"]     = $row["id"];
            $_SESSION["usuario_nombre"] = $row["usuario"];
            $_SESSION["usuario_rol"]    = $row["rol"];

            // Redirección correcta
            header("Location: ../index.html");
            exit;
        }
    }

    // Error de login
    header("Location: ../login.html?error=1");
    exit;
}
