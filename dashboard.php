<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control</title>

    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet">

    <link 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" 
        rel="stylesheet">

    <style>
        body { background: #f4f6f9; }
        .card-hover:hover {
            transform: translateY(-5px);
            transition: .3s;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .header-gradient {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark header-gradient p-3">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold fs-4">
                <i class="fa-solid fa-layer-group me-2"></i>Sistema SEGE-C
            </a>

            <div class="d-flex text-white">
                <span class="me-3">
                    <i class="fa-solid fa-user"></i>
                    <strong><?php echo $_SESSION["usuario_nombre"]; ?></strong>
                    (<?php echo $_SESSION["usuario_rol"]; ?>)
                </span>

                <a href="backend/logout.php" class="btn btn-light btn-sm">
                    <i class="fa-solid fa-right-from-bracket"></i> Salir
                </a>
            </div>
        </div>
    </nav>

    <!-- CONTENIDO -->
    <div class="container mt-5">

        <h2 class="fw-bold text-center mb-4">Panel Principal</h2>

        <div class="row g-4">

            <div class="col-md-4">
                <a href="modules/pacientes/registrar.php" class="text-decoration-none">
                    <div class="card card-hover shadow-sm p-4 text-center">
                        <i class="fa-solid fa-user-plus fa-3x text-primary mb-3"></i>
                        <h4 class="fw-bold">Registrar Pacientes</h4>
                        <p class="text-muted">Ingreso de nuevos pacientes</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="modules/citas/registrar.php" class="text-decoration-none">
                    <div class="card card-hover shadow-sm p-4 text-center">
                        <i class="fa-solid fa-calendar-plus fa-3x text-success mb-3"></i>
                        <h4 class="fw-bold">Registrar Cita</h4>
                        <p class="text-muted">Programar citas médicas</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="modules/citas/consultar.php" class="text-decoration-none">
                    <div class="card card-hover shadow-sm p-4 text-center">
                        <i class="fa-solid fa-search fa-3x text-danger mb-3"></i>
                        <h4 class="fw-bold">Consultar Citas</h4>
                        <p class="text-muted">Búsqueda por fecha o cédula</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="modules/glucosa/control.php" class="text-decoration-none">
                    <div class="card card-hover shadow-sm p-4 text-center">
                        <i class="fa-solid fa-heart-pulse fa-3x text-warning mb-3"></i>
                        <h4 class="fw-bold">Control de Glucosa</h4>
                        <p class="text-muted">Registro de lecturas</p>
                    </div>
                </a>
            </div>

        </div>
    </div>

</body>
</html>
