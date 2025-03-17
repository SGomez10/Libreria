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

$page_title = _("Dashboard");

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><?php echo _("Libros por género"); ?></h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartGeneros" style="min-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><?php echo _("Distribución de stock"); ?></h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartStock" style="min-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><?php echo _("Libros mejor valorados"); ?></h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartRating" style="min-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><?php echo _("Precio promedio por género"); ?></h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartPrecioGenero" style="min-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <h2><?php echo _("Panel de Administración"); ?></h2>
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo _("Gestión de Libros"); ?></h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="title"><?php echo _("Título del Libro"); ?></label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="price"><?php echo _("Precio"); ?></label>
                                        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="in_stock"><?php echo _("En stock"); ?></label>
                                        <select class="form-control" id="in_stock" name="in_stock" required>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="rating"><?php echo _("Rating"); ?></label>
                                        <input type="text" class="form-control" id="rating" name="rating" required>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="image_url"><?php echo _("URL de la imagen"); ?></label>
                                        <input type="url" class="form-control" id="image_url" name="image_url" required>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="genre"><?php echo _("Género"); ?></label>
                                        <input type="text" class="form-control" id="genre" name="genre" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <label for="description"><?php echo _("Descripción"); ?></label>
                                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary"><?php echo _("Añadir Libro"); ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo _("Lista de Libros"); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="<?php echo _("Buscar libro por su nombre"); ?>" aria-label="Buscar" id="search-input">
                                <button class="btn btn-outline-success" type="button" id="search-button"><?php echo _("Buscar"); ?></button>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th style="max-width: 200px;"><?php echo _("Título"); ?></th>
                                        <th><?php echo _("Precio"); ?></th>
                                        <th><?php echo _("En stock"); ?></th>
                                        <th><?php echo _("Rating"); ?></th>
                                        <th><?php echo _("Imagen"); ?></th>
                                        <th><?php echo _("Descripción"); ?></th>
                                        <th><?php echo _("Género"); ?></th>
                                        <th><?php echo _("Acciones"); ?></th>
                                    </tr>
                                </thead>
                                <tbody id="books-table-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('search-button').addEventListener('click', async function() {
            const query = document.getElementById('search-input').value;
            if (query.trim() === "") {
                alert("<?php echo _("Por favor, ingresa un término de búsqueda."); ?>");
                return;
            }

            try {
                const response = await fetch(`/api/search-books?query=${encodeURIComponent(query)}`);
                if (!response.ok) {
                    throw new Error('Error en la solicitud');
                }
                const books = await response.json();
                const tbody = document.getElementById('books-table-body');
                tbody.innerHTML = '';

                if (books.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="9"><?php echo _("No se encontraron libros."); ?></td></tr>`;
                    return;
                }

                books.forEach(book => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${book.id}</td>
                        <td>
                            <div class="title-box" style="max-height: 5em; overflow-y: auto; max-width: 200px;">
                                ${book.title}
                            </div>
                        </td>
                        <td>${book.price}</td>
                        <td>${book.in_stock ? '<?php echo _("Sí"); ?>' : '<?php echo _("No"); ?>'}</td>
                        <td>${book.rating}</td>
                        <td><img src="${book.image_url}" alt="${book.title}" class="img-fluid" style="max-width: 50px;"></td>
                        <td>
                            <div class="description-box" style="max-height: 5em; overflow-y: auto;">
                                ${book.description}
                            </div>
                        </td>
                        <td>${book.genre}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-warning w-100 d-flex justify-content-center align-items-center"><?php echo _("Editar"); ?></button>
                                <button class="btn btn-sm btn-danger w-100 d-flex justify-content-center align-items-center" onclick="deleteBook(${book.id})"><?php echo _("Eliminar"); ?></button>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            } catch (error) {
                console.error('Error:', error);
                alert('<?php echo _("Hubo un error al realizar la búsqueda"); ?>');
            }
        });
    });

    function deleteBook(bookId) {
        if (confirm('<?php echo _("¿Estás seguro de que deseas eliminar este libro?"); ?>')) {
            fetch(`/api/books/${bookId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: bookId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Libro eliminado correctamente') {
                        alert('<?php echo _("Libro eliminado correctamente"); ?>');
                        location.reload();
                    } else {
                        alert('<?php echo _("Error al eliminar el libro:"); ?> ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error al eliminar el libro:', error);
                    alert('<?php echo _("Error al eliminar el libro"); ?>');
                });
        }
    }

    function convertirRatingATexto(rating) {
        const ratingMap = {
            "One": 1,
            "Two": 2,
            "Three": 3,
            "Four": 4,
            "Five": 5
        };
        return ratingMap[rating] || 0;
    }

    async function fetchData() {
        try {
            const response = await fetch('/api/books-dashboard');
            if (!response.ok) {
                throw new Error("Error al obtener los datos de la API");
            }
            const books = await response.json();
            const tbody = document.getElementById('books-table-body');
            tbody.innerHTML = '';

            books.forEach(book => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${book.id}</td>
                    <td>
                        <div class="title-box" style="max-height: 5em; overflow-y: auto; max-width: 200px;">
                            ${book.title}
                        </div>
                    </td>
                    <td>${book.price}</td>
                    <td>${book.in_stock ? '<?php echo _("Sí"); ?>' : '<?php echo _("No"); ?>'}</td>
                    <td>${book.rating}</td>
                    <td><img src="${book.image_url}" alt="${book.title}" class="img-fluid" style="max-width: 50px;"></td>
                    <td>
                        <div class="description-box" style="max-height: 5em; overflow-y: auto;">
                            ${book.description}
                        </div>
                    </td>
                    <td>${book.genre}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-warning w-100 d-flex justify-content-center align-items-center"><?php echo _("Editar"); ?></button>
                            <button class="btn btn-sm btn-danger w-100 d-flex justify-content-center align-items-center" onclick="deleteBook(${book.id})"><?php echo _("Eliminar"); ?></button>
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });

            return books;
        } catch (error) {
            console.error("Error:", error);
            return [];
        }
    }

    function createBarChart(ctx, labels, data, label) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function createPieChart(ctx, labels, data, label) {
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    async function loadCharts() {
        const data = await fetchData();
        console.log("Datos recibidos de la API:", data);

        const librosPorGenero = {};
        data.forEach(libro => {
            librosPorGenero[libro.genre] = (librosPorGenero[libro.genre] || 0) + 1;
        });
        console.log("Libros por género:", librosPorGenero);

        createPieChart(
            document.getElementById('chartGeneros').getContext('2d'),
            Object.keys(librosPorGenero),
            Object.values(librosPorGenero),
            '<?php echo _("Libros por género"); ?>'
        );

        const librosEnStock = data.filter(libro => libro.in_stock).length;
        const librosAgotados = data.length - librosEnStock;
        console.log("Distribución de stock:", librosEnStock, librosAgotados);

        createPieChart(
            document.getElementById('chartStock').getContext('2d'),
            ['<?php echo _("En stock"); ?>', '<?php echo _("Agotados"); ?>'],
            [librosEnStock, librosAgotados],
            '<?php echo _("Distribución de stock"); ?>'
        );

        const librosMejorValorados = data
            .map(libro => {
                const ratingNumerico = convertirRatingATexto(libro.rating);
                return {
                    ...libro,
                    rating: ratingNumerico
                };
            })
            .sort((a, b) => b.rating - a.rating)
            .slice(0, 5);

        console.log("Libros mejor valorados:", librosMejorValorados);

        const labels = librosMejorValorados.map(libro => libro.title);
        const ratings = librosMejorValorados.map(libro => libro.rating);

        console.log("Labels (títulos):", labels);
        console.log("Data (ratings):", ratings);

        const chartRatingElement = document.getElementById('chartRating');
        if (chartRatingElement) {
            console.log("Elemento 'chartRating' encontrado.");
            createBarChart(
                chartRatingElement.getContext('2d'),
                labels,
                ratings,
                '<?php echo _("Rating"); ?>'
            );
        } else {
            console.error("El elemento del gráfico 'chartRating' no existe.");
        }

        const precioPorGenero = {};
        data.forEach(libro => {
            const precioLimpio = parseFloat(libro.price.replace(/[^0-9.]/g, ''));

            if (!isNaN(precioLimpio)) {
                if (!precioPorGenero[libro.genre]) {
                    precioPorGenero[libro.genre] = {
                        total: 0,
                        count: 0
                    };
                }
                precioPorGenero[libro.genre].total += precioLimpio;
                precioPorGenero[libro.genre].count++;
            }
        });

        const generosPrecio = Object.keys(precioPorGenero);
        const preciosPromedio = generosPrecio.map(genero =>
            (precioPorGenero[genero].total / precioPorGenero[genero].count).toFixed(2)
        );
        console.log("Precio promedio por género:", generosPrecio, preciosPromedio);

        createBarChart(
            document.getElementById('chartPrecioGenero').getContext('2d'),
            generosPrecio,
            preciosPromedio,
            '<?php echo _("Precio promedio"); ?>'
        );
    }

    document.addEventListener('DOMContentLoaded', loadCharts);
</script>

<?php include(__DIR__ . '/../includes/footer.php'); ?>