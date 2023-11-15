<?php



if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
        $nombre = $_POST["name"];
        $dui = $_POST["dui"];
        $telefono = $_POST["telefono"];
        $direccion = $_POST["direccion"];
        $estado = "1";

    if (empty($nombre) || empty($dui) || empty($telefono) || empty($direccion) || empty($estado) ) 
    {
        $Message = "No se pudo realizar el insert ya que no se llenaron todos los campos. Por favor, revise los campos: DUI, Usuario, Monto, Interés, Saldo, Plazo y Cuota.";
        echo '<script>alert("' . $Message . '");</script>';
    }
    else 
    {
        include '../conexion.php';
        // Consulta SQL de inserción
            $insertsocio = "INSERT INTO clientes (idcliente, nombre, telefono, direccion, estado) VALUES ('$dui','$nombre',  '$telefono', '$direccion', '$estado');";

            // Ejecuta la consulta
            if (mysqli_query($conn, $insertsocio)) 
            {
            // La inserción se realizó con éxito
            $successMessage  = "Socio fue insertado con exito.";
            echo '<script>alert("' . $successMessage  . '");</script>';
            $redirectionPage = '../clientes.php';
            echo '<script>window.location.href = "' . $redirectionPage . '";</script>';
            $conn->close();
            } else 
            {
            // Ocurrió un error
            echo "Error al registrar el préstamo: " . mysqli_error($conn);
            }
        }
 }
