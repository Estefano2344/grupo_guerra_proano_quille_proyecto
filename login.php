<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Las Huequitas</title>
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
                <li class="nav-item"><a class="nav-link active" href="login.php">LOG IN / SIGN UP</a></li>
            </ul>
        </div>
    </nav>
    <main class="container my-5">
        <h2 class="text-center">LOG IN / SIGN UP</h2>
        <form class="mx-auto bg-light p-4 rounded" style="max-width: 400px;">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password">
            </div>
            <button type="submit" class="btn btn-dark w-100">Sign In</button>
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
