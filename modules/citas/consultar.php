<?php
/**
 * SEGE-C – Módulo: Consultar Citas
 * Permite realizar búsquedas por cédula o fecha.
 * Acceso restringido a roles administrativos o médicos.
 */

session_start();

// Validación de sesión obligatoria
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../login.html");
    exit;
}

// Validación de roles permitidos
$rol = $_SESSION["usuario_rol"];
$rolesPermitidos = ["enfermeria"];

if (!in_array($rol, $rolesPermitidos)) {
    header("Location: ../../error/403.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Citas | SEGE-C</title>

    <!-- Librerías base -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { 
            background: #eef2f7; 
            font-family: "Segoe UI", sans-serif;
        }

        /* Encabezado visual del módulo */
        .header-gradient {
            background: linear-gradient(135deg, #ff512f, #dd2476);
            color: white;
            padding: 30px;
            border-radius: 18px;
            margin-top: 25px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        /* Contenedor del formulario */
        .card-form {
            background: white;
            padding: 35px;
            border-radius: 18px;
            margin-top: -20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.12);
            animation: fadeIn 0.4s ease;
        }

        /* Inputs modernos */
        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 12px;
            top: 12px;
            color: #888;
        }

        .input-icon input {
            padding-left: 40px;
            border-radius: 12px;
        }

        .input-icon input:focus {
            box-shadow: 0 0 10px rgba(255,81,47,0.3);
        }

        /* Botón principal */
        .btn-search {
            background: linear-gradient(135deg, #ff512f, #dd2476);
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 12px;
            transition: 0.2s;
        }

        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.18);
        }

        #tablaResultados {
            margin-top: 30px;
        }

        /* Animación suave */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

<div class="container">

    <!-- SECCIÓN DEL TÍTULO -->
    <div class="header-gradient shadow">
        <h3 class="mb-1">
            <i class="fa-solid fa-magnifying-glass"></i> Consultar Citas
        </h3>
        <p class="mb-0">Realice búsquedas por cédula o fecha de atención.</p>
    </div>

    <!-- FORMULARIO DE BÚSQUEDA -->
    <div class="card card-form">

        <div class="row g-4">

            <!-- Campo: Cédula del paciente -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">Cédula del paciente</label>
                <div class="input-icon">
                    <i class="fa-solid fa-id-card"></i>
                    <input type="text" id="buscarCedula" class="form-control" placeholder="Ej: 8-123-456">
                </div>
            </div>

            <!-- Campo: Fecha -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">Fecha de cita</label>
                <div class="input-icon">
                    <i class="fa-solid fa-calendar"></i>
                    <input type="date" id="buscarFecha" class="form-control">
                </div>
            </div>

            <!-- Botón de búsqueda -->
            <div class="col-md-4 d-flex align-items-end">
                <button class="btn-search w-100" id="btnBuscar">
                    <i class="fa-solid fa-search"></i> Buscar
                </button>
            </div>

        </div>

        <!-- Contenedor donde se mostrarán los resultados -->
        <div id="tablaResultados"></div>

    </div>
</div>

<!-- SCRIPT DE BÚSQUEDA -->
<script>
/**
 * Evento principal del botón BUSCAR.
 * Valida que al menos un campo tenga valor antes de enviar.
 */
document.getElementById("btnBuscar").addEventListener("click", function() {

    const cedula = document.getElementById("buscarCedula").value.trim();
    const fecha  = document.getElementById("buscarFecha").value;

    // Validación: al menos un campo debe tener valor
    if (cedula === "" && fecha === "") {
        Swal.fire({
            icon: "warning",
            title: "Ingrese un criterio",
            text: "Debe proporcionar una cédula o una fecha.",
            confirmButtonColor: "#dd2476"
        });
        return;
    }

    // Preparar datos para enviar al backend
    let datos = new FormData();
    datos.append("cedula", cedula);
    datos.append("fecha", fecha);

    // Solicitud al backend
    fetch("../../backend/citas/buscar.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById("tablaResultados").innerHTML = html;
    })
    .catch(() => {
        Swal.fire({
            icon: "error",
            title: "Error inesperado",
            text: "No se pudo procesar la búsqueda.",
            confirmButtonColor: "#ff512f"
        });
    });
});
</script>

</body>
</html>
