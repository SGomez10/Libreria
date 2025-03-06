<?php
$page_title = "Catálogo";
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');

require_once(__DIR__ . '/../src/controllers/ProjectController.php');
$controller = new ProjectController();
$books = $controller->getBooks();

?>
<div class="container mt-5">
    <h1 class="mb-4">Catálogo de Libros</h1>
    <div class="row row-cols-1 row-cols-md-5 g-4">
        <?php foreach ($books as $book): ?>
            <div class="col">
                <div class="card h-100 d-flex flex-column">
                    <img src="<?php echo htmlspecialchars($book['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($book['title']); ?>">
                    <div class="card-body flex-grow-1">
                        <h5 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h5>
                        <p class="card-text"><strong>Precio:</strong> <?php echo htmlspecialchars($book['price']); ?></p>
                    </div>
                    <div class="card-footer text-center border-0 p-0">
                        <a href="book_details.php?id=<?php echo htmlspecialchars($book['id']); ?>" class="btn btn-primary w-100 rounded-0">Más información</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include(__DIR__ . '/../includes/footer.php'); ?>