<?php
// ------------------------
// (1) Conexión a la base de datos
// ------------------------
// Incluir conexión
require 'config.php';

// ------------------------
// (2) Eliminar Reseña (Delete)
// ------------------------
if (isset($_GET['delete'])) {
    $idEliminar = intval($_GET['delete']); // Sanitizar el ID recibido
    $sqlDelete = "DELETE FROM resenas WHERE id = $idEliminar";
    mysqli_query($conn, $sqlDelete);

    // Redirigir a reseñas.php para evitar eliminación doble al recargar
    header("Location: reseñas.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $restaurante = $_POST['restaurante'];
    $resena = $_POST['reseña'];

    // Evitar problemas con comillas o inyección SQL
    $restaurante = mysqli_real_escape_string($conn, $restaurante);
    $resena = mysqli_real_escape_string($conn, $resena);

    // Insertar en la tabla resenas
    $sqlInsert = "INSERT INTO resenas (restaurante, resena) 
                  VALUES ('$restaurante', '$resena')";

    if (mysqli_query($conn, $sqlInsert)) {
        // Redirigir a reseñas.php para ver la nueva reseña
        header("Location: reseñas.php");
        exit();
    } else {
        echo "Error al insertar: " . mysqli_error($conn);
    }
}

// ------------------------
// (3) Filtro y Consulta de Reseñas (Read)
// ------------------------
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

$sql = "SELECT * FROM resenas 
        WHERE restaurante LIKE '%$filter%' 
           OR resena LIKE '%$filter%'
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
?>
