<?php
$servername = "roundhouse.proxy.rlwy.net"; // Cambia esto si tu base de datos está en un servidor remoto
$username = "root"; // Cambia esto al nombre de usuario de tu base de datos
$password = "CFf-bbbGG22A6Ddb2G1a6fa-dhG5ae3g"; // Cambia esto a tu contraseña de base de datos
$dbname = "railway"; // Cambia esto al nombre de la base de datos que creaste


// Crear una conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

//echo "Conexión exitosa";

// Cerrar la conexión
//$conn->close();
?>
