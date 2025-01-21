<?php
$page_title="Register Form";

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h5>Registro de usuario</h5>
                    </div>
                    <div class="card-body">
                    <?php
                        if (isset($_SESSION['status'])) {
                            echo '<div class="alert alert-warning">' . $_SESSION['status'] . '</div>';
                            unset($_SESSION['status']);
                        }
                        ?>
                        <p>Por favor, complete el siguiente formulario para registrarse en nuestra web.</p> 
                        <form action="/src/controllers/SessionController.php" method="POST">
                            <div class="form-group mb-3">
                                <label for=" ">Nombre</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for=" ">Apellido</label>
                                <input type="text" name="surname" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for=" ">Teléfono</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for=" ">Correo electrónico</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for=" ">Contraseña</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for=" ">Confirmar contraseña</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="register_btn" class="btn btn-primary">Registrarse</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../includes/footer.php'); ?>