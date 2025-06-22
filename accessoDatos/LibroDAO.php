<?php
require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../models/Libro.php';

class LibroDAO {
    // Atributo privado para la conexión a la base de datos
    private $pdo;

    // Constructor: Inicializa la conexión a la base de datos
    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Método para obtener todos los libros
    public function getAll() {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT l.*, c.nombre as categoria_nombre, e.nombre as editorial_nombre 
                 FROM Grupo6_libros l
                 LEFT JOIN Grupo6_categorias c ON l.id_categoria = c.id_categoria
                 LEFT JOIN Grupo6_editoriales e ON l.id_editorial = e.id_editorial"
            );
            $stmt->execute();
            $libros = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Crea objetos Libro a partir de los datos obtenidos
                $libro = new Libro();
                $libro->setId($row['id_libro']);
                $libro->setTitulo($row['titulo']);
                $libro->setAnioPublicacion($row['anio_publicacion']);
                $libro->setIdCategoria($row['id_categoria']);
                $libro->setIdEditorial($row['id_editorial']);
                $libro->setIsbn($row['isbn']);
                $libro->setCantidadDisponible($row['cantidad_disponible']);
                $libro->setCategoriaNombre($row['categoria_nombre']);
                $libro->setEditorialNombre($row['editorial_nombre']);
                
                // Obtener autores del libro
                $stmtAutores = $this->pdo->prepare(
                    "SELECT a.* FROM Grupo6_autores a
                     INNER JOIN Grupo6_libros_autores la ON a.id_autor = la.id_autor
                     WHERE la.id_libro = :id_libro"
                );
                $stmtAutores->bindParam(':id_libro', $row['id_libro']);
                $stmtAutores->execute();
                $autores = $stmtAutores->fetchAll(PDO::FETCH_ASSOC);
                $libro->setAutores($autores);
                
