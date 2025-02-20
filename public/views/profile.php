<?php
session_start();
$page_title = "Perfil de Usuario";

if (!isset($_SESSION['user_id'])) {
    $_SESSION['status'] = "Debes iniciar sesión para acceder a esta página";
    header('Location: /login.php');
    exit();
}

// Conectar a la base de datos y obtener los datos del usuario
require_once('../src/controllers/DatabaseController.php');
$connection = DatabaseController::connect();

$user_id = $_SESSION['user_id'];
$sql = "SELECT name, surname, phone, email FROM usuarios WHERE id = :id";
$statement = $connection->prepare($sql);
$statement->bindValue(':id', $user_id);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_OBJ);

// Inicializar Twig
require_once '../../vendor/autoload.php'; //Tengo que comprobar la ruta
$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);

// Renderizar la plantilla con los datos del usuario
echo $twig->render('userProfile.html.twig', ['page_title' => $page_title, 'user' => $user]);
?>
