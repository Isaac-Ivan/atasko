<?php

$router = require __DIR__ . '/bootstrap/app.php';


$basePath = '/atasko';

// Asset helper function
function asset($path) {
    global $basePath;
    $filePath = __DIR__ . '/public/' . ltrim($path, '/');
    $version = file_exists($filePath) ? filemtime($filePath) : time();
    return "{$basePath}/public/{$path}?v={$version}";
}



ob_start();
$router->dispatch();
$content = ob_get_clean();

$isApiRequest = false;
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (strpos($uri, $basePath . '/api/') === 0) {
    $isApiRequest = true;
}
if ($isApiRequest) {

    echo $content;
} else {

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Atasko - Tienda para Mascotas</title>
    <link rel="stylesheet" href="<?php echo asset('css/styles.css'); ?>">
</head>
<body>

<?php include __DIR__ . '/views/partials/header.php'; ?>

<main class="contenedor-main">
    <?php echo $content; ?>
</main>

<?php include __DIR__ . '/views/partials/footer.php'; ?>

</body>
</html>
<?php
}
