<?php
/**
 * Archivo de inicialización del sistema SEGE-C
 * Funcionalidad:
 *  - Carga de variables de entorno (segec.env)
 *  - Lectura de parámetros operativos (config.json)
 *  - Conexión segura a MySQL
 *  - Configuración de zona horaria y parámetros globales
 */

// Carga manual de archivo de variables de entorno sin exponer información sensible
function loadEnvFile($path)
{
    if (!file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {

        // Se omiten comentarios y líneas inválidas
        if (str_starts_with(trim($line), '#')) {
            continue;
        }

        $pair = explode('=', $line, 2);

        if (count($pair) === 2) {
            putenv(trim($pair[0]) . "=" . trim($pair[1]));
        }
    }
}

// Cargar archivo de entorno principal del sistema
loadEnvFile(__DIR__ . "/segec.env");

// Asignación de variables críticas desde el entorno cargado
$dbHost = getenv("DB_HOST");
$dbUser = getenv("DB_USER");
$dbPass = getenv("DB_PASS");
$dbName = getenv("DB_NAME");

// Lectura de configuración general no sensible desde JSON
$appConfig = [];
$configPath = __DIR__ . "/config.json";

if (file_exists($configPath)) {
    $appConfig = json_decode(file_get_contents($configPath), true);
}

// Conexión a la base de datos con manejo controlado de errores
mysqli_report(MYSQLI_REPORT_OFF);

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_errno) {
    // Se registra el error sin mostrar detalles al usuario
    error_log(
        "[" . date("Y-m-d H:i:s") . "] Error de conexión a MySQL: " 
        . $conn->connect_error . "\n",
        3,
        __DIR__ . "/logs/db_errors.log"
    );

    // Respuesta genérica para evitar exposición de información técnica
    die("Error interno del servidor.");
}

// Configuración del charset recomendado para compatibilidad y seguridad
$conn->set_charset("utf8mb4");

// Aplicación de zona horaria desde la configuración JSON, si está definida
if (isset($appConfig["timezone"])) {
    date_default_timezone_set($appConfig["timezone"]);
}
?>
