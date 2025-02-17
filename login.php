<?php
// Incluye el archivo de configuración que contiene la conexión a la base de datos
require 'config.php';

// Inicia la sesión para manejar la autenticación del usuario
session_start();

// Variables para almacenar mensajes de éxito y error
$successMessage = null;
$errorMessage = null;

// Procesa el formulario cuando se envía (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene y sanitiza el correo electrónico proporcionado por el usuario
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // Obtiene la contraseña proporcionada por el usuario (no se sanitiza porque se usará para verificación)
    $password = $_POST['password'];

    // Consulta la base de datos para obtener el usuario con el correo electrónico proporcionado
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    // Verifica si el usuario existe y si la contraseña coincide
    if ($user && password_verify($password, $user['password'])) {
        // Si las credenciales son válidas, almacena el ID y el correo electrónico del usuario en la sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        // Establece un mensaje de éxito
        $successMessage = "Inicio de sesión exitoso. Bienvenido.";
    } else {
        // Si las credenciales son inválidas, establece un mensaje de error
        $errorMessage = "Credenciales inválidas. Inténtalo nuevamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Las Huequitas</title>
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
    <main class="d-flex justify-content-center align-items-center" style="min-height: 80vh; flex-direction: column;">
        <!-- Formulario de inicio de sesión -->
        <div class="p-4 rounded" style="width: 350px; background-color: #ffffff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <form action="" method="POST">
                <!-- Campo para el correo electrónico -->
                <div class="mb-3">
                    <label for="email" class="form-label" style="font-size: 18px;">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="e-mail" required style="border: 1px solid #ccc; border-radius: 5px; padding: 12px; font-size: 16px;">
                </div>
                <!-- Campo para la contraseña -->
                <div class="mb-3">
                    <label for="password" class="form-label" style="font-size: 18px;">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="password" required style="border: 1px solid #ccc; border-radius: 5px; padding: 12px; font-size: 16px;">
                </div>
                <!-- Botón para enviar el formulario -->
                <button type="submit" class="btn btn-dark w-100" style="background-color: black; color: white; padding: 12px; font-size: 18px; border-radius: 5px;">Sign In</button>
            </form>
            <!-- Enlace para registrarse -->
            <div class="text-center mt-3">
                <a href="register.php" style="font-size: 16px;">Registrarse</a>
            </div>
        </div>
        <!-- Botón para volver a la página principal -->
        <div class="text-center mt-4">
            <button class="btn btn-dark" style="background-color: black; color: white; padding: 12px; font-size: 18px; width: 150px; border-radius: 5px;" onclick="window.location.href='index.php'">Volver</button>
        </div>
    </main>

    <!-- Modal de éxito (se muestra si hay un mensaje de éxito) -->
    <?php if ($successMessage): ?>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">¡Inicio de Sesión Exitoso!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo htmlspecialchars($successMessage); ?></p>
                </div>
                <div class="modal-footer">
                    <a href="index.php" class="btn btn-success">OK</a>
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