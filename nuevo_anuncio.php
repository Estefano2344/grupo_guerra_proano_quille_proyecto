<?php
// Incluye el archivo que contiene la lógica de CRUD para los anuncios
include 'crud_anuncios.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Anuncio - Las Huequitas</title>
    <!-- Enlaces a Bootstrap y estilos personalizados -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Encabezado de la página -->
    <header>
        <div class="header-title">
            LAS HUEQUITAS <!-- Título del sitio -->
        </div>
    </header>

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <ul class="navbar-nav mx-auto">
                <!-- Enlaces de navegación -->
                <li class="nav-item"><a class="nav-link" href="index.php">HOME</a></li> <!-- Página de inicio -->
                <li class="nav-item"><a class="nav-link" href="reseñas.php">RESEÑAS</a></li> <!-- Página de reseñas -->
                <li class="nav-item"><a class="nav-link active" href="anuncios.php">ANUNCIOS</a></li> <!-- Página de anuncios (activa) -->
                <li class="nav-item"><a class="nav-link" href="login.php">LOG IN / SIGN UP</a></li> <!-- Página de inicio de sesión o registro -->
            </ul>
        </div>
    </nav>

    <!-- Contenido principal de la página -->
    <main class="container my-5">
        <h2 class="text-center">NUEVO ANUNCIO</h2> <!-- Título de la sección -->
        <!-- Formulario para crear un nuevo anuncio -->
        <form class="mx-auto bg-light p-4 rounded" style="max-width: 500px;" action="crud_anuncios.php" method="POST">
            <!-- Campo para el nombre del restaurante -->
            <div class="mb-3">
                <label for="restaurante" class="form-label">Restaurante</label>
                <input type="text" class="form-control" id="restaurante" name="restaurante" placeholder="Nombre del restaurante" required>
            </div>
            <!-- Campo para el anuncio -->
            <div class="mb-3">
                <label for="anuncio" class="form-label">Anuncio</label>
                <textarea class="form-control" id="anuncio" name="anuncio" rows="5" placeholder="Escribe tu anuncio aquí..." required></textarea>
            </div>
            <!-- Botones para volver o subir el anuncio -->
            <div class="d-flex justify-content-between">
                <a href="anuncios.php" class="btn btn-secondary">Volver</a> <!-- Botón para volver a la página de anuncios -->
                <button type="submit" class="btn btn-dark">Subir</button> <!-- Botón para enviar el formulario -->
            </div>
        </form>
    </main>

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
</body>
</html>