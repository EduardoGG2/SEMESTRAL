<?php
session_start();
require "../backend/config.php";

$secreto = "Odio PHP viva C#";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $usuarioIngresado  = trim($_POST["usuario"]);
    $passwordIngresado = trim($_POST["password"]);


    $usuarioHash = hash_hmac("sha256", $usuarioIngresado, $secreto);

    $stmt = $conn->prepare("SELECT id, usuario, password, rol FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuarioHash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $row = $result->fetch_assoc();

        // Verificación correcta: contraseña + secreto
        if (password_verify($passwordIngresado . $secreto, $row["password"])) {

            // Guardar datos en sesión
            $_SESSION["usuario_id"]     = $row["id"];
            $_SESSION["usuario_nombre"] = $usuarioIngresado; 
            $_SESSION["usuario_rol"]    = $row["rol"];

            header("Location: ../dashboard.php");
            exit;
        }
    }

    // Si algo falla → mensaje
    header("Location: ../login.html?error=1"); 
    exit;
}
?>
