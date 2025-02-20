<?php
require 'ProjectController.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$controller = new ProjectController();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "GET":
        if (isset($_GET['id'])) {
            $book = $controller->getBookById($_GET['id']);
            echo json_encode($book ? $book : ["message" => "Libro no encontrado"]);
        } else {
            echo json_encode($controller->getBooks());
        }
        break;

    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['title'], $data['price'], $data['in_stock'], $data['rating'], $data['image_url'], $data['description'], $data['genre'])) {
            if ($controller->addBook($data['title'], $data['price'], $data['in_stock'], $data['rating'], $data['image_url'], $data['description'], $data['genre'])) {
                echo json_encode(["message" => "Libro agregado correctamente"]);
            } else {
                echo json_encode(["message" => "Error al agregar el libro"]);
            }
        } else {
            echo json_encode(["message" => "Datos incompletos"]);
        }
        break;

    case "PUT":
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id'], $data['title'], $data['price'], $data['in_stock'], $data['rating'], $data['image_url'], $data['description'], $data['genre'])) {
            if ($controller->updateBook($data['id'], $data['title'], $data['price'], $data['in_stock'], $data['rating'], $data['image_url'], $data['description'], $data['genre'])) {
                echo json_encode(["message" => "Libro actualizado correctamente"]);
            } else {
                echo json_encode(["message" => "Error al actualizar el libro"]);
            }
        } else {
            echo json_encode(["message" => "Datos incompletos"]);
        }
        break;

    case "DELETE":
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id'])) {
            if ($controller->deleteBook($data['id'])) {
                echo json_encode(["message" => "Libro eliminado correctamente"]);
            } else {
                echo json_encode(["message" => "Error al eliminar el libro"]);
            }
        } else {
            echo json_encode(["message" => "ID no proporcionado"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Método no permitido"]);
        break;
}
?>