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

$page_title = _("No encontrado");
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>

<div class="container py-5 text-center">
    <h1 class="display-4 fw-bold"><?php echo _("404 - Página no encontrada"); ?></h1> 
    <p class="lead mb-4"><?php echo _("Lo sentimos, la página que estás buscando no existe."); ?></p> 
    <a href="/" class="btn btn-primary btn-lg px-4"><?php echo _("Volver al inicio"); ?></a> 
</div>

<?php include(__DIR__ . '/../includes/footer.php'); ?>