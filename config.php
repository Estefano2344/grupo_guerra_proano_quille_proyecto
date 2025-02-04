<?php
// ------------------------
// Conexión a la base de datos
// ------------------------
ini_set('display_errors', 1);
error_reporting(E_ALL);

$server   = "localhost";
$database = "las_huequitas"; 
$username = "root";
$password = "";

// Conectar a la base de datos
$conn = mysqli_connect($server, $username, $password, $database);

// Verificar conexión
if (!$conn) {
    die('No se puede conectar con la BDD: ' . mysqli_connect_error());
}
?>
