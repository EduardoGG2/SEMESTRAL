<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Paciente</title>

    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet">
    <link 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" 
        rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .card-form {
            margin-top: 40px;
            border-radius: 15px;
            padding: 35px;
        }

        .header-gradient {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            color: white;
            padding: 20px 30px;
            border-radius: 12px 12px 0 0;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- CABECERA -->
    <div class="header-gradient shadow-sm mb-4">
        <h3 class="fw-bold">
            <i class="fa-solid fa-user-plus me-2"></i>
            Registrar Nuevo Paciente
        </h3>
        <p class="m-0">Complete los datos del paciente</p>
    </div>

    <!-- TARJETA -->
    <div class="card shadow card-form">

       <form method="POST" action="../../backend/pacientes/crear.php">

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
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
            </select>
        </div>
    </div>

    <div class="row mb-3">

        <div class="col-md-4">
            <label class="form-label">
                <i class="fa-solid fa-droplet"></i> Tipo de Sangre
            </label>
            <select class="form-select" name="tipo_sangre">
                <option value="">Seleccione...</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">
                <i class="fa-solid fa-stethoscope"></i> Especialidad
            </label>
            <input type="text" class="form-control" name="especialidad">
        </div>

        <div class="col-md-4">
            <label class="form-label">
                <i class="fa-solid fa-envelope"></i> Correo
            </label>
            <input type="email" class="form-control" name="correo">
        </div>

    </div>

    <hr>

    <div class="text-end">
        <a href="../../dashboard.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>

        <button type="submit" class="btn btn-primary">
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
            title: 'Paciente Registrado',
            text: 'El registro se completó exitosamente.',
            icon: 'success',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#4e54c8',
            timer: 2500,
            timerProgressBar: true
        }).then(() => {
            // Limpia el parámetro ?ok=1 de la URL
            window.history.replaceState(null, null, window.location.pathname);
        });
    }
</script>


</body>
</html>
