<?php

// ---- WEB ROUTES ----
$router->add('GET', '/', function() use ($basePath) {
    include __DIR__ . '/../views/pages/index.php';
});

$router->add('GET', '/productos', function() use ($basePath) {
    include __DIR__ . '/../views/pages/productos.php';
});


// ---- API ROUTES ----
$router->add('GET', '/api/productos', 'Api\Controllers\ProductController@index');
$router->add('GET', '/api/productos/:id', 'Api\Controllers\ProductController@show');
$router->add('GET', '/api/productos/categoria/:categoria', 'Api\Controllers\ProductController@showByCategory');
$router->add('GET', '/api/productos/buscar/:termino', 'Api\Controllers\ProductController@search');
