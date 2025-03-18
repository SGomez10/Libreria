<?php

require_once __DIR__ . '/ProjectController.php';

class ApiController
{
    private $controller;

    public function __construct()
    {
        $this->controller = new ProjectController();
    }

    public function handleRequest()
    {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type");

        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case "GET":
                // La lógica GET ya se maneja en index.php
                http_response_code(405);
                echo json_encode(["message" => "Método GET no permitido directamente en ApiController"]);
                break;

            case "POST":
                $data = json_decode(file_get_contents("php://input"), true);
                if ($data === null) {
                    http_response_code(400); // Bad Request
                    echo json_encode(["message" => "JSON inválido"]);
                    break;
                }

                if (isset($data['title'], $data['price'], $data['in_stock'], $data['rating'], $data['image_url'], $data['description'], $data['genre'])) {
                    $result = $this->controller->addBook(
                        $data['title'],
                        $data['price'],
                        $data['in_stock'],
                        $data['rating'],
                        $data['image_url'],
                        $data['description'],
                        $data['genre']
                    );

                    if (strpos($result, "Error") === 0) {
                        http_response_code(400); // Bad Request
                        echo json_encode(["message" => $result]);
                    } else {
                        echo json_encode(["message" => $result]);
                    }
                } else {
                    http_response_code(400); // Bad Request
                    echo json_encode(["message" => "Datos incompletos"]);
                }
                break;

            case "PUT":
                $data = json_decode(file_get_contents("php://input"), true);
                if (isset($data['id'], $data['title'], $data['price'], $data['in_stock'], $data['rating'], $data['image_url'], $data['description'], $data['genre'])) {
                    if ($this->controller->updateBook($data['id'], $data['title'], $data['price'], $data['in_stock'], $data['rating'], $data['image_url'], $data['description'], $data['genre'])) {
                        http_response_code(200); // OK
                        echo json_encode(["message" => "Libro actualizado correctamente"]);
                    } else {
                        http_response_code(500); // Internal Server Error
                        echo json_encode(["message" => "Error al actualizar el libro"]);
                    }
                } else {
                    http_response_code(400); // Bad Request
                    echo json_encode(["message" => "Datos incompletos"]);                
                }
                break;

            case "DELETE":
                $data = json_decode(file_get_contents("php://input"), true);
                if (isset($data['id'])) {
                    $result = $this->controller->deleteBook($data['id']);
                    $response = json_decode($result, true);
                    if ($response && $response['message'] === "Libro eliminado correctamente") {
                        echo json_encode(["message" => "Libro eliminado correctamente"]);
                    } else {
                        http_response_code(400); // Bad Request
                        echo json_encode(["message" => "Error al eliminar el libro"]);
                    }
                } else {
                    http_response_code(400); // Bad Request
                    echo json_encode(["message" => "ID no proporcionado"]);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(["message" => "Método no permitido"]);
                break;
        }
    }
}
