<?php
// Permitir acceso desde cualquier origen (Inseguro para producción, útil para desarrollo)
header("Access-Control-Allow-Origin: *");

// Permitir métodos específicos (GET, POST, etc.)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Permitir encabezados específicos (necesario si envías JSON o Auth tokens)
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Manejar la solicitud "Preflight" (Opcional pero recomendado si usas Fetch con JSON)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
// Define tus credenciales (¡Nunca las subas a un repositorio público!)
define('DB_HOST', 'localhost'); // O tu servidor (ej. 127.0.0.1)
define('DB_NAME', 'atasko');
define('DB_USER', 'root');    // Usuario de MySQL (ej. 'root')
define('DB_PASS', '');    // Contraseña de MySQL
define('DB_CHARSET', 'utf8mb4');    // Charset recomendado

// Opciones de PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // DSN (Data Source Name) para MySQL
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    
    // Crear la instancia de PDO
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // Manejar error de conexión
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>