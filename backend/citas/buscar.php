<?php
require "../config.php";

$cedula = $_POST["cedula"] ?? "";
$fecha  = $_POST["fecha"] ?? "";

$query = "SELECT * FROM citas WHERE 1=1";

if (!empty($cedula)) {
    $query .= " AND cedula LIKE '%$cedula%'";
}

if (!empty($fecha)) {
    $query .= " AND fecha = '$fecha'";
}

$query .= " ORDER BY fecha DESC, hora ASC";

$result = $conn->query($query);

if ($result->num_rows === 0) {
    echo "<div class='alert alert-warning mt-4'>No se encontraron citas.</div>";
    exit;
}

echo "
<table class='table table-bordered table-striped mt-4'>
    <thead class='table-dark'>
        <tr>
            <th>ID</th>
            <th>Cédula</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Especialidad</th>
            <th>Motivo</th>
            <th>Correo</th>
            <th>Creado Por</th>
        </tr>
    </thead>
    <tbody>
";

while ($row = $result->fetch_assoc()) {
    echo "
    <tr>
        <td>{$row['id']}</td>
        <td>{$row['cedula']}</td>
        <td>{$row['fecha']}</td>
        <td>{$row['hora']}</td>
        <td>{$row['especialidad']}</td>
        <td>{$row['motivo']}</td>
        <td>{$row['correo_paciente']}</td>
        <td>{$row['creado_por']}</td>
    </tr>
    ";
}

echo "</tbody></table>";
?>
