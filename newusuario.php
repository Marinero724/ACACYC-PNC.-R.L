<?php
session_start();
require_once 'conexion.php';
require_once 'header.php';
$conn =mysqli_connect("$DB_HOST", "$DB_USER", "$DB_PASSWORD", "$DB_NAME", "$DB_PORT");
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

        // Consulta SQL de inserción
        $insertusuario = "INSERT INTO usuario ( idpermiso, nombre, departamento, telefono, user, pass, estado) VALUES ('$rol', '$name', '$dep', '$tel', '$user', '$pass', '$estado');";

        // Ejecuta la consulta
        if (mysqli_query($conn, $insertusuario)) {
            // La inserción se realizó con éxito
            mostrarSweetAlert("success", "Usuario fue insertado con exito.", "usuarios.php");
        } else {
            // Ocurrió un error
            mostrarSweetAlert("error", "Error al registrar al usuario: " . mysqli_error($conn), "usuarios.php");
        }
    }
}
?>


<div class="main-box-body clearfix text-center" id="formularioregistros">
    <h2>Formulario para registrar un nuevo usuario</h2>
    <form action="newusuario.php" method="POST">
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
                <label>Nombre</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="" required>
                <input type="hidden" id="valor">
            </div>
            <div class="form-group col-sm-6 col-xs-12">
                <label>Departamento</label>
                <input type="text" name="dep" id="dep" class="form-control" placeholder="" required>
                <input type="hidden" id="valor">
            </div>

        </div>

        <div class="row">
            <div class="form-group col-sm-6 col-xs-12">
                <label>telefono</label>
                <input type="text" name="tel" id="tel" class="form-control" placeholder="" required>
                <input type="hidden" id="valor">
            </div>
            <div class="form-group col-sm-6 col-xs-12">
                <label>usuario</label>
                <select class="form-control select-picker" name="rol" id="rol">
                    <option value="1">Recepcion</option>
                    <option value="2">Analista de creditos</option>
                    <option value="3">Gestor de cobros</option>
                    <option value="4">Atencion al cliente</option>
                    <option value="5">Cajas</option>
                    <option value="6">Supervisor</option>
                </select>

            </div>


        </div>
        <div class="row">

            <div class="form-group col-sm-6 col-xs-12">
                <label>usuario</label>
                <input type="text" name="user" id="user" class="form-control" placeholder="" required>
                <input type="hidden" id="valor">
            </div>
            <div class="form-group col-sm-6 col-xs-12">
                <label>Contraseña</label>
                <input type="password" name="pass" id="pass" class="form-control" placeholder="" required>
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
