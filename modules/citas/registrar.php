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
    <title>Registrar Cita</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: #eef1f7;
        }
        .header-gradient {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            padding: 25px;
            color: #fff;
            border-radius: 18px;
            margin-top: 20px;
        }
        .card-form {
            background: #fff;
            border-radius: 18px;
            padding: 35px;
            margin-top: -25px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .form-control, .form-select {
            border-radius: 10px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header-gradient shadow">
        <h3><i class="fa-solid fa-calendar-plus"></i> Registrar Cita</h3>
        <p>Complete la información para agendar una cita médica.</p>
    </div>

    <div class="card card-form">

        <form method="POST" action="../../backend/citas/crear.php">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label"><i class="fa-solid fa-id-card"></i> Cédula del Paciente</label>
                    <input type="text" name="cedula" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label"><i class="fa-solid fa-calendar"></i> Fecha</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label"><i class="fa-solid fa-clock"></i> Hora</label>
                    <input type="time" name="hora" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">

                <div class="col-md-4">
                    <label class="form-label"><i class="fa-solid fa-stethoscope"></i> Especialidad</label>
                    <select name="especialidad" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <option>Medicina General</option>
                        <option>Odontología</option>
                        <option>Pediatría</option>
                        <option>Nutrición</option>
                        <option>Ginecología</option>
                        <option>Oftalmología</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label"><i class="fa-solid fa-envelope"></i> Correo del Paciente</label>
                    <input type="email" name="correo" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label"><i class="fa-solid fa-comment"></i> Motivo</label>
                    <input type="text" name="motivo" class="form-control" placeholder="Dolor, revisión, etc.">
                </div>
            </div>

            <hr>

            <div class="text-end">
                <a href="../../dashboard.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Volver</a>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-save"></i> Guardar Cita</button>
            </div>

        </form>

    </div>
</div>

<script>
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.get('ok') === '1') {
        Swal.fire({
            icon: 'success',
            title: 'Cita registrada',
            text: 'La cita se guardó correctamente.',
            confirmButtonColor: '#11998e',
            timer: 2000,
            timerProgressBar: true
        }).then(() => {
            window.history.replaceState(null, null, window.location.pathname);
        });
    }
</script>

</body>
</html>
