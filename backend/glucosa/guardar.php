<?php
require "../config.php";

$cedula  = $_POST["cedula"];
$lectura = $_POST["lectura"];
$momento_original = $_POST["momento"];
$estado  = $_POST["estado"];

// Convertir momento al ENUM correcto
$momento = "";

if ($momento_original === "Ayunas") {
    $momento = "Ayunas";
} 
else if ($momento_original === "Antes de la comida") {
    $momento = "Antes de comer";
} 
else if ($momento_original === "2 horas después de comer") {
    $momento = "2h después";
}

// Fecha y hora actuales
$fecha = date("Y-m-d");
$hora  = date("H:i:s");

$sql = "INSERT INTO glucosa (cedula, lectura, momento, estado, fecha, hora)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sissss", 
    $cedula, 
    $lectura, 
    $momento, 
    $estado, 
    $fecha, 
    $hora
);

if (!$stmt->execute()) {
    die("Error SQL: " . $stmt->error);
}

echo "OK";
?>
