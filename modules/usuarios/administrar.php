<?php
/**
 * SEGE-C – Administración de Usuarios
 * Acceso permitido únicamente a roles con privilegios administrativos.
 *
 * Regla:
 * - Pacientes únicamente pueden ver su perfil básico.
 * - Roles permitidos para ver la tabla completa: admin, enfermeria
 */

session_start();
require "../../backend/config.php";

// Validar sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../login.html");
    exit;
}

// Datos de sesión
$usuarioSesion = $_SESSION["usuario_nombre"];
$rol = $_SESSION["usuario_rol"];

/* Si el rol es PACIENTE → solo mostrar su propio perfil */
if ($rol === "paciente") {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mi Perfil</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body class="p-4 bg-light">

        <div class="container mt-4">

            <div class="card shadow p-4">
                <h3 class="fw-bold"><i class="fa-solid fa-user"></i> Mi Perfil</h3>
                <p><strong>Usuario:</strong> <?= htmlspecialchars($usuarioSesion) ?></p>
                <p><strong>Rol:</strong> Paciente</p>

                <a href="../../dashboard.php" class="btn btn-primary mt-2">
                    <i class="fa-solid fa-arrow-left"></i> Volver al Panel
                </a>
            </div>

        </div>

    </body>
    </html>
    <?php
    exit;
}

/* Validación de roles permitidos (admin | enfermería) */
$rolesPermitidos = ["admin", "enfermeria"];

if (!in_array($rol, $rolesPermitidos)) {
    header("Location: ../../errors/403.php");
    exit;
}

/* Obtener todos los usuarios */
$result = $conn->query("SELECT id, usuario, rol FROM usuarios");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Usuarios | SEGE-C</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .header-box {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            padding: 25px;
            color: white;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .table-container {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }
    </style>
</head>

<body class="p-4">

<div class="container">

    <!-- ENCABEZADO -->
    <div class="header-box shadow">
        <h2 class="fw-bold">
            <i class="fa-solid fa-users-gear"></i> Administrar Usuarios
        </h2>
        <p class="mb-0">Gestione los usuarios registrados en el sistema.</p>
    </div>

    <!-- TABLA DE USUARIOS -->
    <div class="table-container shadow">

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                </tr>
            </thead>

            <tbody class="text-center">
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row["id"] ?></td>
                    <td><?= htmlspecialchars($row["usuario"]) ?></td>
                    <td>
                        <span class="badge 
                            <?= $row['rol'] === 'admin' ? 'bg-danger' : 
                               ($row['rol'] === 'enfermeria' ? 'bg-warning text-dark' : 'bg-primary') ?>">
                            <?= ucfirst($row["rol"]) ?>
                        </span>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <a href="../../dashboard.php" class="btn btn-secondary mt-3">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>

    </div>

</div>

</body>
</html>
