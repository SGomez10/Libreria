<?php
$page_title = "FAQ";

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="display-4">Preguntas Frecuentes</h1>
            <p class="lead">Encuentra respuestas a las preguntas más comunes sobre nuestra librería.</p>
        </div>
    </div>

    <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    ¿Cuál es el horario de la librería?
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Nuestro horario de atención es de lunes a viernes de 9:00 AM a 8:00 PM, y los sábados de 10:00 AM a 6:00 PM. Los domingos estamos cerrados.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    ¿Dónde está ubicada la librería?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Nos encontramos en la calle Principal #123, en el corazón de la ciudad.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    ¿Ofrecen descuentos para estudiantes?
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Sí, ofrecemos un descuento del 10% para estudiantes con una identificación válida.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    ¿Tienen servicio de entrega a domicilio?
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Sí, ofrecemos servicio de entrega a domicilio dentro de la ciudad. Los pedidos se pueden realizar en línea o por teléfono.
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../includes/footer.php'); ?>