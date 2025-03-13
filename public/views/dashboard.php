<?php
$page_title = "Dashboard";

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <!-- Grid de 2 columnas -->
        <div class="row">
            <!-- Primera columna: Libros por género -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Libros por género</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartGeneros" style="min-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Segunda columna: Distribución de stock -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Distribución de stock</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartStock" style="min-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Tercera columna: Libros mejor valorados -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Libros mejor valorados</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartRating" style="min-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Cuarta columna: Precio promedio por género -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Precio promedio por género</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartPrecioGenero" style="min-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de Administración -->
        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Panel de Administración</h2>
                <div class="card">
                    <div class="card-header">
                        <h5>Gestión de Libros</h5>
                    </div>
                    <div class="card-body">
                        <!-- Formulario para añadir libros -->
                        <form>
                            <div class="row"> <!-- Fila para organizar los campos en columnas -->
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="title">Título del Libro</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="price">Precio</label>
                                        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="in_stock">En stock</label>
                                        <select class="form-control" id="in_stock" name="in_stock" required>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="rating">Rating</label>
                                        <input type="text" class="form-control" id="rating" name="rating" required>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="image_url">URL de la imagen</label>
                                        <input type="url" class="form-control" id="image_url" name="image_url" required>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="genre">Género</label>
                                        <input type="text" class="form-control" id="genre" name="genre" required>
                                    </div>
                                </div>
                            </div>
                            <!-- Descripción (ocupa toda la fila) -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <label for="description">Descripción</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- Botón de submit -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary">Añadir Libro</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Tabla para listar libros -->
                        <div class="table-responsive"> <!-- Hace que la tabla sea responsive -->
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Título</th>
                                        <th>Precio</th>
                                        <th>En stock</th>
                                        <th>Rating</th>
                                        <th>Imagen</th>
                                        <th>Descripción</th>
                                        <th>Género</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ejemplo de filas de libros -->
                                    <tr>
                                        <td>1</td>
                                        <td>El Principito</td>
                                        <td>$15.99</td>
                                        <td>Sí</td>
                                        <td>Four</td>
                                        <td><img src="https://example.com/image1.jpg" alt="El Principito" class="img-fluid" style="max-width: 50px;"></td>
                                        <td>Un clásico de la literatura infantil.</td>
                                        <td>Ficción</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning">Editar</button>
                                            <button class="btn btn-sm btn-danger">Eliminar</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Cien Años de Soledad</td>
                                        <td>$20.50</td>
                                        <td>No</td>
                                        <td>Five</td>
                                        <td><img src="https://example.com/image2.jpg" alt="Cien Años de Soledad" class="img-fluid" style="max-width: 50px;"></td>
                                        <td>Una obra maestra del realismo mágico.</td>
                                        <td>Realismo Mágico</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning">Editar</button>
                                            <button class="btn btn-sm btn-danger">Eliminar</button>
                                        </td>
                                    </tr>
                                    <!-- Puedes agregar más filas aquí -->
                                </tbody>
                            </table>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir Chart.js desde un CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    //Funcion para eliminar un libro
    function deleteBook(bookId) {
        if (confirm('¿Estás seguro de que deseas eliminar este libro?')) {
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
                        alert('Libro eliminado correctamente');
                        location.reload(); // Recargar la página para actualizar la lista de libros
                    } else {
                        alert('Error al eliminar el libro: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error al eliminar el libro:', error);
                    alert('Error al eliminar el libro');
                });
        }
    }

    //Recoger libros para mostrarlos en la fila.
    async function fetchBooks() {
        try {
            const response = await fetch('/api/books-dashboard');
            if (!response.ok) {
                throw new Error("Error al obtener los datos de la API");
            }
            const books = await response.json();
            const tbody = document.getElementById('books-table-body');
            tbody.innerHTML = ''; // Limpiar el contenido existente

            books.forEach(book => {
                const row = document.createElement('tr');
                row.innerHTML = `
                        <td>${book.id}</td>
                        <td>${book.title}</td>
                        <td>${book.price}</td>
                        <td>${book.in_stock ? 'Sí' : 'No'}</td>
                        <td>${book.rating}</td>
                        <td><img src="${book.image_url}" alt="${book.title}" class="img-fluid" style="max-width: 50px;"></td>
                        <td>${book.description}</td>
                        <td>${book.genre}</td>
                        <td>
                            <button class="btn btn-sm btn-warning">Editar</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteBook(${book.id})">Eliminar</button>
                        </td>
                    `;
                tbody.appendChild(row);
            });
        } catch (error) {
            console.error("Error:", error);
        }
    }

    // Función para convertir el rating de texto a número
    function convertirRatingATexto(rating) {
        const ratingMap = {
            "One": 1,
            "Two": 2,
            "Three": 3,
            "Four": 4,
            "Five": 5
        };
        return ratingMap[rating] || 0; // Si no existe, devuelve 0
    }

    // Función para obtener datos de la API
    async function fetchData() {
        try {
            const response = await fetch('/api/books-dashboard'); // Se usa esta y no /api/books por problemas por la paginación
            if (!response.ok) {
                throw new Error("Error al obtener los datos de la API");
            }
            return await response.json();
        } catch (error) {
            console.error("Error:", error);
            return [];
        }
    }

    // Función para crear un gráfico de barras
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
                responsive: true, // Asegura que el gráfico sea responsive
                maintainAspectRatio: false, // Permite ajustar el tamaño
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Función para crear un gráfico de pastel
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
                responsive: true, // Asegura que el gráfico sea responsive
                maintainAspectRatio: false // Permite ajustar el tamaño
            }
        });
    }

    // Función principal para cargar los gráficos
    async function loadCharts() {
        const data = await fetchData();
        console.log("Datos recibidos de la API:", data);

        // Gráfico 1: Libros por género (Pie Chart)
        const librosPorGenero = {};
        data.forEach(libro => {
            librosPorGenero[libro.genre] = (librosPorGenero[libro.genre] || 0) + 1;
        });
        console.log("Libros por género:", librosPorGenero);

        createPieChart(
            document.getElementById('chartGeneros').getContext('2d'),
            Object.keys(librosPorGenero), // Géneros
            Object.values(librosPorGenero), // Cantidad de libros por género
            'Libros por género'
        );

        // Gráfico 2: Distribución de stock
        const librosEnStock = data.filter(libro => libro.in_stock).length;
        const librosAgotados = data.length - librosEnStock;
        console.log("Distribución de stock:", librosEnStock, librosAgotados);

        createPieChart(
            document.getElementById('chartStock').getContext('2d'),
            ['En stock', 'Agotados'],
            [librosEnStock, librosAgotados],
            'Distribución de stock'
        );

        // Gráfico 3: Libros mejor valorados (top 5)
        const librosMejorValorados = data
            .map(libro => {
                // Convertir el rating de texto a número
                const ratingNumerico = convertirRatingATexto(libro.rating);
                return {
                    ...libro,
                    rating: ratingNumerico
                };
            })
            .sort((a, b) => b.rating - a.rating) // Ordenar por rating descendente
            .slice(0, 5); // Tomar los primeros 5

        console.log("Libros mejor valorados:", librosMejorValorados);

        // Extraer los títulos y los ratings de los libros mejor valorados
        const labels = librosMejorValorados.map(libro => libro.title);
        const ratings = librosMejorValorados.map(libro => libro.rating);

        console.log("Labels (títulos):", labels);
        console.log("Data (ratings):", ratings);

        // Verifica que el elemento del DOM existe
        const chartRatingElement = document.getElementById('chartRating');
        if (chartRatingElement) {
            console.log("Elemento 'chartRating' encontrado.");
            createBarChart(
                chartRatingElement.getContext('2d'),
                labels,
                ratings,
                'Rating'
            );
        } else {
            console.error("El elemento del gráfico 'chartRating' no existe.");
        }

        // Gráfico 4: Precio promedio por género
        const precioPorGenero = {};
        data.forEach(libro => {
            // Limpiar el precio: eliminar el símbolo de la libra (£) y convertir a número
            const precioLimpio = parseFloat(libro.price.replace(/[^0-9.]/g, ''));

            if (!isNaN(precioLimpio)) { // Solo procesar si el precio es un número válido
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
            'Precio promedio'
        );
    }

    // Cargar los gráficos cuando la página esté lista
    document.addEventListener('DOMContentLoaded', loadCharts);
</script>

<?php include(__DIR__ . '/../includes/footer.php'); ?>