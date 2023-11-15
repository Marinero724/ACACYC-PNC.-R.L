<?php
$servername = "localhost"; // Cambia esto si tu base de datos está en un servidor remoto
$username = "root"; // Cambia esto al nombre de usuario de tu base de datos
$password = ""; // Cambia esto a tu contraseña de base de datos
$dbname = "prestamo"; // Cambia esto al nombre de la base de datos que creaste


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