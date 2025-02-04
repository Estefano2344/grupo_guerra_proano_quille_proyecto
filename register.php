<?php
// Incluye el archivo de configuración que contiene la conexión a la base de datos
require 'config.php';

// Variables para almacenar mensajes de éxito y error
$successMessage = null;
$errorMessage = null;

// Procesa el formulario cuando se envía (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene y sanitiza el correo electrónico proporcionado por el usuario
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // Obtiene y sanitiza la contraseña proporcionada por el usuario
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Genera un hash de la contraseña para almacenarla de forma segura
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepara la consulta SQL para insertar un nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (email, password) VALUES ('$email', '$hashed_password')";

    // Ejecuta la consulta de inserción
    if (mysqli_query($conn, $sql)) {
        // Si la inserción es exitosa, establece un mensaje de éxito
        $successMessage = "Registro exitoso. Ahora puedes iniciar sesión.";
    } else {
        // Si hay un error, establece un mensaje de error
        $errorMessage = "Error al registrar el usuario. Inténtalo nuevamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Las Huequitas</title>
    <!-- Enlaces a Bootstrap y estilos personalizados -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Encabezado de la página -->
    <header>
        <div class="header-title">LAS HUEQUITAS</div>
    </header>
        
    <!-- Contenido principal de la página -->
    <main class="container my-5">
        <h2 class="text-center">REGISTRARSE</h2> <!-- Título de la sección -->
        <!-- Formulario de registro -->
        <form action="" method="POST" class="mx-auto bg-light p-4 rounded" style="max-width: 400px;">
            <!-- Campo para el correo electrónico -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="e-mail" required>
            </div>
            <!-- Campo para la contraseña -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="password" required>
            </div>
            <!-- Checkbox para aceptar los términos y condiciones -->
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="terms" required>
                <label class="form-check-label" for="terms">Términos y Condiciones</label>
            </div>
            <!-- Descripción debajo de los términos -->
            <p class="text-muted" style="font-size: 14px; margin-top: -10px;">
                Al aceptar los términos y condiciones, confirmas que estás de acuerdo con las políticas de uso y privacidad de nuestra página.
            </p>
            <!-- Botón para enviar el formulario -->
            <button type="submit" class="btn btn-dark w-100">Register</button>
        </form>
        <!-- Enlace para volver a la página de inicio de sesión -->
        <div class="text-center mt-3">
            <a href="login.php" class="btn btn-dark">Volver</a>
        </div>
    </main>

    <!-- Modal de éxito (se muestra si hay un mensaje de éxito) -->
    <?php if ($successMessage): ?>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">¡Registro Exitoso!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo htmlspecialchars($successMessage); ?></p>
                </div>
                <div class="modal-footer">
                    <a href="login.php" class="btn btn-success">OK</a>
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
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

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
    <script>
        // Mostrar automáticamente el modal de éxito si hay un mensaje de éxito
        <?php if ($successMessage): ?>
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
        <?php endif; ?>

        // Mostrar automáticamente el modal de error si hay un mensaje de error
        <?php if ($errorMessage): ?>
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
        <?php endif; ?>
    </script>
</body>
</html>