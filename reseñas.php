<?php include 'crud_resenas.php'; ?> <!-- Incluir la lógica del CRUD -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñas - Las Huequitas</title>
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
                <li class="nav-item"><a class="nav-link active" href="reseñas.php">RESEÑAS</a></li>
                <li class="nav-item"><a class="nav-link" href="anuncios.php">ANUNCIOS</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">LOG IN / SIGN UP</a></li>
            </ul>
        </div>
    </nav>

    <main class="container my-5">
        <h2 class="text-center">RESEÑAS</h2>
        <div class="row">
            <!-- Columna izquierda para filtros -->
            <div class="col-md-3">
                <div class="bg-light p-3 rounded">
                    <h4>Filtros</h4>
                    <form action="" method="GET">
                        <input type="text" name="filter" class="form-control mb-2" placeholder="Buscar" value="<?php echo htmlspecialchars($filter); ?>">
                        <button type="submit" class="btn btn-dark w-100">Filtrar</button>
                    </form>
                </div>
            </div>

            <!-- Columna derecha para lista de reseñas -->
            <div class="col-md-9">
                <div class="d-flex justify-content-end mb-3">
                    <a href="nueva_reseña.php" class="btn btn-dark">Nueva</a>
                </div>

                <div class="bg-light p-4 rounded">
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <div class="mb-3">
                                <h5><strong>Restaurante:</strong> <?php echo htmlspecialchars($row['restaurante']); ?></h5>
                                <p><strong>Reseña:</strong> <?php echo htmlspecialchars($row['resena']); ?></p>

                                <!-- Botones de Editar y Eliminar -->
                                <a href="editar_reseña.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>

                                <a href="reseñas.php?delete=<?php echo $row['id']; ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('¿Seguro que deseas eliminar esta reseña?');">
                                   Borrar
                                </a>
                            </div>
                            <hr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-center">No hay reseñas disponibles.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
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
