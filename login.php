<?php
session_start();
require_once 'conexion.php';
// Crear una conexión
$conn =mysqli_connect("$DB_HOST", "$DB_USER", "$DB_PASSWORD", "$DB_NAME", "$DB_PORT");

// Verifica si la conexión a la base de datos fue exitosa
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Obtén los valores del formulario
$user = $_POST['user'];
$pass = $_POST['pass'];

// Construye la consulta SQL
$query = "SELECT * FROM usuario WHERE user = '$user' AND pass = '$pass'";

// Verifica si la consulta está definida y no es una cadena vacía
if (!empty($query)) {
    // Ejecuta la consulta SQL
    $db_query = mysqli_query($conn, $query);

    // Verifica si la consulta se ejecutó correctamente
    if ($db_query) {
        // Recupera los resultados
        $result = mysqli_fetch_array($db_query);

        // Verifica si se encontraron resultados
        if ($result) {
            if ($result['estado'] == 1) {
                // Usuario activo
                $_SESSION['idusuario'] = $result['idusuario'];
                $_SESSION['user'] = $result['user'];
                $_SESSION['nombre'] = $result['nombre'];
                $_SESSION['idRol'] = $result['idPermiso'];
                $idUsuario = $result['idusuario'];
                //Voy a la tabla de usuariospermi para recuperar el idusuariopermi

                // Redirige a la página de inicio con un comentario
                echo '<script>
              var comentario = "Inicio de sesión exitoso.";
              window.location.replace("concepto.php?comentario=" + encodeURIComponent(comentario));
            </script>';
                exit();
            } else {
                // Usuario inactivo
                $comentario = "El usuario es inactivo";
                header("Location: fail.php?comentario=" . urlencode($comentario));
                exit();
            }
        } else {
            // Credenciales inválidas
            $comentario = "Nombre de usuario o contraseña incorrectos.";
            header("Location: fail.php?comentario=" . urlencode($comentario));
            exit();
        }
    } else {
        // Error en la consulta SQL
        echo "Error en la consulta: " . mysqli_error($conn);
    }
} else {
    // La consulta no está definida o es una cadena vacía
    echo "Error: Consulta SQL vacía o no definida.";
}

// Cierra la conexión a la base de datos
$conn->close();
