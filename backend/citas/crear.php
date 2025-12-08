<?php
session_start();
require "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $cedula       = $_POST["cedula"];
    $fecha        = $_POST["fecha"];
    $hora         = $_POST["hora"];
    $especialidad = $_POST["especialidad"];
    $motivo       = $_POST["motivo"];
    $correo       = $_POST["correo"];
    $creado_por   = $_SESSION["usuario_nombre"]; 

    $sql = "INSERT INTO citas (cedula, fecha, hora, especialidad, motivo, correo_paciente, creado_por)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss",
        $cedula,
        $fecha,
        $hora,
        $especialidad,
        $motivo,
        $correo,
        $creado_por
    );

    if ($stmt->execute()) {

        // Obtener el ID generado automáticamente
        $idCita = $conn->insert_id;

        // Redirigir enviando datos a registrar.php para EmailJS
        header("Location: ../../modules/citas/registrar.php?ok=1&id=$idCita&fecha=$fecha&especialidad=$especialidad&correo=$correo");
        exit;

    } else {
        echo "Error SQL: " . $conn->error;
    }
}
?>
