<?php

require __DIR__ . '/../autoload.php';

$basePath = '/atasko';
$router = new Lib\Router($basePath);

// Load route definitions
require __DIR__ . '/../routes/web.php';

return $router;
