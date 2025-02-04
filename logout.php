<?php
// Inicia la sesión para acceder a las variables de sesión
session_start();

// Elimina todas las variables de sesión
session_unset();

// Destruye la sesión actual
session_destroy();

// Redirige al usuario a la página de inicio de sesión (login.php)
header("Location: login.php");

// Termina la ejecución del script para evitar que se procese más código
exit();
?>