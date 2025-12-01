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
    <title>Control de Glucosa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { background: #eef1f7; }
        .header-gradient {
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            padding: 25px;
            border-radius: 18px;
            margin-top: 20px;
            color: #333;
        }
        .card-form {
            background: #fff;
            padding: 35px;
            border-radius: 18px;
            margin-top: -25px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="header-gradient shadow">
        <h3><i class="fa-solid fa-heart-pulse"></i> Control de Glucosa</h3>
        <p>Registre su lectura y reciba una evaluación inmediata.</p>
    </div>

    <div class="card card-form">

        <form id="formGlucosa">

            <div class="mb-3">
                <label class="form-label"><i class="fa-solid fa-id-card"></i> Cédula del Paciente</label>
                <input type="text" name="cedula" id="cedula" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label"><i class="fa-solid fa-droplet"></i> Lectura (mg/dL)</label>
                <input type="number" name="lectura" id="lectura" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label"><i class="fa-solid fa-clock"></i> Momento de la Toma</label>
                <select name="momento" id="momento" class="form-select" required>
                    <option value="">Seleccione...</option>
                    <option value="Ayunas">Ayunas</option>
                    <option value="Antes de la comida">Antes de la comida</option>
                    <option value="2 horas después de la comida">2 horas después de comer</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fa-solid fa-save"></i> Guardar y Evaluar
            </button>

        </form>

    </div>
</div>

<script>
document.getElementById("formGlucosa").addEventListener("submit", function(e){
    e.preventDefault();

    let lectura  = parseInt(document.getElementById("lectura").value);
    let momento  = document.getElementById("momento").value;
    let cedula   = document.getElementById("cedula").value;

    // Evaluación médica según la tabla dada
    let estado = "";

    if (lectura < 70) {
        estado = "Hipoglucemia";
    } 
    else {
        if (momento === "Ayunas") {

            if (lectura >= 70 && lectura <= 99) estado = "Normal";
            else if (lectura >= 100 && lectura <= 125) estado = "Prediabetes";
            else if (lectura >= 126) estado = "Hiperglucemia";

        } else if (momento === "Antes de la comida") {

            if (lectura >= 70 && lectura <= 130) estado = "Normal";
            else if (lectura > 130 && lectura <= 140) estado = "Prediabetes";
            else if (lectura > 140) estado = "Hiperglucemia";

        } else if (momento === "2 horas después de comer") {

            if (lectura < 140) estado = "Normal";
            else if (lectura >= 140 && lectura <= 199) estado = "Prediabetes";
            else if (lectura > 199) estado = "Hiperglucemia";

        }
    }

    // Mostrar alerta
    Swal.fire({
        title: estado,
        text: "Clasificación según la tabla médica.",
        icon: estado === "Normal" ? "success" :
              estado === "Prediabetes" ? "warning" : "error",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#4e54c8"
    });

    // Guardar en BD
    let datos = new FormData();
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
