<?php
// Guardar el idioma seleccionado en la sesión
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Establecer el idioma por defecto si no hay ninguno seleccionado
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'es_ES'; // Idioma por defecto
}

// Configurar el idioma en la aplicación
$locale = $_SESSION['lang'];
setlocale(LC_ALL, $locale);
bindtextdomain("messages", "./locale");
textdomain("messages");
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">B-612</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="<?php echo _("Toggle navigation"); ?>">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="/"><?php echo _("Inicio"); ?></a>
                </li>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/register"><?php echo _("Registrarse"); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login"><?php echo _("Iniciar sesión"); ?></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo _("Usuario"); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/profile.php"><?php echo _("Mi perfil"); ?></a></li>
                            <li><a class="dropdown-item" href="/dashboard"><?php echo _("Dashboard"); ?></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><?php echo _("Cerrar sesión"); ?></a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <!-- Selector de idiomas con banderas -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://flagcdn.com/w20/es.png" alt="<?php echo _("Español"); ?>" class="me-1" style="width: 20px; height: auto;"> <?php echo _("Español"); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                        <li>
                            <a class="dropdown-item" href="?lang=en_US">
                                <img src="https://flagcdn.com/w20/gb.png" alt="<?php echo _("English"); ?>" class="me-1" style="width: 20px; height: auto;"> <?php echo _("English"); ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="?lang=es_ES">
                                <img src="https://flagcdn.com/w20/es.png" alt="<?php echo _("Español"); ?>" class="me-1" style="width: 20px; height: auto;"> <?php echo _("Español"); ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Modal de confirmación de cierre de sesión -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel"><?php echo _("Confirmar cierre de sesión"); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo _("Close"); ?>"></button>
            </div>
            <div class="modal-body">
                <?php echo _("¿Estás seguro de que deseas cerrar la sesión?"); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo _("No"); ?></button>
                <button type="button" class="btn btn-primary" id="confirmLogout"><?php echo _("Sí"); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('confirmLogout').addEventListener('click', function() {
    window.location.href = '/logout'; 
});
</script>