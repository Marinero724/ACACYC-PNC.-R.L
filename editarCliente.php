<?php
session_start();  // Continuar la sesión
// Verificamos si se proporcionó el parámetro 'idCategoria' en la URL
require_once 'conexion.php';
require_once 'header.php';
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Función para mostrar SweetAlert
function mostrarSweetAlert($icon, $text, $redirectionPage = null)
{
    echo "<script>
        Swal.fire({
            icon: '$icon',
            title: '$text',
            showCancelButton: false,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed && '$redirectionPage') {
                window.location.href = '$redirectionPage';
            }
        });
    </script>";
}

//Validamos si trae id_usuario para ver si esta logueado y el idCategoria para saber la tabla
if (isset($_GET['idCliente']) && isset($_GET['idUsuario'])) {
    // Obtener el ID de categoría de la URL
    $idcliente = $_GET['idCliente'];
    $idcliente = $_GET['idCliente'];
    $idcliente = sprintf('%09s', $idcliente);
    //echo $idcliente;
    // Verificar la conexión a la base de datos
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    $sqlCliente = "SELECT * FROM clientes WHERE idcliente = $idcliente";

    if ($result = mysqli_query($conn, $sqlCliente)) {
        // Comprueba si se obtuvieron resultados
        if (mysqli_num_rows($result) > 0) {
            // Obtiene la primera fila de resultados
            $row = mysqli_fetch_assoc($result);

            // Imprime los valores obtenidos
            // Asigna los valores a las variables para usar en el formulario
            $idcliente = $row['idcliente'];
            $nombre = $row['nombre'];
            $direccion = $row['direccion'];
            $telefono = $row['telefono'];
        } else {
            mostrarSweetAlert("error", "No se encontraron resultados para el idcliente: $idcliente");
        }
    } else {
        // mostrarSweetAlert("error", "Error en la consulta: " . mysqli_error($conn));
    }
} else if (isset($_POST['submit'])) {
    //Recibimos los name de cada imput
    $idcliente = mysqli_real_escape_string($conn, $_POST['dui']);
    $nombre = mysqli_real_escape_string($conn, $_POST['name']);
    $direccion = mysqli_real_escape_string($conn, $_POST['direccion']);
    $telefono = mysqli_real_escape_string($conn, $_POST['telefono']);
    //Defino mi query para poder hacer un update a la bd
    $sqlUpdate = "UPDATE clientes SET idcliente='$idcliente', nombre='$nombre', direccion='$direccion', telefono='$telefono' WHERE idcliente=$idcliente";

    if (mysqli_query($conn, $sqlUpdate)) {
        mostrarSweetAlert("success", "Registro actualizado", "clientes.php");
    } else {
        mostrarSweetAlert("error", "Error al actualizar el registro: " . mysqli_error($conn), "clientes.php");
    }
} else {
    mostrarSweetAlert("error", "Lo sentimos, algo salió mal. Póngase en contacto con su superior" . mysqli_error($conn), "clientes.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="main-box-body clearfix text-center" id="formularioregistros">
        <h2>Formulario para editar el registro del socio</h2>
        <form action="editarCliente.php" method="POST">
            <div class="row">
                <div class="form-group col-md-6 col-sm-9 col-xs-12">
                    <label></label>
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label></label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6 col-xs-12">
                    <label>Dui</label>
                    <input type="text" name="dui" id="dui" class="form-control" style="text-align: center;" value="<?php echo $idcliente; ?>" disabled>
                    <input type="hidden" name="dui" value="<?php echo $idcliente; ?>">
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label>Nombre</label>
                    <input type="text" name="name" id="name" class="form-control" style="text-align: center;" value="<?php echo $nombre; ?>" placeholder="" required>
                    <input type="hidden" id="valor">
                </div>


            </div>

            <div class="row">
                <div class="form-group col-sm-6 col-xs-12">
                    <label>Direccion</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" style="text-align: center;" value="<?php echo $direccion; ?>" placeholder="" required>
                    <input type="hidden" id="valor">
                </div>

                <div class="form-group col-sm-6 col-xs-12">
                    <label>Telefono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" style="text-align: center;" value="<?php echo $telefono; ?>" placeholder="" required>
                    <input type="hidden" id="valor">
                </div>


            </div>
            <div class="form-group col-xs-12">
                <button class="btn btn-primary" name="submit" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
            </div>
        </form>
    </div>

    <?php
    //Para cambiar el color y poder desplegar la opcion de cierre de sesion
    require_once 'footer.php';
    ?>