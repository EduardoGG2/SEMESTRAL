<?php
/**
 * SEGE-C – Registro de Pacientes
 * Módulo accesible únicamente para personal autorizado:
 * Roles permitidos: doctor, enfermeria
 */

session_start();

// Validación de sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../login.html");
    exit;
}

// Validación de roles permitidos
$rol = $_SESSION["usuario_rol"];
$rolesPermitidos = ["enfermeria"];

if (!in_array($rol, $rolesPermitidos)) {
    header("Location: ../../errors/403.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registrar Paciente | SEGE-C</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
    body {
        background: #eef2f7;
        font-family: "Segoe UI", sans-serif;
    }

    /* ENCABEZADO */
    .header-gradient {
        background: linear-gradient(135deg, #4e54c8, #8f94fb);
        padding: 30px;
        border-radius: 18px;
        color: white;
        margin-top: 25px;
        box-shadow: 0 8px 22px rgba(0,0,0,0.15);
    }

    /* TARJETA PRINCIPAL */
    .card-form {
        background: white;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.10);
        margin-top: -15px;
        animation: fadeIn 0.4s ease;
    }

    .form-control, .form-select {
        padding: 12px;
        border-radius: 12px;
    }

    .section-title {
        font-weight: bold;
        font-size: 18px;
        color: #4e54c8;
        padding-bottom: 6px;
        border-bottom: 2px solid #e3e6f0;
        margin-bottom: 15px;
    }

    .btn-main {
        background: linear-gradient(135deg, #4e54c8, #8f94fb);
        color: white;
        padding: 12px 25px;
        border-radius: 12px;
        font-size: 16px;
        border: none;
        transition: 0.2s;
    }

    .btn-main:hover {
        box-shadow: 0 6px 14px rgba(78,84,200,0.35);
        transform: translateY(-2px);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</head>

<body>

<div class="container">

    <!-- ENCABEZADO -->
    <div class="header-gradient shadow-sm">
        <h3 class="fw-bold m-0">
            <i class="fa-solid fa-user-plus me-2"></i> Registrar Nuevo Paciente
        </h3>
        <p class="m-0">Ingrese los datos del paciente de forma correcta y completa.</p>
    </div>

    <!-- TARJETA FORMULARIO -->
    <div class="card card-form">

        <form method="POST" action="../../backend/pacientes/crear.php">

            <!-- SECCIÓN 1 – Datos Personales -->
            <div class="section-title">Datos Personales</div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="fa-solid fa-id-card"></i> Nombre Completo
                    </label>
                    <input type="text" class="form-control" name="nombre" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">
                        <i class="fa-solid fa-passport"></i> Cédula
                    </label>
                    <input type="text" class="form-control" name="cedula" required>
                </div>
            </div>

            <!-- SECCIÓN 2 – Contacto -->
            <div class="section-title">Contacto</div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">
                        <i class="fa-solid fa-phone"></i> Teléfono
                    </label>
                    <input type="text" class="form-control" name="telefono">
                </div>

                <div class="col-md-4">
                    <label class="form-label">
                        <i class="fa-solid fa-hashtag"></i> Edad
                    </label>
                    <input type="number" class="form-control" name="edad" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">
                        <i class="fa-solid fa-venus-mars"></i> Género
                    </label>
                    <select class="form-select" name="genero" required>
                        <option value="">Seleccione...</option>
                        <option>Masculino</option>
                        <option>Femenino</option>
                        <option>Otro</option>
                    </select>
                </div>
            </div>

            <!-- SECCIÓN 3 – Información Médica -->
            <div class="section-title">Información Médica</div>

            <div class="row mb-3">

                <div class="col-md-4">
                    <label class="form-label">
                        <i class="fa-solid fa-droplet"></i> Tipo de Sangre
                    </label>
                    <select class="form-select" name="tipo_sangre">
                        <option value="">Seleccione...</option>
                        <option>A+</option><option>A-</option>
                        <option>B+</option><option>B-</option>
                        <option>AB+</option><option>AB-</option>
                        <option>O+</option><option>O-</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">
                        <i class="fa-solid fa-stethoscope"></i> Especialidad Asignada
                    </label>
                    <input type="text" class="form-control" name="especialidad">
                </div>

                <div class="col-md-4">
                    <label class="form-label">
                        <i class="fa-solid fa-envelope"></i> Correo Electrónico
                    </label>
                    <input type="email" class="form-control" name="correo">
                </div>

            </div>

            <div class="text-end mt-4">
                <a href="../../dashboard.php" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Volver
                </a>

                <button type="submit" class="btn-main ms-2">
                    <i class="fa-solid fa-save"></i> Guardar Paciente
                </button>
            </div>

        </form>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.get('ok') === '1') {
        Swal.fire({
            title: "Paciente Registrado",
            text: "El registro se completó correctamente.",
            icon: "success",
            confirmButtonColor: "#4e54c8",
            timer: 2500,
            timerProgressBar: true
        }).then(() => {
            window.history.replaceState(null, null, window.location.pathname);
        });
    }
</script>

</body>
</html>
