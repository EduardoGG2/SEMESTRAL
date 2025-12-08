<?php
session_start();
require "../backend/config.php"; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Frase secreta para el hash
    $secreto = "Odio PHP viva C#";

    // Datos enviados del formulario
    $usuarioIngresado  = trim($_POST["usuario"]);
    $passwordIngresado = trim($_POST["password"]);

    // Generar hash del usuario con clave secreta
    $usuarioHash = hash_hmac("sha256", $usuarioIngresado, $secreto);

    // Buscar el usuario por el hash
    $stmt = $conn->prepare("SELECT id, usuario, password, rol FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuarioHash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $row = $result->fetch_assoc();

        // Verificar contraseña usando la frase secreta
        if (password_verify($passwordIngresado . $secreto, $row["password"])) {

            // Sesiones
            $_SESSION["usuario_id"]     = $row["id"];
            $_SESSION["usuario_nombre"] = $usuarioIngresado; 
            $_SESSION["usuario_rol"]    = $row["rol"];

            header("Location: ../dashboard.php");
            exit;
        }
    }

    // Si falla algo:
    header("Location: ../login.html?error=1");
    exit;
}
?>
