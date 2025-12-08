<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Acceso Denegado – Anti ScriptKiddie Mode</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
    body {
        background: #0c0f16;
        color: #d3d7e0;
        font-family: "Segoe UI", sans-serif;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .error-box {
        text-align: center;
        background: rgba(255,255,255,0.05);
        padding: 45px;
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.15);
        width: 480px;
        backdrop-filter: blur(6px);
        box-shadow: 0 0 30px rgba(0,0,0,0.4);
        animation: popIn 0.4s ease;
    }

    .error-box i {
        font-size: 70px;
        color: #ff4d6d;
        margin-bottom: 10px;
    }

    @keyframes popIn {
        from { transform: scale(0.85); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .btn-home {
        background: #ff4d6d;
        color: white;
        border: none;
        padding: 12px 26px;
        border-radius: 12px;
        transition: 0.2s;
        margin-top: 20px;
    }

    .btn-home:hover {
        background: #ff2e50;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(255,77,109,0.35);
    }

    .joke {
        font-size: 14px;
        opacity: 0.85;
        margin-top: 12px;
    }

    .bubble {
        background: rgba(255,255,255,0.08);
        padding: 15px;
        border-radius: 12px;
        margin-top: 15px;
        font-size: 14px;
    }
</style>

</head>
<body>

<div class="error-box">

    <i class="fa-solid fa-user-ninja"></i>

    <h2 class="fw-bold">Alto ahí, pequeño hacker de fin de semana</h2>

    <p class="mt-2">
        Este módulo no es para ti.<br>
        Sí, sabemos que intentaste escribir la URL a mano.<br>
        Y sí, también sabemos que lo viste en un tutorial de YouTube de 7 minutos.
    </p>

    <div class="bubble">
        <strong>Firewall SEGE-C dice:</strong><br>
        “Ocultar un botón no te da permiso, campeón”.<br>
        “Vuelve cuando aprendas lo que es un rol de usuario”.
    </div>

    <p class="joke">
        PD: Todos los intentos fueron anotados en tu libreta imaginaria de “cosas que no funcionan”.
    </p>

    <a href="../dashboard.php" class="btn-home">
        <i class=""></i> Volver al Panel
    </a>
</div>

</body>
</html>
