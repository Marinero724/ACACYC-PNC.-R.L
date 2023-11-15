<?php
$DB_HOST=$_ENV["DB_HOST"]; // Cambia esto si tu base de datos está en un servidor remoto
$DB_USER=$_ENV["DB_USER"]; // Cambia esto al nombre de usuario de tu base de datos
$DB_PASSWORD=$_ENV["DB_PASSWORD"]; // Cambia esto a tu contraseña de base de datos
$DB_NAME=$_ENV["DB_NAME"]; // Cambia esto al nombre de la base de datos que creaste
$DB_PORT=$_ENV["DB_PORT"];  // Cambia esto el host de la baase de datos que creaste
// Crear una conexión
$conn =mysqli_connect("$DB_HOST", "$DB_USER", "$DB_PASSWORD", "$DB_NAME", "$DB_PORT");

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

//echo "Conexión exitosa";

// Cerrar la conexión
$conn->close();
?>

