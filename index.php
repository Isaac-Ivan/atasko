<?php
// Front controller simple
$basePath = '/atasko'; // Ajusta si tu proyecto está en otra ruta

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Normalizar quitando el basePath si existe
if (strpos($uri, $basePath) === 0) {
    $route = substr($uri, strlen($basePath));
} else {
    $route = $uri;
}
$route = '/' . trim($route, '/');

// Mapa de rutas a archivos (agrega los que necesites)
$routes = [
    '/' => 'index',
    '/productos' => 'productos',
    '/contacto' => 'contact'
];

$pageKey = $routes[$route] ?? null;
$pageFile = $pageKey ? __DIR__ . "/views/pages/{$pageKey}.php" : null;

function cssVer($path) {
    return file_exists($path) ? filemtime($path) : time();
}
$cssDir = __DIR__ . '/public/css/';
$ver = cssVer($cssDir . 'styles.css');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Atasko - Tienda para Mascotas</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>/public/css/styles.css?v=<?php echo $ver; ?>">
</head>
<body>

<?php include __DIR__ . '/views/partials/header.php'; ?>

<main class="contenedor-main">
    <?php
    if ($pageFile && file_exists($pageFile)) {
        include $pageFile;
    } else {
        http_response_code(404);
        echo '<section class="contenedor"><h2>Página no encontrada</h2><p>La ruta solicitada no existe.</p></section>';
    }
    ?>
</main>

    <!-- Inicio Footer -->
    <?php include __DIR__ . '/views/partials/footer.php'; ?>
</body>
</html>
