<?php

// Obtener el idioma seleccionado de la URL, si está presente
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang']; // Guardar el idioma en la sesión
}

// Usar el idioma de la sesión o el predeterminado si no está configurado
$locale = isset($_SESSION['lang']) ? $_SESSION['lang'] . '.UTF-8' : 'es_ES.UTF-8';

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


$page_title = _("Inicio"); 
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>

<div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <div class="col-10 col-sm-8 col-lg-6">
            <img src="https://images.pexels.com/photos/256559/pexels-photo-256559.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
        </div>
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold lh-1 mb-3"><?php echo _("Bienvenido a B-612"); ?></h1>
            <p class="lead"><?php echo _("La mejor plataforma para encontrar y compartir libros."); ?></p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <a href="/login" class="btn btn-primary btn-lg px-4 me-md-2"><?php echo _("Iniciar sesión"); ?></a>
                <a href="/register" class="btn btn-outline-secondary btn-lg px-4"><?php echo _("Registrarme"); ?></a>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <h2><?php echo _("Explora"); ?></h2>
            <p><?php echo _("Descubre una amplia variedad de libros en nuestra plataforma."); ?></p>
        </div>
        <div class="col-md-4">
            <h2><?php echo _("Comparte"); ?></h2>
            <p><?php echo _("Comparte tus libros favoritos con otros usuarios."); ?></p>
        </div>
        <div class="col-md-4">
            <h2><?php echo _("Conéctate"); ?></h2>
            <p><?php echo _("Únete a una comunidad de amantes de los libros."); ?></p>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../includes/footer.php'); ?>