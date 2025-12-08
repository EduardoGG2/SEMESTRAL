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

// No hay resultados
if ($result->num_rows === 0) {
    echo "
        <div class='alert alert-warning text-center mt-4'>
            <i class='fa-solid fa-circle-exclamation'></i>
            No se encontraron citas con los datos ingresados.
        </div>
    ";
    exit;
}

echo "
<div class='table-responsive mt-4'>
<table class='table table-hover align-middle shadow-sm' 
       style='border-radius:12px; overflow:hidden;'>
       
    <thead class='table-dark text-center'>
        <tr>
            <th><i class='fa-solid fa-hashtag'></i> ID</th>
            <th><i class='fa-solid fa-id-card'></i> Cédula</th>
            <th><i class='fa-solid fa-calendar'></i> Fecha</th>
            <th><i class='fa-solid fa-clock'></i> Hora</th>
            <th><i class='fa-solid fa-stethoscope'></i> Especialidad</th>
            <th><i class='fa-solid fa-notes-medical'></i> Motivo</th>
            <th><i class='fa-solid fa-envelope'></i> Correo</th>
            <th><i class='fa-solid fa-user-nurse'></i> Creado Por</th>
        </tr>
    </thead>

    <tbody class='text-center'>
";

// Mostrar filas
while ($row = $result->fetch_assoc()) {

    // Badge para especialidad
    $badgeEsp = "<span class='badge bg-secondary'>{$row['especialidad']}</span>";

    if (stripos($row['especialidad'], "Medicina") !== false)
        $badgeEsp = "<span class='badge bg-primary'><i class='fa-solid fa-user-doctor'></i> {$row['especialidad']}</span>";

    if (stripos($row['especialidad'], "Odont") !== false)
        $badgeEsp = "<span class='badge bg-info text-dark'><i class='fa-solid fa-tooth'></i> {$row['especialidad']}</span>";

    if (stripos($row['especialidad'], "Gine") !== false)
        $badgeEsp = "<span class='badge bg-pink text-white'><i class='fa-solid fa-person-dress'></i> {$row['especialidad']}</span>";

    if (stripos($row['especialidad'], "Pedia") !== false)
        $badgeEsp = "<span class='badge bg-warning text-dark'><i class='fa-solid fa-baby'></i> {$row['especialidad']}</span>";

    echo "
    <tr>
        <td>{$row['id']}</td>
        <td>{$row['cedula']}</td>
        <td>{$row['fecha']}</td>
        <td>{$row['hora']}</td>
        <td>$badgeEsp</td>
        <td>{$row['motivo']}</td>
        <td>{$row['correo_paciente']}</td>
        <td>{$row['creado_por']}</td>
    </tr>
    ";
}

echo "
    </tbody>
</table>
</div>
";
?>
