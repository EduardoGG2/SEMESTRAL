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
    <title>Panel de Control - SEGE-C</title>

    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet">

    <link 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" 
        rel="stylesheet">

    <style>
        body {
            background: #eef1f7;
            font-family: "Segoe UI", sans-serif;
        }

        /* NAVBAR */
        .header-gradient {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
        }

        /* BANNER PROFESIONAL CON LOGO CUADRADO */
        .banner-container {
            width: 100%;
            padding: 40px 0;
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            border-radius: 0 0 25px 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
        }

        .banner-logo {
            width: 150px;
            height: 150px;
            border-radius: 18px;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.35);
        }

        /* TARJETAS */
        .card-mod {
            border-radius: 18px;
            padding: 30px 20px;
            transition: 0.3s;
            background: white;
            border: none;
        }
        .card-mod:hover {
            transform: translateY(-6px);
            box-shadow: 0px 12px 30px rgba(0,0,0,0.15);
        }
        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #edf0ff;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
        }

        /* FOOTER */
        footer {
            margin-top: 50px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            padding-bottom: 20px;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark header-gradient p-3 shadow">
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

    <!-- BANNER LOGO -->
    <div class="banner-container mb-5">
        <img src="publics/img/logo.jpg" class="banner-logo" alt="Logo SEGE-C">
    </div>

    <div class="container">

        <h2 class="fw-bold text-center mb-4">Panel Principal</h2>

        <div class="row g-4 justify-content-center">

            <!-- Registrar Paciente -->
            <div class="col-md-3">
                <a href="modules/pacientes/registrar.php" class="text-decoration-none text-dark">
                    <div class="card-mod shadow-sm text-center">
                        <div class="icon-circle mb-3">
                            <i class="fa-solid fa-user-plus fa-2x text-primary"></i>
                        </div>
                        <h4 class="fw-bold">Registrar Pacientes</h4>
                        <p class="text-muted">Ingreso de nuevos pacientes</p>
                    </div>
                </a>
            </div>

            <!-- Registrar Cita -->
            <div class="col-md-3">
                <a href="modules/citas/registrar.php" class="text-decoration-none text-dark">
                    <div class="card-mod shadow-sm text-center">
                        <div class="icon-circle mb-3">
                            <i class="fa-solid fa-calendar-plus fa-2x text-success"></i>
                        </div>
                        <h4 class="fw-bold">Registrar Cita</h4>
                        <p class="text-muted">Programar citas médicas</p>
                    </div>
                </a>
            </div>

            <!-- Consultar Citas -->
            <div class="col-md-3">
                <a href="modules/citas/consultar.php" class="text-decoration-none text-dark">
                    <div class="card-mod shadow-sm text-center">
                        <div class="icon-circle mb-3">
                            <i class="fa-solid fa-search fa-2x text-danger"></i>
                        </div>
                        <h4 class="fw-bold">Consultar Citas</h4>
                        <p class="text-muted">Búsqueda por fecha o cédula</p>
                    </div>
                </a>
            </div>

            <!-- Control de Glucosa -->
            <div class="col-md-3">
                <a href="modules/glucosa/control.php" class="text-decoration-none text-dark">
                    <div class="card-mod shadow-sm text-center">
                        <div class="icon-circle mb-3">
                            <i class="fa-solid fa-heart-pulse fa-2x text-warning"></i>
                        </div>
                        <h4 class="fw-bold">Control de Glucosa</h4>
                        <p class="text-muted">Registro de lecturas</p>
                    </div>
                </a>
            </div>

        </div>

        <footer>
            SEGE-C — Sistema de Gestión Clínica<br>
            <strong>Desarrollado por: Eduardo Jurado</strong>
        </footer>

    </div>

</body>
</html>
