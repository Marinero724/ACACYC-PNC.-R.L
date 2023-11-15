<?php
session_start();
require_once 'conexion.php';
require_once 'header.php';
$conn = new mysqli($servername, $username, $password, $dbname);
if (isset($_SESSION['idusuario'])) {
    if (isset($_GET['submit'])) {
        
        // Verificar si El Salvador está en horario de verano o estándar
            $horarioDeVerano = date('I');
            // Configurar la zona horaria manualmente
            if ($horarioDeVerano == 1) {
                date_default_timezone_set('America/El_Salvador');
            } else {
                date_default_timezone_set('America/El_Salvador');
            }

        $dui = mysqli_real_escape_string($conn, $_GET['dui']);
        $user = mysqli_real_escape_string($conn, $_SESSION['nombre']);
        $monto = mysqli_real_escape_string($conn, $_GET['monto']);
        $interes = mysqli_real_escape_string($conn, $_GET['interes']);
        $saldo = mysqli_real_escape_string($conn, $_GET['saldo']);
        $plazo = mysqli_real_escape_string($conn, $_GET['plazo']);
        $cuota = mysqli_real_escape_string($conn, $_GET['cuota']);
        $fechaPrestamo = date("Y-m-d H:i:s");
        $fechaPago = date("Y-m-d", strtotime($fechaPrestamo . " + " . 32 . " days"));

        echo "DUI: " . $dui . "<br>";
        echo "User: " . $user . "<br>";
        echo "Monto: " . $monto . "<br>";
        echo "Interes: " . $interes . "<br>";
        echo "Saldo: " . $saldo . "<br>";
        echo "Plazo: " . $plazo . "<br>";
        echo "Cuota: " . $cuota . "<br>";
        echo "FechaPrestamo: " . $fechaPrestamo . "<br>";
        echo "Fecha de pago: " . $fechaPago;


    }
     else if (isset($_GET['buscar'])) {
        $dui = mysqli_real_escape_string($conn, $_GET['dui']);
        echo $dui;
     }
}else {
    // El usuario no ha iniciado sesión, redirigirlo al formulario de inicio de sesión
    header("Location: login.html");
    exit();
}