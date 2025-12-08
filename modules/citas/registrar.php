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

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- EmailJS BROWSER SDK v4 CORRECTO -->
    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

    <style>
        body { background: #eef1f7; }
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
        .form-control, .form-select { border-radius: 10px; }
    </style>

    <script>
    // 💡 Inicializar EmailJS — versión correcta, sin window.onload
    emailjs.init({
        publicKey: "JCvNL-HXXJxS54-QB"
    });
    console.log("EmailJS iniciado correctamente");

    // 💡 Función que envía el correo usando sendForm()
    function enviarCorreo() {
        const form = document.getElementById("emailForm");
        const btn = document.getElementById("emailBtn");

        btn.value = "Enviando…";

        emailjs.sendForm("service_0hqqh0m", "template_ssw05pu", form)
        .then(() => {
            btn.value = "Enviar";
            Swal.fire({
                title: "🎉 ¡Cita Registrada y Correo Enviado!",
                html: `
                    <div style="background:#e6fff2; padding:12px; border-radius:10px;">
                        <b>ID Cita:</b> ${form.cita_id.value}<br>
                        <b>Fecha:</b> ${form.fecha_cita.value}<br>
                        <b>Especialidad:</b> ${form.especialidad_cita.value}<br>
                        <b>Correo:</b> ${form.email.value}
                    </div>
                `,
                icon: "success",
                confirmButtonColor: "#11998e"
            });
        })
        .catch((err) => {
            console.error("ERROR EN EMAILJS:", err);
            btn.value = "Enviar";
            Swal.fire({
                title: "⚠️ Cita registrada",
                text: "Pero ocurrió un error al enviar el correo.",
                icon: "warning",
                confirmButtonColor: "#ff9f43"
            });
        });
    }
    </script>

</head>

<body>

<div class="container">

    <div class="header-gradient shadow">
        <h3><i class="fa-solid fa-calendar-plus"></i> Registrar Cita</h3>
        <p>Complete la información para agendar una cita médica.</p>
    </div>

    <div class="card card-form">

        <!-- FORM ORIGINAL que guarda la cita -->
        <form method="POST" action="../../backend/citas/crear.php">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Cédula</label>
                    <input type="text" name="cedula" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Hora</label>
                    <input type="time" name="hora" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">

                <div class="col-md-4">
                    <label class="form-label">Especialidad</label>
                    <select name="especialidad" class="form-select" required>
                        <option value="">Seleccione…</option>
                        <option>Medicina General</option>
                        <option>Odontología</option>
                        <option>Pediatría</option>
                        <option>Nutrición</option>
                        <option>Ginecología</option>
                        <option>Oftalmología</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Correo</label>
                    <input type="email" name="correo" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Motivo</label>
                    <input type="text" name="motivo" class="form-control">
                </div>
            </div>

            <hr>

            <div class="text-end">
                <a href="../../dashboard.php" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-success">Guardar Cita</button>
            </div>

        </form>

    </div>
</div>

<!-- FORMULARIO OCULTO PARA EMAILJS -->
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
