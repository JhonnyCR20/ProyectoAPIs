<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../accessoDatos/LibroDAO.php';

class LibroApiController
{
    // Atributo privado para interactuar con la capa de acceso a datos
    private $libroDAO;

    // Constructor: Inicializa la instancia de LibroDAO
    public function __construct()
    {
        $this->libroDAO = new LibroDAO();
    }

    // Método para procesar las solicitudes HTTP
    public function procesarPeticion($metodo, $id = null)
    {
        header('Content-Type: application/json'); // Configura el encabezado de respuesta

        try {
            switch ($metodo) {
                case 'GET':
                    if ($id) {
                        // Obtiene un libro por su ID
                        $libro = $this->libroDAO->getById($id);
                        if ($libro) {
                            echo json_encode(['status' => 'success', 'data' => $libro->toArray()]);
                        } else {
                            http_response_code(404);
                            echo json_encode(['status' => 'error', 'message' => 'Libro no encontrado']);
                        }
                    } else {
                        // Obtiene todos los libros
                        $libros = $this->libroDAO->getAll();
                        echo json_encode(['status' => 'success', 'data' => array_map(function ($libro) {
                            return $libro->toArray();
                        }, $libros)]);
                    }
                    break;

                case 'POST':
                    // Crea un nuevo libro
                    $datos = json_decode(file_get_contents('php://input'), true);
                    $libro = new Libro();
                    $libro->setTitulo($datos['titulo']);
                    $libro->setAnioPublicacion($datos['anio_publicacion']);
                    $libro->setIdCategoria($datos['id_categoria']);
                    $libro->setIdEditorial($datos['id_editorial']);
                    $libro->setIsbn($datos['isbn']);
                    $libro->setCantidadDisponible($datos['cantidad_disponible']);
                    if (isset($datos['autores']) && is_array($datos['autores'])) {
                        $libro->setAutores($datos['autores']);
                    }

                    $id = $this->libroDAO->create($libro);
                    http_response_code(201);
                    echo json_encode(['status' => 'success', 'message' => 'Libro creado', 'id' => $id]);
                    break;

                case 'PUT':
                    if (!$id) {
                        http_response_code(400);
                        echo json_encode(['status' => 'error', 'message' => 'Se requiere ID']);
                        break;
                    }
                    // Actualiza un libro existente
                    $datos = json_decode(file_get_contents('php://input'), true);
                     file_put_contents(__DIR__ . '/debug_libro_put.log', print_r($datos, true), FILE_APPEND);
                    $libro = new Libro();
                    $libro->setId($id);
                    $libro->setTitulo($datos['titulo']);
                    $libro->setAnioPublicacion($datos['anio_publicacion']);
                    $libro->setIdCategoria($datos['id_categoria']);
                    $libro->setIdEditorial($datos['id_editorial']);
                    $libro->setIsbn($datos['isbn']);
                    $libro->setCantidadDisponible($datos['cantidad_disponible']);
                    if (isset($datos['autores']) && is_array($datos['autores'])) {
                        $libro->setAutores($datos['autores']);
                    }

                    $this->libroDAO->update($libro);
                    echo json_encode(['status' => 'success', 'message' => 'Libro actualizado']);
                    break;

                case 'DELETE':
                    if (!$id) {
                        http_response_code(400);
                        echo json_encode(['status' => 'error', 'message' => 'Se requiere ID']);
                        break;
                    }
                    // Elimina un libro por su ID
                    $this->libroDAO->delete($id);
                    echo json_encode(['status' => 'success', 'message' => 'Libro eliminado']);
                    break;

                default:
                    http_response_code(405);
                    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
                    break;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
