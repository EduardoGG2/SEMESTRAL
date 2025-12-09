<?php
/**
 * SEGE-C – Panel Principal
 * Control de acceso mediante sesión.
 * Este archivo genera la vista principal según el rol del usuario autenticado.

 * Última actualización: 08/12/2025
 */


session_start();

// Bloquea acceso sin login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: error/403.php");
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

    <!-- Frameworks CSS y librerías base del sistema -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #f0f2f7;
        }

        /* Barra lateral de navegación fija */
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

        /* Estilos de los enlaces del menú lateral */
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

        /* Contenedor principal del contenido */
        .content {
            margin-left: 260px;
            padding: 30px;
        }

        /* Tarjetas de opciones del panel */
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

        /* Reloj redondeado ubicado en la parte inferior del sidebar */
        .clock-container {
            position: absolute;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            width: 180px;
            padding: 12px;
            text-align: center;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(6px);
            border-radius: 50px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            box-shadow: 0 0 10px rgba(0,0,0,0.25);
            border: 1px solid rgba(255,255,255,0.27);
        }

        footer {
            margin-top: 40px;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>

<body>

    <!-- Sidebar del sistema -->
    <div class="sidebar">

        <!-- Identidad del sistema -->
        <h3><i class="fa-solid fa-hospital-user"></i> SEGE-C</h3>

        <!-- Información del usuario autenticado -->
        <p class="text-center">
            <i class="fa-solid fa-user"></i> 
            <strong><?= $nombre ?></strong><br>
            <small>(<?= $rol ?>)</small>
        </p>

        <hr class="mx-3">

        <!-- Módulo visible solo para roles administrativos -->
        <?php if ($rol !== 'paciente'): ?>
            <a href="modules/usuarios/administrar.php">
                <i class="fa-solid fa-users-gear"></i> Administrar Usuarios
            </a>
        <?php endif; ?>

        <!-- Opciones generales visibles para todos los usuarios -->
        <a href="modules/citas/registrar.php">
            <i class="fa-solid fa-calendar-plus"></i> Registrar Cita
        </a>

        <a href="modules/glucosa/control.php">
            <i class="fa-solid fa-heart-pulse"></i> Control de Glucosa
        </a>

        <!-- Funcionalidades exclusivas para personal médico/administrativo -->
        <?php if ($rol !== 'paciente'): ?>

            <a href="modules/pacientes/registrar.php">
                <i class="fa-solid fa-user-plus"></i> Registrar Pacientes
            </a>

            <a href="modules/citas/consultar.php">
                <i class="fa-solid fa-search"></i> Consultar Citas
            </a>

        <?php endif; ?>

        <hr class="mx-3">

        <!-- Cierre de sesión -->
        <a href="backend/logout.php" onclick="cerrar(); return false;">
            <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
        </a>

        <!-- Reloj redondeado (parte inferior del sidebar) -->
        <div class="clock-container">
            <span id="clock">00:00:00</span>
        </div>

    </div>

    <!-- CONTENIDO PRINCIPAL -->
 <div class="content">

    <h2 class="fw-bold mb-1">Panel Principal</h2>
    <p class="text-muted mb-4">Bienvenido al sistema clínico SEGE-C</p>

    <div class="row g-4">

        <!-- Administrar usuarios (solo roles válidos) -->
       <?php if ($rol !== 'paciente'): ?>
        <div class="col-md-4">
            <a href="modules/usuarios/administrar.php" class="text-decoration-none text-dark">
                <div class="card-option p-4 text-center">

                    <i class="fa-solid fa-users-gear" 
                       style="font-size:48px; color:#00c4ff;"></i>

                    <h4 class="fw-bold mt-3">Administrar Usuarios</h4>
                    <p class="text-muted">Gestión completa del personal</p>
                </div>
            </a>
        </div>
         <?php endif; ?>
        

        <!-- Registrar cita -->
        <div class="col-md-4">
            <a href="modules/citas/registrar.php" class="text-decoration-none text-dark">
                <div class="card-option p-4 text-center">

                    <i class="fa-solid fa-calendar-plus"
                       style="font-size:48px; color:#1dd15d;"></i>

                    <h4 class="fw-bold mt-3">Registrar Cita</h4>
                    <p class="text-muted">Programación de citas clínicas</p>
                </div>
            </a>
        </div>

        <!-- Control de glucosa -->
        <div class="col-md-4">
            <a href="modules/glucosa/control.php" class="text-decoration-none text-dark">
                <div class="card-option p-4 text-center">

                    <i class="fa-solid fa-heart-pulse"
                       style="font-size:48px; color:#ff4d4d;"></i>

                    <h4 class="fw-bold mt-3">Control de Glucosa</h4>
                    <p class="text-muted">Registrar mediciones del paciente</p>
                </div>
            </a>
        </div>

        
        <?php if ($rol !== 'paciente'): ?>

        <div class="col-md-4">
            <a href="modules/pacientes/registrar.php" class="text-decoration-none text-dark">
                <div class="card-option p-4 text-center">

                    <i class="fa-solid fa-user-plus"
                       style="font-size:48px; color:#007bff;"></i>

                    <h4 class="fw-bold mt-3">Registrar Pacientes</h4>
                    <p class="text-muted">Añadir nuevos registros clínicos</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="modules/citas/consultar.php" class="text-decoration-none text-dark">
                <div class="card-option p-4 text-center">

                    <i class="fa-solid fa-search"
                       style="font-size:48px; color:#f0a500;"></i>

                    <h4 class="fw-bold mt-3">Consultar Citas</h4>
                    <p class="text-muted">Herramienta de búsqueda avanzada</p>
                </div>
            </a>
        </div>

        <?php endif; ?>

    </div>
</div>


        <footer class="mt-5">
            SEGE-C — Sistema de Gestión Clínica<br>
            
        </footer>

    </div>

    <!-- Scripts de funcionalidad general -->
    <script>
        /**
         * Alerta de confirmación para cierre de sesión.
         */
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

        /**
         * Reloj digital del sistema colocado en el sidebar.
         * Actualiza cada segundo.
         */
        function actualizarReloj() {
            const clock = document.getElementById("clock");
            const now = new Date();

            const h = String(now.getHours()).padStart(2, "0");
            const m = String(now.getMinutes()).padStart(2, "0");
            const s = String(now.getSeconds()).padStart(2, "0");

            clock.textContent = `${h}:${m}:${s}`;
        }

        setInterval(actualizarReloj, 1000);
        actualizarReloj();
    </script>

</body>
</html>
