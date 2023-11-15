<?php
session_start();
require_once 'conexion.php';
require_once 'header.php';
$conn = new mysqli($servername, $username, $password, $dbname);
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

if (isset($_POST['submit'])) {
    $nombre = $_POST["name"];
    $dui = $_POST["dui"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $estado = "1";

    if (empty($nombre) || empty($dui) || empty($telefono) || empty($direccion) || empty($estado)) {
        mostrarSweetAlert("error", "No se pudo realizar el insert ya que no se llenaron todos los campos. Por favor, revise los campos: Nombre, DUI, Telefono, Direccion: " . mysqli_error($conn), "clientes.php");
    } else {

        // Consulta SQL de inserción
        $insertsocio = "INSERT INTO clientes (idcliente, nombre, telefono, direccion, estado) VALUES ('$dui','$nombre',  '$telefono', '$direccion', '$estado');";

        // Ejecuta la consulta
        if (mysqli_query($conn, $insertsocio)) {
            // La inserción se realizó con éxito
            mostrarSweetAlert("success", "Socio fue insertado con exito.", "clientes.php");
        } else {
            // Ocurrió un error
            mostrarSweetAlert("error", "Error al registrar al socio: " . mysqli_error($conn), "clientes.php");
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Agregar enlaces a FontAwesome CSS -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="main-box-body clearfix text-center" id="formularioregistros">
        <h2>Formulario para registrar un nuevo socio</h2>
        <form action="newsocio.php" method="POST">
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
                    <input type="text" name="dui" id="dui" class="form-control" placeholder="" required maxlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    <input type="hidden" id="valor">

                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label>Nombre</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="" required>
                    <input type="hidden" id="valor">
                </div>


            </div>

            <div class="row">
                <div class="form-group col-sm-6 col-xs-12">
                    <label>Direccion</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" placeholder="" required>
                    <input type="hidden" id="valor">
                </div>

                <div class="form-group col-sm-6 col-xs-12">
                    <label>Telefono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" placeholder="" required>
                    <input type="hidden" id="valor">
                </div>

            </div>
            <div class="form-group col-xs-12">
                <button class="btn btn-primary" name="submit" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
            </div>
        </form>
    </div>
</body>

</html>