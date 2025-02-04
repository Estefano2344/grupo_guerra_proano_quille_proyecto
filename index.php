<?php
// Inicia la sesión para acceder a las variables de sesión
session_start();

// Verifica si el usuario está logueado comprobando si existe 'user_id' en la sesión
$loggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Las Huequitas</title>
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
                <li class="nav-item"><a class="nav-link active" href="index.php">HOME</a></li> <!-- Página actual -->
                <li class="nav-item"><a class="nav-link" href="reseñas.php">RESEÑAS</a></li> <!-- Página de reseñas -->
                <li class="nav-item"><a class="nav-link" href="anuncios.php">ANUNCIOS</a></li> <!-- Página de anuncios -->
                <?php if ($loggedIn): ?>
                    <!-- Si el usuario está logueado, muestra el enlace para cerrar sesión -->
                    <li class="nav-item"><a class="nav-link" href="logout.php">CERRAR SESIÓN</a></li>
                <?php else: ?>
                    <!-- Si el usuario no está logueado, muestra el enlace para iniciar sesión o registrarse -->
                    <li class="nav-item"><a class="nav-link" href="login.php">LOG IN / SIGN UP</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal de la página -->
    <main class="container my-5 text-center">
        <h2>HOME</h2> <!-- Título de la sección -->
        <div class="mx-auto p-4 bg-light rounded" style="max-width: 600px; border: 2px solid gray;">
            <!-- Descripción del sitio -->
            <p>
                Las Huequitas es un foro dedicado a la promoción y difusión de las mejores huecas en Quito. Aquí puedes encontrar 
                reseñas, anuncios, y compartir tus experiencias con otros usuarios que aman descubrir la auténtica gastronomía de la ciudad.
            </p>
        </div>

        <!-- Si el usuario está logueado, muestra un botón para cerrar sesión -->
        <?php if ($loggedIn): ?>
            <div class="mt-4">
                <a href="logout.php" class="btn btn-custom">Cerrar Sesión</a>
            </div>
        <?php endif; ?>
    </main>

    <!-- Pie de página -->
    <footer class="bg-dark text-light text-center p-2">
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