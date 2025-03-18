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

$page_title = _("Catálogo");
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

require_once(__DIR__ . '/../src/controllers/ProjectController.php');
$controller = new ProjectController();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', $path);

$selectedGenre = '';
$current_page = 1;

if ($pathParts[1] === 'catalog') {
    if (isset($pathParts[2]) && $pathParts[2] !== 'page') {
        $selectedGenre = urldecode($pathParts[2]);
    }
    if (isset($pathParts[3]) && $pathParts[3] === 'page' && isset($pathParts[4])) {
        $current_page = (int)$pathParts[4];
    } elseif (isset($pathParts[2]) && $pathParts[2] === 'page' && isset($pathParts[3])) {
        $current_page = (int)$pathParts[3];
    }
}

if (!empty($selectedGenre) && !$controller->isValidGenre($selectedGenre)) {
    echo "<div class='alert alert-warning'>" . _("El género seleccionado no existe.") . "</div>";
    $selectedGenre = '';
}

$per_page = 20;
$books = $controller->getBooks($current_page, $per_page, $selectedGenre);

$total_books = $controller->getTotalBooks($selectedGenre);
$total_pages = ceil($total_books / $per_page);

$current_page = max(1, min($current_page, $total_pages));

?>
<div class="container mt-5">
    <h1 class="mb-4"><?php echo _("Catálogo de Libros"); ?></h1>

    <form method="GET" action="">
        <div class="mb-3">
            <label for="genre" class="form-label"><?php echo _("Filtrar por género:"); ?></label>
            <select class="form-select w-auto" id="genre" name="genre" onchange="window.location.href = '/catalog/' + encodeURIComponent(this.value);">
                <option value=""><?php echo _("Todos los géneros"); ?></option>
                <?php
                $genres = $controller->getGenres();
                foreach ($genres as $genre): ?>
                    <option value="<?php echo htmlspecialchars($genre); ?>" <?php echo ($selectedGenre == $genre) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($genre); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3">
        <?php foreach ($books as $book): ?>
            <div class="col">
                <div class="card h-100 d-flex flex-column p-1">
                    <img src="<?php echo htmlspecialchars($book['image_url']); ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($book['title']); ?>">
                    <div class="card-body flex-grow-1 p-2">
                        <h5 class="card-title" style="font-size: 0.9rem;"><?php echo htmlspecialchars($book['title']); ?></h5>
                        <p class="card-text" style="font-size: 0.8rem;"><strong><?php echo _("Precio:"); ?></strong> <?php echo htmlspecialchars($book['price']); ?></p>
                    </div>
                    <div class="card-footer text-center border-0 p-1">
                        <a href="/book_details/<?php echo htmlspecialchars($book['id']); ?>" class="btn btn-primary btn-sm w-100 rounded-0"><?php echo _("Más información"); ?></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php if ($current_page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="/catalog/<?php echo !empty($selectedGenre) ? urlencode($selectedGenre) . '/' : ''; ?>page/<?php echo $current_page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php
            $start = max(1, $current_page - 2);
            $end = min($total_pages, $current_page + 2);

            for ($i = $start; $i <= $end; $i++): ?>
                <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                    <a class="page-link" href="/catalog/<?php echo !empty($selectedGenre) ? urlencode($selectedGenre) . '/' : ''; ?>page/<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="/catalog/<?php echo !empty($selectedGenre) ? urlencode($selectedGenre) . '/' : ''; ?>page/<?php echo $current_page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
<?php include(__DIR__ . '/../includes/footer.php'); ?>