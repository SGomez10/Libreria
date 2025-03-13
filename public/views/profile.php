<?php
// Iniciar la sesión (si no está iniciada)
session_start();

// Obtener el ID del usuario desde la sesión
$userID = $_SESSION['user_id'] ?? null; // Asegúrate de que el ID del usuario esté almacenado en la sesión

$page_title = "Perfil";
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Tu perfil</h4>
                    </div>
                    <div class="card-body">
                        <form id="profileForm">
                            <div class="form-group mb-3">
                                <label for="name">Nombre</label>
                                <input type="text" id="name" class="form-control" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label for="surname">Apellido</label>
                                <input type="text" id="surname" class="form-control" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label for="phone">Teléfono</label>
                                <input type="text" id="phone" class="form-control" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Correo electrónico</label>
                                <input type="email" id="email" class="form-control" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <a href="/edit_profile.php" class="btn btn-primary">Cambiar datos</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Obtener el ID del usuario desde PHP
        const userId = <?php echo json_encode($userID); ?>;

        // Verificar si el ID del usuario es válido
        if (!userId) {
            alert("No se pudo obtener el ID del usuario. Por favor, inicie sesión.");
        } else {
            // Hacer una solicitud a la API para obtener los datos del usuario
            fetch(`/api/user/${userId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Error al obtener los datos del usuario");
                    }
                    return response.json();
                })
                .then(data => {
                    // Llenar el formulario con los datos del usuario
                    document.getElementById('name').value = data.name || '';
                    document.getElementById('surname').value = data.surname || '';
                    document.getElementById('phone').value = data.phone || '';
                    document.getElementById('email').value = data.email || '';
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("No se pudieron cargar los datos del usuario.");
                });
        }
    </script>
<?php include(__DIR__ . '/../includes/footer.php'); ?>