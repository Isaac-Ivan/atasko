<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/config.php';

function ObtenerProductos()
{
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT p.idproducto, p.nombre, p.precio, c.nombre as categoria FROM producto as p inner JOIN categoria as c ON p.idcategoria = c.idcategoria");
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC); // Usar FETCH_ASSOC es buena práctica

        return json_encode($productos);
    } catch (PDOException $e) {
        // En caso de error, siempre devuelve un JSON de error válido
        http_response_code(500); // Código 500 para error de servidor
        return json_encode(["error" => "Error al obtener los productos: " . $e->getMessage()]);
    }
}

// 💥 SOLUCIÓN: Imprimir el valor de retorno de la función
echo ObtenerProductos();
