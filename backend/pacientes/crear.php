<?php
session_start();
require "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre        = $_POST["nombre"];
    $cedula        = $_POST["cedula"];
    $genero        = $_POST["genero"];
    $edad          = $_POST["edad"];
    $tipo_sangre   = $_POST["tipo_sangre"];
    $especialidad  = $_POST["especialidad"];
    $telefono      = $_POST["telefono"];
    $correo        = $_POST["correo"];

    $sql = "INSERT INTO pacientes 
            (nombre, cedula, genero, edad, tipo_sangre, especialidad, telefono, correo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss",
        $nombre,
        $cedula,
        $genero,
        $edad,
        $tipo_sangre,
        $especialidad,
        $telefono,
        $correo
    );

    if ($stmt->execute()) {
        header("Location: ../../modules/pacientes/registrar.php?ok=1");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
