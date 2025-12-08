<?php
session_start();

// Redirigir si NO hay sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.html");
    exit;
}

$nombre = $_SESSION["usuario_nombre"];
$rol    = $_SESSION["usuario_rol"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - SEGE-C</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #f0f2f7;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            height: 100%;
            background: linear-gradient(180deg, #4e54c8, #8f94fb);
            color: white;
            padding-top: 25px;
            box-shadow: 4px 0 12px rgba(0,0,0,0.2);
        }

        .sidebar h3 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: #ffffffcc;
            font-size: 16px;
            margin: 4px 0;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .content {
            margin-left: 260px;
            padding: 30px;
        }

        .card-option {
            background: white;
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            transition: 0.3s;
            cursor: pointer;
        }

        .card-option:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 20px rgba(0,0,0,0.15);
        }

        .card-option i {
            font-size: 42px;
            margin-bottom: 10px;
        }

        footer {
            margin-top: 40px;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">

        <h3><i class="fa-solid fa-hospital-user"></i> SEGE-C</h3>

        <p class="text-center">
            <i class="fa-solid fa-user"></i> 
            <strong><?= $nombre ?></strong><br>
            <small>(<?= $rol ?>)</small>
        </p>

        <hr class="mx-3">

        <!-- Administrar usuarios (SOLO SI NO ES PACIENTE) -->
        <?php if ($rol !== 'paciente'): ?>
            <a href="modules/usuarios/administrar.php">
                <i class="fa-solid fa-users-gear"></i> Administrar Usuarios
            </a>
        <?php endif; ?>

        <!-- OPCIONES PARA TODOS -->
        <a href="modules/citas/registrar.php">
            <i class="fa-solid fa-calendar-plus"></i> Registrar Cita
        </a>

        <a href="modules/glucosa/control.php">
            <i class="fa-solid fa-heart-pulse"></i> Control de Glucosa
        </a>

        <!-- OPCIONES SOLO ADMIN O DOCTOR -->
        <?php if ($rol !== 'paciente'): ?>

            <a href="modules/pacientes/registrar.php">
                <i class="fa-solid fa-user-plus"></i> Registrar Pacientes
            </a>

            <a href="modules/citas/consultar.php">
                <i class="fa-solid fa-search"></i> Consultar Citas
            </a>

        <?php endif; ?>

        <hr class="mx-3">

        <a href="backend/logout.php" onclick="cerrar(); return false;">
            <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
        </a>
    </div>

    <!-- CONTENIDO -->
    <div class="content">

        <h2 class="fw-bold">Panel Principal</h2>
        <p class="text-muted">Bienvenido al sistema clínico SEGE-C</p>

        <div class="row g-4 mt-3">

            <!-- TARJETA Administrar Usuarios SOLO ADMIN/DOCTOR -->
            <?php if ($rol !== 'paciente'): ?>
            <div class="col-md-4">
                <a href="modules/usuarios/administrar.php" class="text-decoration-none text-dark">
                    <div class="card-option">
                        <i class="fa-solid fa-users-gear text-info"></i>
                        <h4 class="fw-bold">Administrar Usuarios</h4>
                        <p>Gestionar usuarios del sistema</p>
                    </div>
                </a>
            </div>
            <?php endif; ?>

            <!-- Registrar Cita (TODOS) -->
            <div class="col-md-4">
                <a href="modules/citas/registrar.php" class="text-decoration-none text-dark">
                    <div class="card-option">
                        <i class="fa-solid fa-calendar-plus text-success"></i>
                        <h4 class="fw-bold">Registrar Cita</h4>
                        <p>Programar atención médica</p>
                    </div>
                </a>
            </div>

            <!-- Control de Glucosa (TODOS) -->
            <div class="col-md-4">
                <a href="modules/glucosa/control.php" class="text-decoration-none text-dark">
                    <div class="card-option">
                        <i class="fa-solid fa-heart-pulse text-danger"></i>
                        <h4 class="fw-bold">Control de Glucosa</h4>
                        <p>Registrar mediciones</p>
                    </div>
                </a>
            </div>

            <!-- SOLO ADMIN/DOCTOR -->
            <?php if ($rol !== 'paciente'): ?>

                <div class="col-md-4">
                    <a href="modules/pacientes/registrar.php" class="text-decoration-none text-dark">
                        <div class="card-option">
                            <i class="fa-solid fa-user-plus text-primary"></i>
                            <h4 class="fw-bold">Registrar Pacientes</h4>
                            <p>Agregar nuevos registros</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="modules/citas/consultar.php" class="text-decoration-none text-dark">
                        <div class="card-option">
                            <i class="fa-solid fa-search text-warning"></i>
                            <h4 class="fw-bold">Consultar Citas</h4>
                            <p>Búsqueda avanzada</p>
                        </div>
                    </a>
                </div>

            <?php endif; ?>

        </div>

        <footer class="mt-5">
            SEGE-C — Sistema de Gestión Clínica<br>
            <strong>Desarrollado por Eduardo Jurado</strong>
        </footer>

    </div>

    <script>
        function cerrar() {
            Swal.fire({
                title: "¿Cerrar sesión?",
                text: "Tu sesión será cerrada.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, salir",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "backend/logout.php";
                }
            });
        }
    </script>

</body>
</html>
