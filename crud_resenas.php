<?php
// Incluye el archivo de configuración que contiene la conexión a la base de datos
require 'config.php';

// Verifica si la sesión no está activa y la inicia si es necesario
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtiene el valor del filtro de búsqueda desde la URL y lo sanitiza para evitar inyecciones SQL
$filter = isset($_GET['filter']) ? mysqli_real_escape_string($conn, $_GET['filter']) : '';

// Consulta las reseñas que coincidan con el filtro (en el campo 'restaurante' o 'resena')
$sql = "SELECT * FROM resenas 
        WHERE restaurante LIKE '%$filter%' 
           OR resena LIKE '%$filter%' 
        ORDER BY id DESC"; // Ordena los resultados por ID de forma descendente
$result = mysqli_query($conn, $sql); // Ejecuta la consulta

// Procesa el formulario cuando se envía (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se está actualizando una reseña existente
    if (isset($_POST['update'])) {
        $id = intval($_POST['id']); // Obtiene y sanitiza el ID de la reseña
        $user_id = $_SESSION['user_id']; // Obtiene el ID del usuario
        $restaurante = mysqli_real_escape_string($conn, $_POST['restaurante']); // Sanitiza el campo 'restaurante'
        $resena = mysqli_real_escape_string($conn, $_POST['resena']); // Sanitiza el campo 'resena'

        // Prepara la consulta SQL para actualizar la reseña
        $sqlUpdate = "UPDATE resenas 
                      SET restaurante = '$restaurante', resena = '$resena' 
                      WHERE id = $id AND user_id = $user_id"; // Solo actualiza si el usuario es el propietario

        // Ejecuta la consulta de actualización
        if (mysqli_query($conn, $sqlUpdate)) {
            // Redirige con un mensaje de éxito
            header("Location: reseñas.php?success=Reseña actualizada con éxito");
        } else {
            // Redirige con un mensaje de error
            header("Location: reseñas.php?error=Error al actualizar la reseña");
        }
        exit(); // Termina la ejecución del script después de redirigir
    }

    // Si no es una actualización, se trata de una nueva reseña
    $user_id = $_SESSION['user_id']; // Obtiene el ID del usuario
    $restaurante = mysqli_real_escape_string($conn, $_POST['restaurante']); // Sanitiza el campo 'restaurante'
    $resena = mysqli_real_escape_string($conn, $_POST['resena']); // Sanitiza el campo 'resena'

    // Prepara la consulta SQL para insertar una nueva reseña
    $sqlInsert = "INSERT INTO resenas (user_id, restaurante, resena) VALUES ('$user_id', '$restaurante', '$resena')";
    // Ejecuta la consulta de inserción
    if (mysqli_query($conn, $sqlInsert)) {
        // Redirige con un mensaje de éxito
        header("Location: reseñas.php?success=Reseña publicada con éxito");
    } else {
        // Redirige con un mensaje de error
        header("Location: reseñas.php?error=Error al publicar la reseña");
    }
    exit(); // Termina la ejecución del script después de redirigir
}

// Procesa la eliminación de una reseña si se recibe el parámetro 'delete' en la URL
if (isset($_GET['delete'])) {
    // Verifica si el usuario está autenticado
    if (isset($_SESSION['user_id'])) {
        $idEliminar = intval($_GET['delete']); // Obtiene y sanitiza el ID de la reseña a eliminar
        $user_id = $_SESSION['user_id']; // Obtiene el ID del usuario

        // Verifica si la reseña pertenece al usuario actual
        $sqlCheck = "SELECT * FROM resenas WHERE id = $idEliminar AND user_id = $user_id";
        $resultCheck = mysqli_query($conn, $sqlCheck);

        // Si la reseña existe y pertenece al usuario, procede a eliminarla
        if (mysqli_num_rows($resultCheck) > 0) {
            $sqlDelete = "DELETE FROM resenas WHERE id = $idEliminar";
            if (mysqli_query($conn, $sqlDelete)) {
                // Redirige con un mensaje de éxito
                header("Location: reseñas.php?success=Reseña eliminada con éxito");
            } else {
                // Redirige con un mensaje de error
                header("Location: reseñas.php?error=Error al eliminar la reseña");
            }
        } else {
            // Si la reseña no pertenece al usuario, redirige con un mensaje de error
            header("Location: reseñas.php?error=No autorizado para eliminar esta reseña");
        }
    }
    exit(); // Termina la ejecución del script después de redirigir
}
?>