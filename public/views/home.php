<?php
$page_title = "Home Page";
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>

<div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <div class="col-10 col-sm-8 col-lg-6">
            <img src="https://images.pexels.com/photos/256559/pexels-photo-256559.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
        </div>
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold lh-1 mb-3">Bienvenido a B-612</h1>
            <p class="lead">La mejor plataforma para encontrar y compartir libros.</p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <a href="/login" class="btn btn-primary btn-lg px-4 me-md-2">Iniciar sesión</a>
                <a href="/register" class="btn btn-outline-secondary btn-lg px-4">Registrarme</a>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <h2>Explora</h2>
            <p>Descubre una amplia variedad de libros en nuestra plataforma.</p>
        </div>
        <div class="col-md-4">
            <h2>Comparte</h2>
            <p>Comparte tus libros favoritos con otros usuarios.</p>
        </div>
        <div class="col-md-4">
            <h2>Conéctate</h2>
            <p>Únete a una comunidad de amantes de los libros.</p>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../includes/footer.php'); ?>