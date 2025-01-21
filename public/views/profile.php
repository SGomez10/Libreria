<?php
session_start();
$page_title = "User Profile";

if (!isset($_SESSION['user_id'])) {
    $_SESSION['status'] = "Debes iniciar sesión para acceder a esta página";
    header('Location: /login.php');
    exit();
}

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

// Conectar a la base de datos y obtener los datos del usuario
require_once('../controllers/DatabaseController.php');
$connection = DatabaseController::connect();

$user_id = $_SESSION['user_id'];
$sql = "SELECT name, surname, phone, email FROM usuarios WHERE id = :id";
$statement = $connection->prepare($sql);
$statement->bindValue(':id', $user_id);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_OBJ);
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Perfil de Usuario</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group mb-3">
                            <label for="name">Nombre</label>
                            <input type="text" id="name" class="form-control" value="<?php echo htmlspecialchars($user->name); ?>" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="surname">Apellido</label>
                            <input type="text" id="surname" class="form-control" value="<?php echo htmlspecialchars($user->surname); ?>" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone">Teléfono</label>
                            <input type="text" id="phone" class="form-control" value="<?php echo htmlspecialchars($user->phone); ?>" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Correo electrónico</label>
                            <input type="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user->email); ?>" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <a href="/edit_profile.php" class="btn btn-primary">Cambiar datos</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../includes/footer.php'); ?>