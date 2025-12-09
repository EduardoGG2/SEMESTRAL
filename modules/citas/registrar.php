<?php
/**
 * SEGE-C – Registrar Cita Médica
 * Este módulo permite a usuarios autorizados crear una nueva cita clínica.
 * 
 * Requisitos:
 * - El usuario debe tener una sesión activa.
 * - Solo pueden acceder los roles "paciente" y "enfermeria".
 * 
 * Seguridad:
 * - Cualquier intento de acceso manual mediante URL queda bloqueado.
 * - Los usuarios sin permisos son enviados a la página de error 403.
 */

session_start();

/* Validación de autenticación */
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../login.html");
    exit;
}

/* Validación por roles permitidos */
$rol = $_SESSION["usuario_rol"];
$rolesPermitidos = ["paciente", "enfermeria"];

if (!in_array($rol, $rolesPermitidos)) {
    header("Location: ../../errors/403.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Cita | SEGE-C</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- EmailJS v4 -->
    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

    <style>
        body {
            background: #eaf0f7;
            font-family: "Segoe UI", sans-serif;
        }

        .header-box {
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            padding: 35px;
            border-radius: 20px;
            margin-top: 25px;
            color: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .header-icon {
            font-size: 45px;
            margin-right: 10px;
        }

        .card-form {
            background: #ffffff;
            border-radius: 20px;
            padding: 35px;
            margin-top: -20px;
            box-shadow: 0 12px 25px rgba(0,0,0,0.08);
            animation: fadeIn 0.45s ease;
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px;
        }

        .divider {
            height: 1px;
            background: #d7dce3;
            margin: 25px 0;
        }

        .btn-main {
            background: linear-gradient(90deg, #3a7bd5, #00d2ff);
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 12px;
            color: white;
            transition: 0.2s;
        }

        .btn-main:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .btn-secondary {
            border-radius: 12px;
            padding: 12px 25px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

<script>
emailjs.init({ publicKey: "JCvNL-HXXJxS54-QB" });

function enviarCorreo() {
    const form = document.getElementById("emailForm");
    const btn = document.getElementById("emailBtn");

    btn.value = "Enviando…";

    emailjs.sendForm("service_0hqqh0m", "template_ssw05pu", form)
    .then(() => {
        btn.value = "Enviar";

        Swal.fire({
            title: "Cita registrada",
            html: `
                <div style="background:#e6fff2; padding:12px; border-radius:10px;">
                    <b>ID Cita:</b> ${form.cita_id.value}<br>
                    <b>Fecha:</b> ${form.fecha_cita.value}<br>
                    <b>Especialidad:</b> ${form.especialidad_cita.value}<br>
                    <b>Correo:</b> ${form.email.value}
                </div>
            `,
            icon: "success",
            confirmButtonColor: "#3a7bd5"
        });

    })
    .catch(() => {
        btn.value = "Enviar";
        Swal.fire({
            title: "Cita guardada sin correo",
            text: "Ocurrió un error al enviar la notificación.",
            icon: "warning",
            confirmButtonColor: "#ff9f43"
        });
    });
}
</script>
</head>

<body>
<div class="container">

    <div class="header-box">
        <h2>
            <i class="fa-solid fa-calendar-plus header-icon"></i>
            Registrar Cita Médica
        </h2>
        <p>Llene los siguientes campos para programar una nueva consulta.</p>
    </div>

    <div class="card-form">

        <form method="POST" action="../../backend/citas/crear.php">

            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Cédula del paciente</label>
                    <input type="text" name="cedula" class="form-control" placeholder="Ej: 8-123-456" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Fecha</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Hora</label>
                    <input type="time" name="hora" class="form-control" required>
                </div>
            </div>

            <div class="row mb-4">

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Especialidad</label>
                    <select name="especialidad" class="form-select" required>
                        <option value="">Seleccione una opción…</option>
                        <option>Medicina General</option>
                        <option>Odontología</option>
                        <option>Pediatría</option>
                        <option>Nutrición</option>
                        <option>Ginecología</option>
                        <option>Oftalmología</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Correo del paciente</label>
                    <input type="email" name="correo" class="form-control" placeholder="correo@dominio.com">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Motivo de consulta</label>
                    <input type="text" name="motivo" class="form-control" placeholder="Ej: Dolor abdominal">
                </div>
            </div>

            <div class="divider"></div>

            <div class="text-end">
                <a href="../../dashboard.php" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-main">Guardar Cita</button>
            </div>

        </form>

    </div>
</div>

<form id="emailForm" style="display:none;">
    <input type="text" name="cita_id">
    <input type="text" name="fecha_cita">
    <input type="text" name="especialidad_cita">
    <input type="email" name="email">
    <input id="emailBtn" type="submit" value="Enviar">
</form>

<script>
const p = new URLSearchParams(window.location.search);

if (p.get("ok") === "1") {
    const form = document.getElementById("emailForm");

    form.cita_id.value = p.get("id");
    form.fecha_cita.value = p.get("fecha");
    form.especialidad_cita.value = p.get("especialidad");
    form.email.value = p.get("correo");

    Swal.fire({
        title: "Procesando…",
        text: "Enviando confirmación al paciente.",
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
            enviarCorreo();
        }
    });

    window.history.replaceState(null, null, window.location.pathname);
}
</script>

</body>
</html>
