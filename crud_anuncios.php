<?php
// Incluye el archivo de configuración que contiene la conexión a la base de datos
require 'config.php';

// Verifica si la sesión no está activa y la inicia si es necesario
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtiene el valor del filtro de búsqueda desde la URL y lo sanitiza para evitar inyecciones SQL
$filter = isset($_GET['filter']) ? mysqli_real_escape_string($conn, $_GET['filter']) : '';

// Consulta los anuncios que coincidan con el filtro (en el campo 'restaurante' o 'anuncio')
$sql = "SELECT * FROM anuncios 
        WHERE restaurante LIKE '%$filter%' 
           OR anuncio LIKE '%$filter%' 
        ORDER BY id DESC"; // Ordena los resultados por ID de forma descendente
$result = mysqli_query($conn, $sql); // Ejecuta la consulta

// Procesa el formulario cuando se envía (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si el usuario está autenticado (tiene un 'user_id' en la sesión)
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id']; // Obtiene el ID del usuario
        $restaurante = mysqli_real_escape_string($conn, $_POST['restaurante']); // Sanitiza el campo 'restaurante'
        $anuncio = mysqli_real_escape_string($conn, $_POST['anuncio']); // Sanitiza el campo 'anuncio'

        // Verifica si se está actualizando un anuncio existente
        if (isset($_POST['update'])) {
            $id = intval($_POST['id']); // Obtiene y sanitiza el ID del anuncio
            // Prepara la consulta SQL para actualizar el anuncio
            $sqlUpdate = "UPDATE anuncios 
                          SET restaurante = '$restaurante', anuncio = '$anuncio' 
                          WHERE id = $id AND user_id = $user_id"; // Solo actualiza si el usuario es el propietario

            // Ejecuta la consulta de actualización
            if (mysqli_query($conn, $sqlUpdate)) {
                // Redirige con un mensaje de éxito
                header("Location: anuncios.php?success=Anuncio actualizado con éxito");
            } else {
                // Redirige con un mensaje de error
                header("Location: anuncios.php?error=Error al actualizar el anuncio");
            }
        } else {
            // Si no es una actualización, se trata de un nuevo anuncio
            $sqlInsert = "INSERT INTO anuncios (user_id, restaurante, anuncio) VALUES ('$user_id', '$restaurante', '$anuncio')";
            // Ejecuta la consulta de inserción
            if (mysqli_query($conn, $sqlInsert)) {
                // Redirige con un mensaje de éxito
                header("Location: anuncios.php?success=Anuncio publicado con éxito");
            } else {
                // Redirige con un mensaje de error
                header("Location: anuncios.php?error=Error al publicar el anuncio");
            }
        }
        exit(); // Termina la ejecución del script después de redirigir
    }
}

// Procesa la eliminación de un anuncio si se recibe el parámetro 'delete' en la URL
if (isset($_GET['delete'])) {
    // Verifica si el usuario está autenticado
    if (isset($_SESSION['user_id'])) {
        $idEliminar = intval($_GET['delete']); // Obtiene y sanitiza el ID del anuncio a eliminar
        $user_id = $_SESSION['user_id']; // Obtiene el ID del usuario

        // Verifica si el anuncio pertenece al usuario actual
        $sqlCheck = "SELECT * FROM anuncios WHERE id = $idEliminar AND user_id = $user_id";
        $resultCheck = mysqli_query($conn, $sqlCheck);

        // Si el anuncio existe y pertenece al usuario, procede a eliminarlo
        if (mysqli_num_rows($resultCheck) > 0) {
            $sqlDelete = "DELETE FROM anuncios WHERE id = $idEliminar";
            if (mysqli_query($conn, $sqlDelete)) {
                // Redirige con un mensaje de éxito
                header("Location: anuncios.php?success=Anuncio eliminado con éxito");
            } else {
                // Redirige con un mensaje de error
                header("Location: anuncios.php?error=Error al eliminar el anuncio");
            }
        } else {
            // Si el anuncio no pertenece al usuario, redirige con un mensaje de error
            header("Location: anuncios.php?error=No autorizado para eliminar este anuncio");
        }
    }
    exit(); // Termina la ejecución del script después de redirigir
}
?>