<?php
// Verifica si la sesión no está activa y la inicia si es necesario
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica si el usuario no está autenticado (no tiene un 'user_id' en la sesión)
if (!isset($_SESSION['user_id'])) {
    // Redirige al usuario a la página de inicio de sesión si no está autenticado
    header("Location: login.php");
    exit(); // Termina la ejecución del script
}

// Incluye el archivo que contiene la lógica de CRUD para las reseñas
include 'crud_resenas.php';

// Verifica si hay mensajes de éxito o error en los parámetros de la URL
$successMessage = isset($_GET['success']) ? $_GET['success'] : null;
$errorMessage = isset($_GET['error']) ? $_GET['error'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñas - Las Huequitas</title>
    <!-- Enlaces a Bootstrap y estilos personalizados -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script>
        // Función para habilitar/deshabilitar la edición de una reseña
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
    <!-- Encabezado de la página -->
    <header>
        <div class="header-title">LAS HUEQUITAS</div>
    </header>
        
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <ul class="navbar-nav mx-auto">
                <!-- Enlaces de navegación -->
                <li class="nav-item"><a class="nav-link" href="index.php">HOME</a></li> <!-- Página de inicio -->
                <li class="nav-item"><a class="nav-link active" href="reseñas.php">RESEÑAS</a></li> <!-- Página de reseñas (activa) -->
                <li class="nav-item"><a class="nav-link" href="anuncios.php">ANUNCIOS</a></li> <!-- Página de anuncios -->
                <li class="nav-item"><a class="nav-link" href="login.php">LOG IN / SIGN UP</a></li> <!-- Página de inicio de sesión o registro -->
            </ul>
        </div>
    </nav>

    <!-- Contenido principal de la página -->
    <main class="container my-5">
        <h2 class="text-center">RESEÑAS</h2> <!-- Título de la sección -->
        <div class="row">
            <!-- Columna de filtros -->
            <div class="col-md-3">
                <div class="bg-light p-3 rounded">
                    <h4>Filtros</h4>
                    <!-- Formulario para filtrar reseñas -->
                    <form action="reseñas.php" method="GET">
                        <input type="text" name="filter" class="form-control mb-2" placeholder="Buscar" value="<?php echo htmlspecialchars($filter); ?>">
                        <button type="submit" class="btn btn-dark w-100">Filtrar</button>
                    </form>
                </div>
            </div>

            <!-- Columna de reseñas -->
            <div class="col-md-9">
                <div class="d-flex justify-content-end mb-3">
                    <!-- Botón para crear una nueva reseña -->
                    <a href="nueva_reseña.php" class="btn btn-dark">Nueva</a>
                </div>

                <!-- Lista de reseñas -->
                <div class="bg-light p-4 rounded">
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <!-- Itera sobre cada reseña y la muestra -->
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <div class="mb-3">
                                <!-- Modo de Visualización de la reseña -->
                                <div id="display-<?php echo $row['id']; ?>">
                                    <h5><strong>Restaurante:</strong> <?php echo htmlspecialchars($row['restaurante']); ?></h5>
                                    <p><strong>Reseña:</strong> <?php echo htmlspecialchars($row['resena']); ?></p>
                                    <?php if ($row['user_id'] == $_SESSION['user_id']): ?>
                                        <!-- Botones para editar y eliminar la reseña (solo para el propietario) -->
                                        <button class="btn btn-warning btn-sm" onclick="toggleEdit(<?php echo $row['id']; ?>)">Editar</button>
                                        <a href="reseñas.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta reseña?');">Borrar</a>
                                    <?php endif; ?>
                                </div>

                                <!-- Modo de Edición de la reseña (formulario oculto inicialmente) -->
                                <form id="edit-form-<?php echo $row['id']; ?>" action="crud_resenas.php" method="POST" style="display: none;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <div class="mb-2">
                                        <label for="restaurante-<?php echo $row['id']; ?>" class="form-label">Restaurante</label>
                                        <input type="text" id="restaurante-<?php echo $row['id']; ?>" name="restaurante" class="form-control" value="<?php echo htmlspecialchars($row['restaurante']); ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="resena-<?php echo $row['id']; ?>" class="form-label">Reseña</label>
                                        <textarea id="resena-<?php echo $row['id']; ?>" name="resena" class="form-control" rows="3" required><?php echo htmlspecialchars($row['resena']); ?></textarea>
                                    </div>
                                    <button type="submit" name="update" class="btn btn-success btn-sm">Guardar</button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEdit(<?php echo $row['id']; ?>)">Cancelar</button>
                                </form>
                            </div>
                            <hr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <!-- Mensaje que se muestra si no hay reseñas disponibles -->
                        <p class="text-center">No hay reseñas disponibles.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal de éxito (se muestra si hay un mensaje de éxito) -->
    <?php if ($successMessage): ?>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">¡Éxito!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo htmlspecialchars($successMessage); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Modal de error (se muestra si hay un mensaje de error) -->
    <?php if ($errorMessage): ?>
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">¡Error!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo htmlspecialchars($errorMessage); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Pie de página -->
    <footer class="bg-dark text-light">
        <div>
            <!-- Enlaces y copyright -->
            <span>Términos de Uso</span> | 
            <span>Política de Privacidad</span> | 
            <span>&copy; 2006-2024 Las Huequitas</span>
        </div>
    </footer>

    <!-- Script de Bootstrap para funcionalidades adicionales -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostrar automáticamente el modal de éxito si hay un mensaje de éxito
        <?php if ($successMessage): ?>
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
        <?php endif; ?>

        // Mostrar automáticamente el modal de error si hay un mensaje de error
        <?php if ($errorMessage): ?>
        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
        <?php endif; ?>
    </script>
</body>
</html>