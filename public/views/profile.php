<?php
// Obtener el idioma seleccionado de la URL, si está presente
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

// Obtener el ID del usuario desde la sesión
$userID = $_SESSION['user_id'] ?? null; // Asegúrate de que el ID del usuario esté almacenado en la sesión

$page_title = _("Perfil");
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/../includes/navbar.php');
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><?php echo _("Tu perfil"); ?></h4>
                </div>
                <div class="card-body">
                    <form id="profileForm">
                        <!-- Campo oculto para almacenar el ID del usuario -->
                        <input type="hidden" id="userId" value="<?php echo $userID; ?>">
                        <div class="form-group mb-3">
                            <label for="name"><?php echo _("Nombre"); ?></label>
                            <input type="text" id="name" class="form-control" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="surname"><?php echo _("Apellido"); ?></label>
                            <input type="text" id="surname" class="form-control" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone"><?php echo _("Teléfono"); ?></label>
                            <input type="text" id="phone" class="form-control" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email"><?php echo _("Correo electrónico"); ?></label>
                            <input type="email" id="email" class="form-control" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal"><?php echo _("Cambiar datos"); ?></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar datos -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel"><?php echo _("Editar perfil"); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm">
                    <input type="hidden" id="userId" value="<?php echo $_SESSION['user_id']; ?>">
                    <div class="form-group mb-3">
                        <label for="editName"><?php echo _("Nombre"); ?></label>
                        <input type="text" id="editName" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="editSurname"><?php echo _("Apellido"); ?></label>
                        <input type="text" id="editSurname" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="editPhone"><?php echo _("Teléfono"); ?></label>
                        <input type="text" id="editPhone" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="editEmail"><?php echo _("Correo electrónico"); ?></label>
                        <input type="email" id="editEmail" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo _("Cerrar"); ?></button>
                <button type="button" class="btn btn-primary" id="saveProfileButton"><?php echo _("Guardar cambios"); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener el ID del usuario desde PHP
        const userId = <?php echo json_encode($userID); ?>;

        // Verificar si el ID del usuario es válido
        if (!userId) {
            alert("<?php echo _("No se pudo obtener el ID del usuario. Por favor, inicie sesión."); ?>");
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

                    // Llenar el formulario del modal cuando se abra
                    document.getElementById('editProfileModal').addEventListener('show.bs.modal', function() {
                        document.getElementById('editName').value = data.name || '';
                        document.getElementById('editSurname').value = data.surname || '';
                        document.getElementById('editPhone').value = data.phone || '';
                        document.getElementById('editEmail').value = data.email || '';
                    });
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("<?php echo _("No se pudieron cargar los datos del usuario."); ?>");
                });
        }

        // Manejar el clic en el botón "Guardar cambios"
        document.getElementById('saveProfileButton').addEventListener('click', function() {
            const userId = document.getElementById('userId').value;
            const updatedData = {
                id: document.getElementById('userId').value,
                name: document.getElementById('editName').value,
                surname: document.getElementById('editSurname').value,
                phone: document.getElementById('editPhone').value,
                email: document.getElementById('editEmail').value
            };

            fetch(`/api/user/${userId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(updatedData)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(errorData.message || "Error al actualizar los datos del usuario");
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    alert("<?php echo _("Datos actualizados correctamente."); ?>");
                    // Cerrar el modal
                    bootstrap.Modal.getInstance(document.getElementById('editProfileModal')).hide();
                    // Recargar la página para mostrar los datos actualizados
                    location.reload();
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("<?php echo _("No se pudieron actualizar los datos del usuario."); ?>\n" + error.message);
                });
        });
    });
</script>
<?php include(__DIR__ . '/../includes/footer.php'); ?>