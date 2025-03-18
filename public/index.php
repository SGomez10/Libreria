<?php

// Habilitar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/views/';
$apiPrefix = '/api/';

if (strpos($request, $apiPrefix) === 0) {
    // Rutas de la API
    require_once __DIR__ . '/src/controllers/ProjectController.php';
    $ProjectController = new ProjectController();

    // Elimina el prefijo de la API
    $route = substr($request, strlen($apiPrefix));

    // Divide la ruta en partes
    $parts = explode('/', $route);

    // Manejo de rutas de la API
    if ($parts[0] === 'books') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ruta: POST /api/books (agregar un libro)
            require_once __DIR__ . '/src/controllers/ApiController.php';
            $apiController = new ApiController();
            $apiController->handleRequest();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($parts[1]) && is_numeric($parts[1])) {
            // Ruta: PUT /api/books/{id} (actualizar un libro)
            require_once __DIR__ . '/src/controllers/ApiController.php';
            $apiController = new ApiController();
            $apiController->handleRequest();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($parts[1]) && is_numeric($parts[1])) {
            // Ruta: DELETE /api/books/{id}
            require_once __DIR__ . '/src/controllers/ApiController.php';
            $apiController = new ApiController();
            $apiController->handleRequest();
        } elseif (isset($parts[1])) {
            if (is_numeric($parts[1])) {
                // Ruta: GET /api/books/{id}
                $book_id = (int)$parts[1];
                $book = $ProjectController->getBookById($book_id);
                if ($book) {
                    echo json_encode($book);
                } else {
                    header("HTTP/1.0 404 Not Found");
                    echo json_encode(["message" => "Libro no encontrado"]);
                }
            } elseif ($parts[1] === 'genre' && isset($parts[2])) {
                // Ruta: GET /api/books/genre/{genre}
                $genre = urldecode($parts[2]);
                $books = $ProjectController->getBooks(1, 10, $genre);
                echo json_encode($books);
            } else {
                // Ruta no válida
                header("HTTP/1.0 404 Not Found");
                echo json_encode(["error" => "Ruta de API no encontrada"]);
            }
        } else {
            // Ruta: GET /api/books
            echo json_encode($ProjectController->getBooks());
        }
    } elseif ($parts[0] === 'books-dashboard') {
        // Ruta: GET /api/books-dashboard
        $books = $ProjectController->getBooksForDashboard();
        echo json_encode($books);
    } elseif ($parts[0] === 'user') {
        if (isset($parts[1]) && is_numeric($parts[1])) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                // Ruta: GET /api/user/{id}
                $user_id = (int)$parts[1];
                $user = $ProjectController->getUserById($user_id);
                if ($user) {
                    echo json_encode($user);
                } else {
                    header("HTTP/1.0 404 Not Found");
                    echo json_encode(["message" => "Usuario no encontrado"]);
                }
            } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                // Ruta: PUT /api/user/{id} (actualizar un usuario)
                require_once __DIR__ . '/src/controllers/ApiController.php';
                $apiController = new ApiController();
                $apiController->handleRequest();
            } else {
                // Ruta no válida
                header("HTTP/1.0 404 Not Found");
                echo json_encode(["error" => "Ruta de API no encontrada"]);
            }
        } else {
            // Ruta no válida
            header("HTTP/1.0 404 Not Found");
            echo json_encode(["error" => "Ruta de API no encontrada"]);
        }
    } else {
        // Ruta no válida
        header("HTTP/1.0 404 Not Found");
        echo json_encode(["error" => "Ruta de API no encontrada"]);
    }
} else {
    // Rutas de vistas
    $path = parse_url($request, PHP_URL_PATH);
    $pathParts = explode('/', $path);

    if ($pathParts[1] === 'catalog') {
        // Ruta: /catalog/{género}
        $selectedGenre = isset($pathParts[2]) ? urldecode($pathParts[2]) : '';
        include(__DIR__ . '/views/catalog.php');
    } elseif ($pathParts[1] === 'book_details' && isset($pathParts[2]) && is_numeric($pathParts[2])) {
        // Ruta: /book_details/{id}
        $book_id = (int)$pathParts[2];
        include(__DIR__ . '/views/book_details.php');
    } else {
        // Otras rutas de vistas
        switch ($path) {
            case '':
            case '/':
                include(__DIR__ . '/views/home.php');
                break;
            case '/about':
                include(__DIR__ . '/views/about.php');
                break;
            case '/contact':
                include(__DIR__ . '/views/contact.php');
                break;
            case '/dashboard':
                if (!isset($_SESSION['user_id'])) {
                    header("Location: /login");
                    exit();
                }
                include(__DIR__ . '/views/dashboard.php');
                break;
            case '/login':
                include(__DIR__ . '/views/login.php');
                break;
            case '/register':
                include(__DIR__ . '/views/register.php');
                break;
            case '/faq':
                include(__DIR__ . '/views/faq.php');
                break;
            case '/profile':
                if (!isset($_SESSION['user_id'])) {
                    header("Location: /login");
                    exit();
                }
                include(__DIR__ . '/views/profile.php');
                break;
            case '/info':
                include(__DIR__ . '/views/info.php');
                break;

            case '/logout':
                if (!isset($_SESSION['user_id'])) {
                    header("Location: /login");
                    exit();
                }
                require_once __DIR__ . '/views/logout.php';
                break;
                
            default:
                http_response_code(404);
                require __DIR__ . $viewDir . '404.php';
        }
    }
}
