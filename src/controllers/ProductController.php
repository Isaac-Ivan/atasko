<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/config.php';

class ProductController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Obtiene todos los productos
     */
    public function obtenerTodos()
    {
        try {
            $stmt = $this->pdo->query(
                "SELECT p.idproducto, p.nombre, p.precio, c.nombre as categoria 
                 FROM producto as p 
                 INNER JOIN categoria as c ON p.idcategoria = c.idcategoria"
            );
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->respuesta(200, $productos);
        } catch (PDOException $e) {
            return $this->respuesta(500, ["error" => "Error al obtener productos: " . $e->getMessage()]);
        }
    }

    /**
     * Obtiene un producto específico por ID
     */
    public function obtenerPorId($id)
    {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT p.idproducto, p.nombre, p.precio, p.descripcion, c.nombre as categoria 
                 FROM producto as p 
                 INNER JOIN categoria as c ON p.idcategoria = c.idcategoria 
                 WHERE p.idproducto = ?"
            );
            $stmt->execute([$id]);
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$producto) {
                return $this->respuesta(404, ["error" => "Producto no encontrado"]);
            }

            return $this->respuesta(200, $producto);
        } catch (PDOException $e) {
            return $this->respuesta(500, ["error" => "Error al obtener producto: " . $e->getMessage()]);
        }
    }

    /**
     * Obtiene productos por categoría
     */
    public function obtenerPorCategoria($categoria)
    {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT p.idproducto, p.nombre, p.precio, c.nombre as categoria 
                 FROM producto as p 
                 INNER JOIN categoria as c ON p.idcategoria = c.idcategoria 
                 WHERE c.nombre = ?"
            );
            $stmt->execute([$categoria]);
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($productos)) {
                return $this->respuesta(404, ["error" => "No hay productos en esta categoría"]);
            }

            return $this->respuesta(200, $productos);
        } catch (PDOException $e) {
            return $this->respuesta(500, ["error" => "Error al obtener productos: " . $e->getMessage()]);
        }
    }

    /**
     * Busca productos por nombre (búsqueda parcial)
     */
    public function buscar($termino)
    {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT p.idproducto, p.nombre, p.precio, c.nombre as categoria 
                 FROM producto as p 
                 INNER JOIN categoria as c ON p.idcategoria = c.idcategoria 
                 WHERE p.nombre LIKE ?"
            );
            $stmt->execute(['%' . $termino . '%']);
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($productos)) {
                return $this->respuesta(404, ["error" => "No se encontraron productos"]);
            }

            return $this->respuesta(200, $productos);
        } catch (PDOException $e) {
            return $this->respuesta(500, ["error" => "Error en la búsqueda: " . $e->getMessage()]);
        }
    }

    /**
     * Método auxiliar para respuestas consistentes
     */
    private function respuesta($codigo, $datos)
    {
        http_response_code($codigo);
        return json_encode($datos);
    }
}

// Router simple: detectar el endpoint y llamar al método
$metodo = $_GET['metodo'] ?? 'todos';
$id = $_GET['id'] ?? null;
$categoria = $_GET['categoria'] ?? null;
$termino = $_GET['q'] ?? null;

$controller = new ProductController($pdo);

switch ($metodo) {
    case 'todos':
        echo $controller->obtenerTodos();
        break;
    case 'id':
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Parámetro 'id' requerido"]);
        } else {
            echo $controller->obtenerPorId($id);
        }
        break;
    case 'categoria':
        if (!$categoria) {
            http_response_code(400);
            echo json_encode(["error" => "Parámetro 'categoria' requerido"]);
        } else {
            echo $controller->obtenerPorCategoria($categoria);
        }
        break;
    case 'buscar':
        if (!$termino) {
            http_response_code(400);
            echo json_encode(["error" => "Parámetro 'q' requerido"]);
        } else {
            echo $controller->buscar($termino);
        }
        break;
    default:
        http_response_code(400);
        echo json_encode(["error" => "Método no válido"]);
}
?>