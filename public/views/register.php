<?php

// Obtener el idioma seleccionado de la URL, si está presente
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang']; // Guardar el idioma en la sesión
}

// Usar el idioma de la sesión o el predeterminado si no está configurado
$locale = isset($_SESSION['lang']) ? $_SESSION['lang'] . '.UTF-8' : 'en_US.UTF-8';

// Configura el locale y el dominio de traducción
putenv("LANG=$locale");
putenv("LANGUAGE=$locale");
setlocale(LC_ALL, $locale);
$domain = 'messages';
textdomain($domain);

// Verificar la ruta de traducciones
$ruta = realpath(__DIR__ . '/../../locales');
if ($ruta === false) {
    error_log("Error: No se pudo encontrar la carpeta 'locales'.");
} else {
    bindtextdomain($domain, $ruta);
    error_log("Ruta de traducciones configurada: " . $ruta);
}
bind_textdomain_codeset($domain, 'UTF-8');

$page_title = _("Formulario de registro"); 

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h5><?php echo _("Registro de usuario"); ?></h5> 
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_SESSION['status'])) {
                            echo '<div class="alert alert-warning">' . $_SESSION['status'] . '</div>';
                            unset($_SESSION['status']);
                        }
                        ?>
                        <p><?php echo _("Por favor, complete el siguiente formulario para registrarse en nuestra web."); ?></p> <!-- Mensaje traducible -->
                        <form action="/src/controllers/SessionController.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="name"><?php echo _("Nombre"); ?></label> 
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="surname"><?php echo _("Apellido"); ?></label> 
                                <input type="text" name="surname" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="phone"><?php echo _("Teléfono"); ?></label> 
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email"><?php echo _("Correo electrónico"); ?></label> 
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password"><?php echo _("Contraseña"); ?></label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="confirm_password"><?php echo _("Confirmar contraseña"); ?></label> 
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="register_btn" class="btn btn-primary"><?php echo _("Registrarse"); ?></button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../includes/footer.php'); ?>