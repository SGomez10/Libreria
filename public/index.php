<?php

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/views/';
$apiPrefix = '/api/';

if (strpos($request, $apiPrefix) === 0) {
    // Rutas de la API
    require __DIR__ . '/src/controllers/ProjectController.php';
    $ProjectController = new ProjectController();

    // Elimina el prefijo de la API
    $route = substr($request, strlen($apiPrefix));

    // Divide la ruta en partes
    $parts = explode('/', $route);

    // Manejo de rutas de la API
    if ($parts[0] === 'books') {
        if (isset($parts[1])) {
            if (is_numeric($parts[1])) {
                // Ruta: /api/books/{id}
                $book_id = (int)$parts[1];
                $book = $ProjectController->getBookById($book_id);
                if ($book) {
                    echo json_encode($book);
                } else {
                    header("HTTP/1.0 404 Not Found");
                    echo json_encode(["message" => "Libro no encontrado"]);
                }
            } elseif ($parts[1] === 'genre' && isset($parts[2])) {
                // Ruta: /api/books/genre/{genre}
                $genre = urldecode($parts[2]);
                $books = $ProjectController->getBooks(1, 10, $genre);
                echo json_encode($books);
            } else {
                // Ruta no válida
                header("HTTP/1.0 404 Not Found");
                echo json_encode(["error" => "Ruta de API no encontrada"]);
            }
        } else {
            // Ruta: /api/books
            echo json_encode($ProjectController->getBooks());
        }
    } elseif ($parts[0] === 'books-dashboard') {
        // Ruta: /api/books-dashboard
        $books = $ProjectController->getBooksForDashboard();
        echo json_encode($books);
    } elseif ($parts[0] === 'search-books') {
        // Ruta: /api/search-books
        if (isset($_GET['query'])) {
            $query = $_GET['query'];

            // Primero, obtener todos los libros usando getBooksForDashboard
            $allBooks = $ProjectController->getBooksForDashboard();

            // Luego, aplicar la búsqueda solo en el campo "title"
            $filteredBooks = array_filter($allBooks, function ($book) use ($query) {
                // Buscar solo en el título
                return stripos($book['title'], $query) !== false;
            });

            // Retornar los libros filtrados
            echo json_encode(array_values($filteredBooks)); // Reindexar el array
        } else {
            // Si no se proporciona una consulta, retornar un array vacío
            echo json_encode([]);
        }
    } elseif ($parts[0] === 'user') {
        if (isset($parts[1]) && is_numeric($parts[1])) {
            // Ruta: /api/user/{id}
            $user_id = (int)$parts[1];
            $user = $ProjectController->getUserById($user_id);
            if ($user) {
                echo json_encode($user);
            } else {
                header("HTTP/1.0 404 Not Found");
                echo json_encode(["message" => "Usuario no encontrado"]);
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
                include(__DIR__ . '/views/profile.php');
                break;
            default:
                include(__DIR__ . '/views/home.php');
                break;
        }
    }
}
