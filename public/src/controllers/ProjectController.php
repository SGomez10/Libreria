<?php
require 'DatabaseController.php';

class ProjectController {
    
    private $pdo;

    public function __construct() {
        $this->pdo = DatabaseController::connect();
        if (!$this->pdo) {
            die("Error al conectar con la base de datos.");
        }
    }

    // Obtener todos los libros
    public function getBooks() {
        $stmt = $this->pdo->query("SELECT * FROM books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un libro por ID
    public function getBookById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Agregar un nuevo libro
    public function addBook($title, $price, $in_stock, $rating, $image_url, $description, $genre) {
        $stmt = $this->pdo->prepare("INSERT INTO books (title, price, in_stock, rating, image_url, description, genre) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$title, $price, $in_stock, $rating, $image_url, $description, $genre]);
    }

    // Actualizar un libro
    public function updateBook($id, $title, $price, $in_stock, $rating, $image_url, $description, $genre) {
        $stmt = $this->pdo->prepare("UPDATE books SET title = ?, price = ?, in_stock = ?, rating = ?, image_url = ?, description = ?, genre = ? WHERE id = ?");
        return $stmt->execute([$title, $price, $in_stock, $rating, $image_url, $description, $genre, $id]);
    }

    // Eliminar un libro
    public function deleteBook($id) {
        $stmt = $this->pdo->prepare("DELETE FROM books WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

// Instancia del controlador
$controller = new ProjectController();
?>