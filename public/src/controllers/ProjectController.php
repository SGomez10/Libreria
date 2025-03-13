<?php
require 'DatabaseController.php';

class ProjectController
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DatabaseController::connect();
        if (!$this->pdo) {
            die("Error al conectar con la base de datos.");
        }
    }

    // Método específico para el dashboard: Obtener todos los libros sin paginación ni filtros
    public function getBooksForDashboard()
    {
        $stmt = $this->pdo->query("SELECT * FROM books");
        if (!$stmt) {
            return []; // Si hay un error, retornar un array vacío
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGenres() {
        $sql = "SELECT DISTINCT genre FROM books"; // Obtener todos los géneros únicos
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_COLUMN); // Retornar un array de géneros
    }
    
    public function isValidGenre($genre) {
        $genres = $this->getGenres(); // Obtener la lista de géneros
        return in_array($genre, $genres); // Verificar si el género existe
    }

    // Obtener libros paginados con filtro de género (mantener este método para el catálogo)
    public function getBooks($page = 1, $perPage = 10, $genre = '') {
        // Validar parámetros
        $page = max(1, (int)$page); // Asegurar que $page sea al menos 1
        $perPage = max(1, (int)$perPage); // Asegurar que $perPage sea al menos 1
        $offset = ($page - 1) * $perPage;
    
        // Validar el género
        if (!empty($genre) && !$this->isValidGenre($genre)) {
            return []; // Retorna un array vacío si el género no es válido
        }
    
        $sql = "SELECT * FROM books";
        
        // Añadir filtro de género si se proporciona
        if (!empty($genre)) {
            $sql .= " WHERE genre = :genre";
        }
        
        $sql .= " LIMIT :perPage OFFSET :offset";
        
        $stmt = $this->pdo->prepare($sql);
        
        // Bindear el parámetro de género si se proporciona
        if (!empty($genre)) {
            $stmt->bindValue(':genre', $genre, PDO::PARAM_STR);
        }
        
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        if (!$stmt->execute()) {
            return []; // Retorna un array vacío en caso de error
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener el total de libros con filtro de género (mantener este método para paginado)
    public function getTotalBooks($genre = '')
    {
        $sql = "SELECT COUNT(*) as total FROM books";
        
        // Añadir filtro de género si se proporciona
        if (!empty($genre)) {
            $sql .= " WHERE genre = :genre";
        }
        
        $stmt = $this->pdo->prepare($sql);
        
        // Bindear el parámetro de género si se proporciona
        if (!empty($genre)) {
            $stmt->bindValue(':genre', $genre, PDO::PARAM_STR);
        }
        
        if (!$stmt->execute()) {
            return 0; // Si hay un error en la ejecución, retornar 0
        }
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Obtener un libro por ID
    public function getBookById($id)
    {
        // Validar que el ID sea un número
        if (!is_numeric($id)) {
            return null;
        }

        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE id = ?");
        if (!$stmt->execute([$id])) {
            return null; // Si hay un error en la ejecución, retornar null
        }
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Agregar un nuevo libro
    public function addBook($title, $price, $in_stock, $rating, $image_url, $description, $genre)
    {
        // Validar que todos los campos estén presentes
        if (empty($title) || empty($price) || empty($in_stock) || empty($rating) || empty($image_url) || empty($description) || empty($genre)) {
            return false;
        }

        $stmt = $this->pdo->prepare("INSERT INTO books (title, price, in_stock, rating, image_url, description, genre) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$title, $price, $in_stock, $rating, $image_url, $description, $genre]);
    }

    // Actualizar un libro
    public function updateBook($id, $title, $price, $in_stock, $rating, $image_url, $description, $genre)
    {
        // Validar que el ID sea un número y que todos los campos estén presentes
        if (!is_numeric($id) || empty($title) || empty($price) || empty($in_stock) || empty($rating) || empty($image_url) || empty($description) || empty($genre)) {
            return false;
        }

        $stmt = $this->pdo->prepare("UPDATE books SET title = ?, price = ?, in_stock = ?, rating = ?, image_url = ?, description = ?, genre = ? WHERE id = ?");
        return $stmt->execute([$title, $price, $in_stock, $rating, $image_url, $description, $genre, $id]);
    }

    // Eliminar un libro
    public function deleteBook($id)
    {
        // Validar que el ID sea un número
        if (!is_numeric($id)) {
            return false;
        }

        $stmt = $this->pdo->prepare("DELETE FROM books WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Obtener un usuario por ID
    public function getUserById($id)
    {
        // Validar que el ID sea un número
        if (!is_numeric($id)) {
            return null;
        }

        // Consulta para obtener los datos del usuario
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        if (!$stmt->execute([$id])) {
            return null; // Si hay un error en la ejecución, retornar null
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}