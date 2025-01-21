<?php
$page_title="Login Form";
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h5>Inicio de sesión</h5>
                    </div>
                    <div class="card-body">

                        <form action="../src/controllers/SessionController.php" method="POST">
                            <div class="form-group mb-3">
                                <label for=" ">Correo electrónico</label>
                                <input type="text" name="email" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for=" ">Contraseña</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" name ="login_btn" class="btn btn-primary">Iniciar sesión</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include(__DIR__ . '/../includes/footer.php'); ?>