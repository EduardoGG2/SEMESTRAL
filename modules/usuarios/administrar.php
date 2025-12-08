<?php
session_start();
require "../../backend/config.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../login.html");
    exit;
}

$secreto = "Odio PHP viva C#";
$usuarioSesion = $_SESSION["usuario_nombre"];
$rol = $_SESSION["usuario_rol"];

// SI ES PACIENTE → solo mostrar su perfil
if ($rol === "paciente") {

    echo "
    <h2>Mi Perfil</h2>
    <p><strong>Usuario:</strong> $usuarioSesion</p>
    <p><strong>Rol:</strong> paciente</p>
    <a href='../../dashboard.php'>Volver</a>
    ";
    exit;
}

// SI ES ADMIN → mostrar todos
$result = $conn->query("SELECT id, usuario, rol FROM usuarios");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administrar Usuarios</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

    <h2 class="fw-bold mb-3"><i class="fa-solid fa-users-gear"></i> Administrar Usuarios</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Usuario (Hash)</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row["id"] ?></td>
                <td><?= $row["usuario"] ?></td>
                <td><?= $row["rol"] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="../../dashboard.php" class="btn btn-secondary">Volver</a>

</body>
</html>
