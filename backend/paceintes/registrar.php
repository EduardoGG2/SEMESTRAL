<?php
/* ---------------------------------------------------------
   REGISTRO PACIENTE – EXAMEN DESARROLLO WEB
   Recibe datos del formulario y los guarda en MySQL
------------------------------------------------------------ */

include("../config.php"); // Ajustado a tu estructura

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = $_POST["nombre"];
    $cedula = $_POST["cedula"];
    $genero = $_POST["genero"];
    $edad = $_POST["edad"];
    $sangre = $_POST["sangre"];
    $especialidad = $_POST["especialidad"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];

    $sql = "INSERT INTO pacientes 
            (nombre, cedula, genero, edad, tipo_sangre, especialidad, telefono, correo)
            VALUES 
            ('$nombre', '$cedula', '$genero', '$edad', '$sangre', '$especialidad', '$telefono', '$correo')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Paciente registrado correctamente.');
                window.location.href='../../modules/pacientes/registrar.html';
              </script>";
    } else {
        echo "Error al registrar: " . $conn->error;
    }
}
?>
