<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            height: 100vh;
            font-family: "Segoe UI", sans-serif;
        }
        .login-card {
            width: 430px;
            border-radius: 20px;
            padding: 35px 30px;
            background: white;
        }
        .input-group-text {
            background: #eef0ff;
        }
    </style>
</head>

<body class="d-flex flex-column justify-content-center align-items-center">

    <div class="card shadow login-card">

        <ul class="nav nav-tabs mb-4" id="loginTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button">
                    <i class="fa-solid fa-right-to-bracket"></i> Iniciar Sesión
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button">
                    <i class="fa-solid fa-user-plus"></i> Registrar Paciente
                </button>
            </li>
        </ul>

        <div class="tab-content">

            <!-- LOGIN -->
            <div class="tab-pane fade show active" id="login" role="tabpanel">

                <h3 class="text-center fw-bold">Acceder</h3>
                <p class="text-center text-muted mb-4">Inicia sesión con tu cuenta</p>

                <form method="POST" action="backend/login.php">

                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <input type="text" class="form-control" name="usuario" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Entrar
                    </button>

                </form>

            </div>

            <!-- REGISTRO -->
            <div class="tab-pane fade" id="register" role="tabpanel">

                <h3 class="text-center fw-bold">Registrar Paciente</h3>
                <p class="text-center text-muted mb-4">Crea una cuenta de paciente</p>

                <form method="POST" action="backend/register.php" onsubmit="return validarPasswords();">

                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-id-card"></i>
                            </span>
                            <input type="text" class="form-control" name="usuario" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-key"></i>
                            </span>
                            <input type="password" id="password" class="form-control" name="password" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirmar Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-check-double"></i>
                            </span>
                            <input type="password" id="confirmar" class="form-control" required>
                        </div>
                    </div>

                    <!-- Rol fijo -->
                    <input type="hidden" name="rol" value="paciente">

                    <button type="submit" class="btn btn-success w-100">
                        <i class="fa-solid fa-user-check"></i> Registrar Paciente
                    </button>

                </form>

            </div>

        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function validarPasswords() {
            let pass = document.getElementById("password").value;
            let conf = document.getElementById("confirmar").value;

            if (pass !== conf) {
                Swal.fire({
                    icon: 'error',
                    title: 'Contraseñas no coinciden',
                    text: 'Por favor verifica ambas contraseñas.',
                    confirmButtonColor: '#d33'
                });
                return false;
            }

            Swal.fire({
                icon: 'success',
                title: 'Registro completado',
                text: 'Tu cuenta de paciente está siendo creada...',
                showConfirmButton: false,
                timer: 1500
            });

            return true;
        }
    </script>

    <script>
    // Detectar error de login en la URL
    const params = new URLSearchParams(window.location.search);

    if (params.get("error") === "1") {
        Swal.fire({
            icon: "error",
            title: "Credenciales incorrectas",
            text: "Usuario o contraseña inválida.",
            confirmButtonColor: "#d33"
        });

        // limpiar la URL para evitar la repetición del mensaje
        window.history.replaceState({}, document.title, window.location.pathname);
    }
</script>


</body>
</html>