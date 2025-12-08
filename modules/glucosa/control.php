<?php
/**
 * SEGE-C – Control de Glucosa
 * Acceso permitido únicamente para: PACIENTE y ENFERMERÍA
 */

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../login.html");
    exit;
}

// Validación de roles permitidos
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
<title>Control de Glucosa</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body {
        background: #f4f6fb;
        font-family: "Segoe UI", sans-serif;
    }

    /* ENCABEZADO */
    .header-gradient {
        background: linear-gradient(135deg, #ff758c, #ff7eb3);
        padding: 28px;
        border-radius: 18px;
        margin-top: 25px;
        color: #fff;
        box-shadow: 0 8px 18px rgba(0,0,0,0.15);
    }

    /* FORMULARIO */
    .card-form {
        background: #fff;
        padding: 35px;
        border-radius: 20px;
        margin-top: -20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.10);
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 12px;
    }

    /* TABLA MÉDICA VISUAL */
    .estado-card {
        border-radius: 15px;
        padding: 18px;
        background: #ffffff;
        box-shadow: 0 6px 15px rgba(0,0,0,0.08);
        margin-bottom: 18px;
    }

    .estado-title {
        font-weight: bold;
        font-size: 17px;
    }

    .hipo { color: #2980ff; font-weight: bold; }
    .normal { color: #27ae60; font-weight: bold; }
    .pre { color: #f39c12; font-weight: bold; }
    .hiper { color: #e74c3c; font-weight: bold; }

    .table-medica th {
        background: #f0f3f7;
        text-align: center;
    }

    .table-medica td {
        text-align: center;
    }

    /* BOTÓN */
    .btn-main {
        background: linear-gradient(135deg, #ff758c, #ff7eb3);
        border: none;
        color: white;
        padding: 12px;
        border-radius: 12px;
        width: 100%;
        font-size: 17px;
        transition: 0.2s;
    }

    .btn-main:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(255,110,140,0.35);
    }
</style>

</head>
<body>

<div class="container">

    <!-- ENCABEZADO -->
    <div class="header-gradient">
        <h3><i class="fa-solid fa-heart-pulse"></i> Control de Glucosa</h3>
        <p>Ingrese su lectura y reciba una evaluación basada en criterios clínicos.</p>
    </div>

    <!-- FORMULARIO -->
    <div class="card-form">

        <!-- TABLA MÉDICA VISUAL -->
        <div class="estado-card">
            <p class="estado-title"><i class="fa-solid fa-table"></i> Tabla de referencia médica</p>

            <table class="table table-bordered table-medica">
                <tr>
                    <th>Estado</th>
                    <th>Ayunas</th>
                    <th>Antes de comer</th>
                    <th>2h después de comer</th>
                </tr>
                <tr>
                    <td class="hipo">Hipoglucemia</td>
                    <td>&lt; 70</td>
                    <td>&lt; 70</td>
                    <td>&lt; 70</td>
                </tr>
                <tr>
                    <td class="normal">Normal</td>
                    <td>70–99</td>
                    <td>70–130</td>
                    <td>&lt; 140</td>
                </tr>
                <tr>
                    <td class="pre">Prediabetes</td>
                    <td>100–125</td>
                    <td>130–140</td>
                    <td>140–199</td>
                </tr>
                <tr>
                    <td class="hiper">Hiperglucemia</td>
                    <td>≥ 126</td>
                    <td>&gt; 140</td>
                    <td>&gt; 199</td>
                </tr>
            </table>
        </div>

        <form id="formGlucosa">

            <div class="mb-3">
                <label class="form-label fw-semibold"><i class="fa-solid fa-id-card"></i> Cédula</label>
                <input type="text" id="cedula" name="cedula" class="form-control" placeholder="Ej: 8-123-456" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold"><i class="fa-solid fa-droplet"></i> Lectura (mg/dL)</label>
                <input type="number" id="lectura" name="lectura" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold"><i class="fa-solid fa-clock"></i> Momento de la toma</label>
                <select id="momento" name="momento" class="form-select" required>
                    <option value="">Seleccione...</option>
                    <option value="Ayunas">Ayunas</option>
                    <option value="Antes de la comida">Antes de la comida</option>
                    <option value="2 horas después de comer">2 horas después de comer</option>
                </select>
            </div>

            <button class="btn-main">
                <i class="fa-solid fa-magnifying-glass-chart"></i> Evaluar Lectura
            </button>

        </form>

    </div>
</div>

<script>
document.getElementById("formGlucosa").addEventListener("submit", function(e){
    e.preventDefault();

    const cedula = document.getElementById("cedula").value.trim();
    const lectura = parseInt(document.getElementById("lectura").value);
    const momento = document.getElementById("momento").value;

    if (cedula === "" || isNaN(lectura) || momento === "") {
        Swal.fire("Campos incompletos", "Complete todos los campos antes de continuar.", "warning");
        return;
    }

    let estado = "";

    /* CLASIFICACIÓN AUTOMÁTICA SEGÚN TABLA */
    if (lectura < 70) {
        estado = "Hipoglucemia";
    } else if (momento === "Ayunas") {
        if (lectura <= 99) estado = "Normal";
        else if (lectura <= 125) estado = "Prediabetes";
        else estado = "Hiperglucemia";
    } else if (momento === "Antes de la comida") {
        if (lectura <= 130) estado = "Normal";
        else if (lectura <= 140) estado = "Prediabetes";
        else estado = "Hiperglucemia";
    } else if (momento === "2 horas después de comer") {
        if (lectura < 140) estado = "Normal";
        else if (lectura <= 199) estado = "Prediabetes";
        else estado = "Hiperglucemia";
    }

    Swal.fire({
        title: estado,
        text: "Clasificación según criterios médicos.",
        icon: estado === "Normal" ? "success" :
              estado === "Prediabetes" ? "warning" : "error",
        confirmButtonColor: "#ff7aa8"
    });

    // Guardado
    const datos = new FormData();
    datos.append("cedula", cedula);
    datos.append("lectura", lectura);
    datos.append("momento", momento);
    datos.append("estado", estado);

    fetch("../../backend/glucosa/guardar.php", {
        method: "POST",
        body: datos
    });
});
</script>

</body>
</html>
