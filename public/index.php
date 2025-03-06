<?php

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/views/';
$apiPrefix = '/api/';

if (strpos($request, $apiPrefix) === 0) {
    // Rutas de la API
    require __DIR__ . '/src/controllers/ApiController.php';
    $ProjectController = new ProjectController();

    switch ($request) {
        case '/api/books':
            echo json_encode(["message" => "Funciona correctamente"]);
            break;

        default:
            header("HTTP/1.0 404 Not Found");
            echo json_encode(["error" => "Ruta de API no encontrada"]);
            break;
    }
} else {
    // Rutas de vistas
    $path = parse_url($request, PHP_URL_PATH);
    switch ($path) {
        case '':
        case '/':
            require __DIR__ . $viewDir . 'home.php';
            break;

        case '/login':
            require __DIR__ . $viewDir . 'login.php';
            break;

        case '/register':
            require __DIR__ . $viewDir . 'register.php';
            break;

        case '/dashboard':      
            require __DIR__ . $viewDir . 'dashboard.php';
            break;  
            
        case '/about':    
            require __DIR__ . $viewDir . 'about.php';
            break;
            
        case '/faq':
            require __DIR__ . $viewDir . 'faq.php';
            break;
            
        case '/profile':
            require __DIR__ . $viewDir . 'profile.php';
            break;  

        case '/logout':
            require __DIR__ . $viewDir . 'logout.php';
            break;

        case '/catalog':
            require __DIR__ . $viewDir . 'catalog.php';
            break;

        case '/book_details.php':
            require __DIR__ . $viewDir . 'book_details.php';
            break;

        default:
            require __DIR__ . $viewDir . '404.php';
            break;
    }
}
?>