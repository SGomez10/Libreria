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

$page_title = _("FAQ");

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="display-4"><?php echo _("Preguntas Frecuentes"); ?></h1>
            <p class="lead"><?php echo _("Encuentra respuestas a las preguntas más comunes sobre nuestra librería."); ?></p>
        </div>
    </div>

    <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <?php echo _("¿Cuál es el horario de la librería?"); ?>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <?php echo _("Nuestro horario de atención es de lunes a viernes de 9:00 AM a 8:00 PM, y los sábados de 10:00 AM a 6:00 PM. Los domingos estamos cerrados."); ?>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <?php echo _("¿Dónde está ubicada la librería?"); ?>
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <?php echo _("Nos encontramos en la calle Principal #123, en el corazón de la ciudad."); ?>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <?php echo _("¿Ofrecen descuentos para estudiantes?"); ?>
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <?php echo _("Sí, ofrecemos un descuento del 10% para estudiantes con una identificación válida."); ?>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    <?php echo _("¿Tienen servicio de entrega a domicilio?"); ?>
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <?php echo _("Sí, ofrecemos servicio de entrega a domicilio dentro de la ciudad. Los pedidos se pueden realizar en línea o por teléfono."); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../includes/footer.php'); ?>