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
if (isset($_SESSION['idusuario'])) {
    if (isset($_POST['submit'])) {

        // Verificar si El Salvador está en horario de verano o estándar
        $horarioDeVerano = date('I');
        // Configurar la zona horaria manualmente
        if ($horarioDeVerano == 1) {
            date_default_timezone_set('America/El_Salvador');
        } else {
            date_default_timezone_set('America/El_Salvador');
        }


        $dui = mysqli_real_escape_string($conn, $_POST['id']);
        $fechaPago = mysqli_real_escape_string($conn, $_POST['fecha']);
        $cuota = mysqli_real_escape_string($conn, $_POST['cuota']);
        $concepto = mysqli_real_escape_string($conn, $_POST['concepto']);
        $fecha = date("Y-m-d ");

        $dui = sprintf('%09s', $dui);


        if (empty($dui) || empty($fechaPago) || empty($cuota) || empty($fecha) || empty($concepto)) {
            $Message = "No se pudo realizar el insert ya que no se llenaron todos los campos. Por favor, revise los campos: DUI, Usuario, Monto, Interés, Saldo, Plazo y Cuota.";
            echo '<script>alert("' . $Message . '");</script>';
        } else {
            // Consulta SQL de inserción
            $insertPrestamo = "
            INSERT INTO cuentasdeahorro (idcliente, fechaapertura, fechadepago, cuotadeahorro,concepto)
                VALUES ('$dui', '$fecha', '$fechaPago', '$cuota','$concepto')";

            // Ejecuta la consulta
            if (mysqli_query($conn, $insertPrestamo)) {
                // La inserción se realizó con éxito
                mostrarSweetAlert("success", "Cuenta de ahorro fue creada con exito.", "cuentaahorro.php");
            } else {
                // Ocurrió un error
                mostrarSweetAlert("error", "Error al crear la cuenta de ahorro." . mysqli_error($conn), "newcuentaahorro.php");
            }
        }
    }
    if (isset($_POST['buscar'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);

        if (empty($id)) {
            $Message = "POR FACOR INGRESE DATOS";
            echo '<script>alert("' . $Message . '");</script>';
        } else {
            $sql = "SELECT idcliente, nombre, direccion,telefono FROM clientes WHERE idcliente = $id";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $nombre = $row["nombre"];
                $tel = $row["telefono"];
                $direc = $row["direccion"];
                $id = $row["idcliente"];
            } else {

                mostrarSweetAlert("error", "SOCIO NO EXISTE." . mysqli_error($conn), "newcuentaahorro.php");
            }
        }
    }
} else {
    // El usuario no ha iniciado sesión, redirigirlo al formulario de inicio de sesión
    header("Location: login.html");
    exit();
}
?>

<body>
    <div class="main-box-body clearfix text-center" id="formularioregistros">
        <h2>FORMULARIO PARA CREAR UNA NUEVA CUENTA DE AHORRO</h2>
        <form name="formulario" action="newcuentaahorro.php" id="formulario" method="POST">
            <div class="row">
                <div class="form-group col-md-3 col-sm-9 col-xs-12">
                    <label>Dui Socio</label>
                    <input type="text" name="id" value="<?php echo isset($id) ? $id : ''; ?>" class="form-control" required maxlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>
                <div class="form-group col-md-2 col-sm-9 col-xs-12">
                    <button class="btn btn-primary" type="submit" name="buscar" id="buscar"><i class="fa fa-search"></i> Buscar</button>
                </div>

                <div class="form-group col-md-6 col-sm-9 col-xs-12">
                    <label>Nombre</label>
                    <input type="text" name="name" value="<?php echo isset($nombre) ? $nombre : ''; ?>" id="dui" class="form-control" placeholder="" disabled>
                </div>
                <div class="row">
                    <div class="form-group col-sm-4 col-xs-12">
                        <label>concepto</label>
                        <input type="text" name="concepto" id="concepto" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-sm-3 col-xs-12">
                        <label>fecha de abono</label>
                        <input type="date" name="fecha" id="monto" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-sm-3 col-xs-12">
                        <label>Cuota de ahorro </label>
                        <input type="text" name="cuota" value="" id="dui" class="form-control" placeholder="">
                    </div>
                </div>

                <div class="form-group col-xs-12">
                    <button class="btn btn-primary" type="submit" name="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                    <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                </div>
        </form>
    </div>
    <script>
        //SCRIP PARA VALIDAR FORMATO DE DUI SIN GUION
        function validarDUI(input) {
            // Expresión regular para verificar el formato "000000000" y no permitir "000000000" o "000000001"
            var formatoDUI = /^(?!000000000$|000000001$)\d{9}$/;

            if (formatoDUI.test(input.value)) {
                input.setCustomValidity('');
            } else {
                input.setCustomValidity('El formato del DUI debe ser ######### y no se permite 000000000 o 000000001');
            }
        }
    </script>
</body>
<?php
require_once 'footer.php';
?>