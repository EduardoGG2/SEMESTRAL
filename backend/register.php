<?php
require "../backend/config.php";

$secreto = "Odio PHP viva C#";

$usuario  = trim($_POST["usuario"]);
$password = trim($_POST["password"]);
$rol      = trim($_POST["rol"]);

$usuarioHash   = hash_hmac("sha256", $usuario, $secreto);
$passwordHash  = password_hash($password . $secreto, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO usuarios (usuario, password, rol) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $usuarioHash, $passwordHash, $rol);
$stmt->execute();

header("Location: ../login.html?registrado=1");
exit;
?>
