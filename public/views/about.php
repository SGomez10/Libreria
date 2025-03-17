<?php
$page_title = _("Sobre Nosotros");

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="display-4"><?php echo _("Sobre Nosotros"); ?></h1>
            <p class="lead"><?php echo _("Conoce más sobre nuestra web, lo que hacemos, nuestra ubicación y horarios."); ?></p>
        </div>
    </div>

    <div class="row py-4">
        <div class="col-md-6">
            <h2><?php echo _("¿Qué hacemos?"); ?></h2>
            <p><?php echo _("En nuestra librería, nos dedicamos a ofrecer una amplia variedad de libros de diferentes géneros y autores. Nuestro objetivo es fomentar la lectura y proporcionar un espacio donde los amantes de los libros puedan encontrar sus títulos favoritos."); ?></p>
        </div>
        <div class="col-md-6">
            <img src="/assets/images/what-we-do.jpg" class="img-fluid" alt="<?php echo _("Qué hacemos"); ?>">
        </div>
    </div>

    <div class="row py-4">
        <div class="col-md-6">
            <iframe width="425" height="350" src="https://www.openstreetmap.org/export/embed.html?bbox=2.2065460681915288%2C41.45245911418524%2C2.210086584091187%2C41.45426436521504&amp;layer=mapnik" style="border: 1px solid black"></iframe><br /><small><a href="https://www.openstreetmap.org/#map=19/41.453362/2.208316"><?php echo _("Ver el mapa más grande"); ?></a></small>
        </div>
        <div class="col-md-6">
            <h2><?php echo _("Nuestra Ubicación"); ?></h2>
            <p><?php echo _("Nos encontramos en el corazón de la ciudad, en la calle Principal #123. Ven a visitarnos y descubre nuestro amplio catálogo de libros y eventos literarios."); ?></p>
        </div>
    </div>

    <div class="row py-4">
        <div class="col-md-6">
            <h2><?php echo _("Horarios"); ?></h2>
            <p><?php echo _("Nuestros horarios de atención son:"); ?></p>
            <ul>
                <li><?php echo _("Lunes a Viernes: 9:00 AM - 8:00 PM"); ?></li>
                <li><?php echo _("Sábado: 10:00 AM - 6:00 PM"); ?></li>
                <li><?php echo _("Domingo: Cerrado"); ?></li>
            </ul>
        </div>
        <div class="col-md-6">
            <img src="/assets/images/hours.jpg" class="img-fluid" alt="<?php echo _("Horarios"); ?>">
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../includes/footer.php'); ?>