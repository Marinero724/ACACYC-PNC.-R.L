<?php
session_start();  // Continuar la sesión
// Verificamos si se proporcionó el parámetro 'idCategoria' en la URL
require_once 'conexion.php';
$conn = mysqli_connect($servername, $username, $password, $dbname);
//Validamos si trae id_usuario para ver si esta logueado y el idCategoria para saber la tabla
//BLOQUE PARA ELIMINAR PRESTAMOS
if (isset($_GET['idPrestamo']) && isset($_GET['idUsuario'])) {
    // Obtener el ID de categoría de la URL
    $idPrestamo = $_GET['idPrestamo'];
    $idusuario = $_GET['idusuario'];
    // Verificar la conexión a la base de datos
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Preparar la consulta para eliminar la categoría con el ID proporcionado
    $sql = "DELETE FROM prestamo WHERE idprestamo = $idPrestamo";

    // Ejecutar la consulta
    if (mysqli_query($conn, $sql)) {
        $redirectionPage = 'prestamos.php';
        echo '<script>window.location.href = "' . $redirectionPage . '";</script>';
    } else {
        echo "Error al eliminar el Prestamo: " . mysqli_error($conn);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
}
//BLOQUE PARA ELIMINAR PAGOS
else if (isset($_GET['idpago']) && isset($_GET['idUsuario'])) {
    // Obtener el ID de categoría de la URL
    $idpago = $_GET['idpago'];
    $idusuario = $_GET['idusuario'];
    // Verificar la conexión a la base de datos
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Preparar la consulta para eliminar la categoría con el ID proporcionado
    $sql = "DELETE FROM pagos WHERE idpago = $idpago";

    // Ejecutar la consulta
    if (mysqli_query($conn, $sql)) {
        $redirectionPage = 'pagos.php';
        echo '<script>window.location.href = "' . $redirectionPage . '";</script>';
    } else {
        echo "Error al eliminar el pago: " . mysqli_error($conn);
        $errorMessage = "No se proporcionó un ID de Prestamo.";
        echo '<script>alert("' . $errorMessage . '");</script>';
        $redirectionPage = 'pagos.php';
        echo '<script>window.location.href = "' . $redirectionPage . '";</script>';
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
}
// BLOQUE PARA ELIMINAR CLIENTES
else if (isset($_GET['idCliente']) && isset($_GET['idUsuario'])) {
    // Obtener el ID de categoría de la URL
    $idcliente = $_GET['idCliente'];
    $idcliente = $_GET['idCliente'];
    $idcliente = sprintf('%09s', $idcliente);
    echo $idcliente;
    // Verificar la conexión a la base de datos
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Preparar la consulta para eliminar la categoría con el ID proporcionado
    $sql = "DELETE FROM clientes WHERE idcliente = $idcliente";

    // Ejecutar la consulta
    if (mysqli_query($conn, $sql)) {
        $redirectionPage = 'clientes.php';
        echo '<script>window.location.href = "' . $redirectionPage . '";</script>';
    } else {
        // echo "Error al eliminar el Cliente: " . mysqli_error($conn);
        $errorMessage = "Error al eliminar el Cliente.";
        echo '<script>alert("' . $errorMessage . '");</script>';
        $redirectionPage = 'clientes.php';
        echo '<script>window.location.href = "' . $redirectionPage . '";</script>';
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
}
//BLOQUE PARA ELIMINAR USUARIOS
else if (isset($_GET['idUser']) && isset($_GET['idUsuario'])) {
    // Obtener el ID de categoría de la URL
    $idUser = $_GET['idUser'];
    $idUsuario = $_GET['idUsuario'];

    // Verificar la conexión a la base de datos
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    //Validamos que el ID USER no pertenesca a la persona que esta haciendo la gestion
    if ($idUser != $idUsuario) {
        // Preparar la consulta para eliminar la categoría con el ID proporcionado
        $sql = "DELETE FROM usuario WHERE idusuario = $idUser";
        // Ejecutar la consulta
        if (mysqli_query($conn, $sql)) {
            // $successMessage  = "Usuario fue eliminado con exito.";
            // echo '<script>alert("' . $successMessage  . '");</script>';
            $redirectionPage = 'usuarios.php';
            echo '<script>window.location.href = "' . $redirectionPage . '";</script>';
        } else {
            // echo "Error al eliminar el Cliente: " . mysqli_error($conn);
            $errorMessage = "Error al eliminar el Cliente.";
            echo '<script>alert("' . $errorMessage . '");</script>';
            $redirectionPage = 'usuarios.php';
            // echo '<script>window.location.href = "' . $redirectionPage . '";</script>';
        }
    } else {

        $errorMessage = "No se puede borrar este Usuario";
        echo '<script>alert("' . $errorMessage . '");</script>';
        $redirectionPage = 'usuarios.php';
        // echo '<script>window.location.href = "' . $redirectionPage . '";</script>';
    }


    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
} else {

    $errorMessage = "No se proporcionó un ID de Prestamo.";
    echo '<script>alert("' . $errorMessage . '");</script>';
    $redirectionPage = isset($_GET['idPrestamo']) ? 'prestamos.php' : (isset($_GET['idpago']) ? 'pagos.php' : (isset($_GET['idCliente']) ? 'idCliente.php' : 'concepto.php'));
    echo '<script>window.location.href = "' . $redirectionPage . '";</script>';
}
