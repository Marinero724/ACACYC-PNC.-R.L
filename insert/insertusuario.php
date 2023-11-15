<?php
session_start();  // Continuar la sesión
// Verificamos si se proporcionó el parámetro 'idCategoria' en la URL
require_once 'conexion.php';
require_once 'header.php';
$conn = mysqli_connect($servername, $username, $password, $dbname);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $dep = $_POST["dep"];
    $tel = $_POST["tel"];
    $user = $_POST["user"];
    $pass = $_POST["pass"];
    $rol = $_POST["rol"];
    $estado = "1";

    if (empty($name) || empty($dep) || empty($tel) || empty($user) || empty($pass) || empty($estado) || empty($rol)) {
        $Message = "No se pudo realizar el insert ya que no se llenaron todos los campos. Por favor, revise los campos: DUI, Usuario, Monto, Interés, Saldo, Plazo y Cuota.";
        echo '<script>alert("' . $Message . '");</script>';
    } else {
        include '../conexion.php';
        // Consulta SQL de inserción
        $insertusuario = "INSERT INTO usuario ( idpermiso, nombre, departamento, telefono, user, pass, estado) VALUES ('$rol', '$name', '$dep', '$tel', '$user', '$pass', '$estado');";

        // Ejecuta la consulta
        if (mysqli_query($conn, $insertusuario)) {
            // La inserción se realizó con éxito
            $successMessage  = "Usuario fue insertado con exito.";
            echo '<script>alert("' . $successMessage  . '");</script>';
            $redirectionPage = '../usuarios.php';
            echo '<script>window.location.href = "' . $redirectionPage . '";</script>';
            $conn->close();
        } else {
            // Ocurrió un error
            echo "Error al registrar el préstamo: " . mysqli_error($conn);
        }
    }
}
