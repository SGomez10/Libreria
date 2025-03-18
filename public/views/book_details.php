<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

// Obtener el ID del libro desde la URL amigable
$request_uri = $_SERVER['REQUEST_URI']; // Obtiene la ruta completa (por ejemplo, "/book_details/123")
$pattern = '/^\/book_details\/(\d+)$/'; // Expresión regular para extraer el ID
preg_match($pattern, $request_uri, $matches); // Busca el ID en la ruta

$book_id = $matches[1] ?? null; // Extrae el ID o asigna null si no se encuentra
$page_title = "Detalles del libro";

if ($book_id) {
    // Mostrar los detalles del libro
    include(__DIR__ . '/../includes/header.php');
    include(__DIR__ . '/../includes/navbar.php');
    ?>
    <div id="book-details" class="container mt-5">
        <!-- Primera fila: Imagen y detalles -->
        <div class="row">
            <div class="col-md-4 text-center">
                <img id="book-image" src="" alt="" class="img-fluid mb-3" style="max-width: 100%; height: auto;">
            </div>
            <div class="col-md-8">
                <h1 id="book-title" class="mb-3"></h1>
                <div class="mb-3">
                    <p><strong>Género:</strong> <span id="book-genre" class="badge bg-secondary"></span></p>
                    <p><strong>Rating:</strong> <span id="book-rating" class="badge bg-warning text-dark"></span></p>
                    <p><strong>Precio:</strong> <span id="book-price" class="text-success h4"></span></p>
                    <p><strong>En stock:</strong> <span id="book-stock" class="badge bg-success"></span></p>
                </div>
            </div>
        </div>

        <!-- Segunda fila: Descripción -->
        <div class="row mt-4">
            <div class="col-12">
                <h4>Descripción:</h4>
                <p id="book-description" class="text-muted"></p>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookId = <?php echo json_encode($book_id); ?>;
        if (bookId) {
            fetch(`/api/books/${bookId}`)
                .then(response => response.json())
                .then(book => {
                    if (book) {
                        document.getElementById('book-title').textContent = book.title;
                        document.getElementById('book-image').src = book.image_url;
                        document.getElementById('book-image').alt = book.title;
                        document.getElementById('book-genre').textContent = book.genre;
                        document.getElementById('book-rating').textContent = book.rating;
                        document.getElementById('book-price').textContent = `$${book.price}`;
                        document.getElementById('book-stock').textContent = book.in_stock ? 'Disponible' : 'Agotado';
                        document.getElementById('book-description').textContent = book.description;
                    } else {
                        document.getElementById('book-details').innerHTML = '<p class="text-danger">Libro no encontrado.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error al obtener los detalles del libro:', error);
                    document.getElementById('book-details').innerHTML = '<p class="text-danger">Error al obtener los detalles del libro.</p>';
                });
        } else {
            document.getElementById('book-details').innerHTML = '<p class="text-danger">ID de libro no proporcionado.</p>';
        }
    });
    </script>
    <?php
    include(__DIR__ . '/../includes/footer.php');
}
?>