<?php include 'crud_resenas.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Reseña - Las Huequitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="header-title">
            LAS HUEQUITAS
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">HOME</a></li>
                <li class="nav-item"><a class="nav-link" href="reseñas.php">RESEÑAS</a></li>
                <li class="nav-item"><a class="nav-link" href="anuncios.php">ANUNCIOS</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">LOG IN / SIGN UP</a></li>
            </ul>
        </div>
    </nav>

    <main class="container my-5">
        <h2 class="text-center">NUEVA RESEÑA</h2>
        <form class="mx-auto bg-light p-4 rounded" style="max-width: 500px;" action="#" method="POST">
            <div class="mb-3">
                <label for="restaurante" class="form-label">Restaurante</label>
                <input type="text" class="form-control" id="restaurante" name="restaurante" placeholder="Nombre del restaurante" required>
            </div>
            <div class="mb-3">
                <label for="reseña" class="form-label">Reseña</label>
                <textarea class="form-control" id="reseña" name="reseña" rows="5" placeholder="Escribe tu reseña aquí..." required></textarea>
            </div>
            <div class="d-flex justify-content-between">
                <a href="reseñas.php" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-dark">Subir</button>
            </div>
        </form>
    </main>

    <footer class="bg-dark text-light">
        <div>
            <span>Términos de Uso</span> | 
            <span>Política de Privacidad</span> | 
            <span>&copy; 2006-2024 Las Huequitas</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
