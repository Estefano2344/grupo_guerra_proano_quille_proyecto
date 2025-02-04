<?php
// Verifica si la sesión no está activa y la inicia si es necesario
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica si el usuario no está autenticado (no tiene un 'user_id' en la sesión)
if (!isset($_SESSION['user_id'])) {
    // Redirige al usuario a la página de login si no está autenticado
    header("Location: login.php");
    exit(); // Termina la ejecución del script
}

// Lógica para mostrar mensajes de modal (éxito o error) basados en parámetros GET
$modalMessage = null;
if (isset($_GET['success'])) {
    // Si hay un mensaje de éxito en la URL, se almacena en $modalMessage
    $modalMessage = ['type' => 'success', 'message' => $_GET['success']];
} elseif (isset($_GET['error'])) {
    // Si hay un mensaje de error en la URL, se almacena en $modalMessage
    $modalMessage = ['type' => 'error', 'message' => $_GET['error']];
}

// Incluye el archivo que contiene la lógica de CRUD para los anuncios
include 'crud_anuncios.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anuncios - Las Huequitas</title>
    <!-- Enlaces a Bootstrap y estilos personalizados -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script>
        // Función para habilitar/deshabilitar la edición de un anuncio
        function toggleEdit(id) {
            const displayDiv = document.getElementById(`display-${id}`);
            const editForm = document.getElementById(`edit-form-${id}`);
            // Alterna la visibilidad del modo de visualización y el formulario de edición
            displayDiv.style.display = displayDiv.style.display === 'none' ? 'block' : 'none';
            editForm.style.display = editForm.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <header>
        <div class="header-title">LAS HUEQUITAS</div>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <ul class="navbar-nav mx-auto">
                <!-- Enlaces de navegación -->
                <li class="nav-item"><a class="nav-link" href="index.php">HOME</a></li>
                <li class="nav-item"><a class="nav-link" href="reseñas.php">RESEÑAS</a></li>
                <li class="nav-item"><a class="nav-link active" href="anuncios.php">ANUNCIOS</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">LOG IN / SIGN UP</a></li>
            </ul>
        </div>
    </nav>
    <main class="container my-5">
        <h2 class="text-center">ANUNCIOS</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="bg-light p-3 rounded">
                    <h4>Filtros</h4>
                    <!-- Formulario para filtrar anuncios -->
                    <form action="anuncios.php" method="GET">
                        <input type="text" name="filter" class="form-control mb-2" placeholder="Buscar anuncios" value="<?php echo htmlspecialchars($filter); ?>">
                        <button type="submit" class="btn btn-dark w-100">Filtrar</button>
                    </form>
                </div>
            </div>
            <div class="col-md-9">
                <div class="d-flex justify-content-end mb-3">
                    <!-- Botón para crear un nuevo anuncio -->
                    <a href="nuevo_anuncio.php" class="btn btn-dark">Nuevo Anuncio</a>
                </div>
                <div class="bg-light p-4 rounded">
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <!-- Itera sobre cada anuncio y lo muestra -->
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <div class="mb-3">
                                <!-- Modo de Visualización del anuncio -->
                                <div id="display-<?php echo $row['id']; ?>">
                                    <h5><strong>Restaurante:</strong> <?php echo htmlspecialchars($row['restaurante']); ?></h5>
                                    <p><strong>Anuncio:</strong> <?php echo htmlspecialchars($row['anuncio']); ?></p>
                                    <?php if ($row['user_id'] == $_SESSION['user_id']): ?>
                                        <!-- Botones para editar y eliminar el anuncio (solo para el propietario) -->
                                        <button class="btn btn-warning btn-sm" onclick="toggleEdit(<?php echo $row['id']; ?>)">Editar</button>
                                        <a href="anuncios.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este anuncio?');">Eliminar</a>
                                    <?php endif; ?>
                                </div>

                                <!-- Modo de Edición del anuncio (formulario oculto inicialmente) -->
                                <form id="edit-form-<?php echo $row['id']; ?>" action="crud_anuncios.php" method="POST" style="display: none;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <div class="mb-2">
                                        <label for="restaurante-<?php echo $row['id']; ?>" class="form-label">Restaurante</label>
                                        <input type="text" id="restaurante-<?php echo $row['id']; ?>" name="restaurante" class="form-control" value="<?php echo htmlspecialchars($row['restaurante']); ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="anuncio-<?php echo $row['id']; ?>" class="form-label">Anuncio</label>
                                        <textarea id="anuncio-<?php echo $row['id']; ?>" name="anuncio" class="form-control" rows="3" required><?php echo htmlspecialchars($row['anuncio']); ?></textarea>
                                    </div>
                                    <button type="submit" name="update" class="btn btn-success btn-sm">Guardar</button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEdit(<?php echo $row['id']; ?>)">Cancelar</button>
                                </form>
                            </div>
                            <hr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <!-- Mensaje que se muestra si no hay anuncios disponibles -->
                        <p class="text-center">No hay anuncios disponibles.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Modales para mostrar mensajes de éxito o error -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">¡Éxito!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p id="successMessage">Acción completada con éxito.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">¡Error!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p id="errorMessage">Hubo un problema al completar la acción.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie de página -->
    <footer class="bg-dark text-light">
        <div>
            <span>Términos de Uso</span> | 
            <span>Política de Privacidad</span> | 
            <span>&copy; 2006-2024 Las Huequitas</span>
        </div>
    </footer>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($modalMessage): ?>
    <script>
        <?php if ($modalMessage['type'] === 'success'): ?>
            // Muestra el modal de éxito con el mensaje correspondiente
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            document.getElementById('successMessage').innerText = "<?php echo $modalMessage['message']; ?>";
            successModal.show();
        <?php elseif ($modalMessage['type'] === 'error'): ?>
            // Muestra el modal de error con el mensaje correspondiente
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            document.getElementById('errorMessage').innerText = "<?php echo $modalMessage['message']; ?>";
            errorModal.show();
        <?php endif; ?>
    </script>
    <?php endif; ?>
</body>
</html>