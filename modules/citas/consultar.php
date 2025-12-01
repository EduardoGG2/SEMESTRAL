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
    <title>Consultar Citas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { background: #eef1f7; }
        .header-gradient {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: white;
            padding: 25px;
            border-radius: 18px;
            margin-top: 20px;
        }
        .card-form {
            background: #fff;
            padding: 30px;
            border-radius: 18px;
            margin-top: -25px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.1);
        }
        .form-control {
            border-radius: 10px;
        }
        #tablaResultados {
            margin-top: 25px;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header-gradient shadow">
        <h3><i class="fa-solid fa-search"></i> Consultar Citas</h3>
        <p>Busque citas por cédula o por fecha.</p>
    </div>

    <!-- FORMULARIO -->
    <div class="card card-form">

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label"><i class="fa-solid fa-id-card"></i> Cédula</label>
                <input type="text" id="buscarCedula" class="form-control" placeholder="Ej: 8-123-456">
            </div>

            <div class="col-md-4">
                <label class="form-label"><i class="fa-solid fa-calendar"></i> Fecha</label>
                <input type="date" id="buscarFecha" class="form-control">
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-danger w-100" id="btnBuscar">
                    <i class="fa-solid fa-magnifying-glass"></i> Buscar
                </button>
            </div>
        </div>

        <!-- TABLA DE RESULTADOS -->
        <div id="tablaResultados"></div>

    </div>
</div>

<!-- SCRIPT PARA BUSCAR -->
<script>
document.getElementById("btnBuscar").addEventListener("click", function() {

    const cedula = document.getElementById("buscarCedula").value;
    const fecha  = document.getElementById("buscarFecha").value;

    if (cedula === "" && fecha === "") {
        Swal.fire({
            icon: "warning",
            title: "Debe ingresar un criterio",
            text: "Ingrese una cédula o una fecha.",
        });
        return;
    }

    let datos = new FormData();
    datos.append("cedula", cedula);
    datos.append("fecha", fecha);

    fetch("../../backend/citas/buscar.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById("tablaResultados").innerHTML = html;
    });
});
</script>

</body>
</html>