                $libros[] = $libro;
            }
            return $libros;
        } catch (PDOException $e) {
            throw new Exception("Error al obtener libros: " . $e->getMessage());
        }
    }

    // Método para obtener un libro por su ID
    public function getById($id) {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT l.*, c.nombre as categoria_nombre, e.nombre as editorial_nombre 
                 FROM Grupo6_libros l
                 LEFT JOIN Grupo6_categorias c ON l.id_categoria = c.id_categoria
                 LEFT JOIN Grupo6_editoriales e ON l.id_editorial = e.id_editorial
                 WHERE l.id_libro = :id"
            );
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $libro = new Libro();
                $libro->setId($row['id_libro']);
                $libro->setTitulo($row['titulo']);
                $libro->setAnioPublicacion($row['anio_publicacion']);
                $libro->setIdCategoria($row['id_categoria']);
                $libro->setIdEditorial($row['id_editorial']);
                $libro->setIsbn($row['isbn']);
                $libro->setCantidadDisponible($row['cantidad_disponible']);
                $libro->setCategoriaNombre($row['categoria_nombre']);
                $libro->setEditorialNombre($row['editorial_nombre']);
                
                // Obtener autores del libro
                $stmtAutores = $this->pdo->prepare(
                    "SELECT a.* FROM Grupo6_autores a
                     INNER JOIN Grupo6_libros_autores la ON a.id_autor = la.id_autor
                     WHERE la.id_libro = :id_libro"
                );
                $stmtAutores->bindParam(':id_libro', $id);
                $stmtAutores->execute();
                $autores = $stmtAutores->fetchAll(PDO::FETCH_ASSOC);
                $libro->setAutores($autores);
                
                return $libro;
            }
            return null;
        } catch (PDOException $e) {
            throw new Exception("Error al obtener libro: " . $e->getMessage());
        }
    }

    // Método para crear un nuevo libro
    public function create($libro) {
        try {
            $this->pdo->beginTransaction();
            
            $stmt = $this->pdo->prepare(
                "INSERT INTO Grupo6_libros (titulo, anio_publicacion, id_categoria, id_editorial, isbn, cantidad_disponible) 
                 VALUES (:titulo, :anio_publicacion, :id_categoria, :id_editorial, :isbn, :cantidad_disponible)"
            );
            
            $titulo = $libro->getTitulo();
            $anio = $libro->getAnioPublicacion();
            $idCategoria = $libro->getIdCategoria();
            $idEditorial = $libro->getIdEditorial();
            $isbn = $libro->getIsbn();
            $cantidad = $libro->getCantidadDisponible();
            
            $stmt->bindParam(":titulo", $titulo);
            $stmt->bindParam(":anio_publicacion", $anio);
            $stmt->bindParam(":id_categoria", $idCategoria);
            $stmt->bindParam(":id_editorial", $idEditorial);
            $stmt->bindParam(":isbn", $isbn);
            $stmt->bindParam(":cantidad_disponible", $cantidad);
            
            $stmt->execute();
            $idLibro = $this->pdo->lastInsertId();
            
            // Insertar autores
            if ($libro->getAutores()) {
                $stmtAutores = $this->pdo->prepare(
                    "INSERT INTO Grupo6_libros_autores (id_libro, id_autor) VALUES (:id_libro, :id_autor)"
                );
                foreach ($libro->getAutores() as $autor) {
                    if (is_array($autor) && isset($autor['id_autor'])) {
                        $idAutor = $autor['id_autor'];
                    } else {
                        $idAutor = $autor;
                    }
                    $stmtAutores->bindParam(":id_libro", $idLibro);
                    $stmtAutores->bindParam(":id_autor", $idAutor);
                    $stmtAutores->execute();
                }
            }
            
            $this->pdo->commit();
            return $idLibro;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new Exception("Error al crear libro: " . $e->getMessage());
        }
    }

    // Método para actualizar un libro existente
    public function update($libro) {
        try {
            $this->pdo->beginTransaction();
            
            $stmt = $this->pdo->prepare(
                "UPDATE Grupo6_libros 
                 SET titulo = :titulo, 
                     anio_publicacion = :anio_publicacion, 
                     id_categoria = :id_categoria, 
                     id_editorial = :id_editorial, 
                     isbn = :isbn, 
                     cantidad_disponible = :cantidad_disponible 
                 WHERE id_libro = :id"
            );
            
            $id = $libro->getId();
            $titulo = $libro->getTitulo();
            $anio = $libro->getAnioPublicacion();
            $idCategoria = $libro->getIdCategoria();
            $idEditorial = $libro->getIdEditorial();
            $isbn = $libro->getIsbn();
            $cantidad = $libro->getCantidadDisponible();
            
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":titulo", $titulo);
            $stmt->bindParam(":anio_publicacion", $anio);
            $stmt->bindParam(":id_categoria", $idCategoria);
            $stmt->bindParam(":id_editorial", $idEditorial);
            $stmt->bindParam(":isbn", $isbn);
            $stmt->bindParam(":cantidad_disponible", $cantidad);
            
            $stmt->execute();
            
            // Actualizar autores
            $stmt = $this->pdo->prepare("DELETE FROM Grupo6_libros_autores WHERE id_libro = :id_libro");
            $stmt->bindParam(":id_libro", $id);
            $stmt->execute();
            
            if ($libro->getAutores()) {
                $stmtAutores = $this->pdo->prepare(
                    "INSERT INTO Grupo6_libros_autores (id_libro, id_autor) VALUES (:id_libro, :id_autor)"
                );
                foreach ($libro->getAutores() as $autor) {
                    if (is_array($autor) && isset($autor['id_autor'])) {
                        $idAutor = $autor['id_autor'];
                    } else {
                        $idAutor = $autor;
                    }
                    $stmtAutores->bindParam(":id_libro", $id);
                    $stmtAutores->bindParam(":id_autor", $idAutor);
                    $stmtAutores->execute();
                }
            }
            
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new Exception("Error al actualizar libro: " . $e->getMessage());
        }
    }

    // Método para eliminar un libro por su ID
    public function delete($id) {
        try {
            $this->pdo->beginTransaction();
            
            // Eliminar relaciones con autores
            $stmt = $this->pdo->prepare("DELETE FROM Grupo6_libros_autores WHERE id_libro = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            
            // Eliminar el libro
            $stmt = $this->pdo->prepare("DELETE FROM Grupo6_libros WHERE id_libro = :id");
            $stmt->bindParam(":id", $id);
            $result = $stmt->execute();
            
            $this->pdo->commit();
            return $result;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new Exception("Error al eliminar libro: " . $e->getMessage());
        }
    }
}
?>
