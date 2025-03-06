<?php
// Obtener el ID del libro desde la URL
$book_id = isset($_GET['id']) ? $_GET['id'] : null;
$page_title = "Detalles del libro";

if ($book_id) {
    // Realizar una solicitud a la API para obtener los detalles del libro
    $api_url = "http://libreria.local/public/src/controllers/ApiController.php?id=" . $book_id;
    $response = file_get_contents($api_url);
    $book = json_decode($response, true);

    if (isset($book['message'])) {
        // Si hay un mensaje de error, mostrarlo
        echo "<p>" . htmlspecialchars($book['message']) . "</p>";
    } else {
        // Mostrar los detalles del libro
        include(__DIR__ . '/../includes/header.php');
        include(__DIR__ . '/../includes/navbar.php');
        ?>
        <div class="container mt-5">
            <h1><?php echo htmlspecialchars($book['title']); ?></h1>
            <img src="<?php echo htmlspecialchars($book['image_url']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" class="img-fluid">
            <p><strong>Precio:</strong> <?php echo htmlspecialchars($book['price']); ?></p>
            <p><strong>En stock:</strong> <?php echo htmlspecialchars($book['in_stock']); ?></p>
            <p><strong>Género:</strong> <?php echo htmlspecialchars($book['genre']); ?></p>
            <p><strong>Rating:</strong> <?php echo htmlspecialchars($book['rating']); ?></p>
            <p><strong>Descripción:</strong> <?php echo htmlspecialchars($book['description']); ?></p>
        </div>
        <?php
        include(__DIR__ . '/../includes/footer.php');
    }
} else {
    echo "<p>ID de libro no proporcionado.</p>";
}
?>