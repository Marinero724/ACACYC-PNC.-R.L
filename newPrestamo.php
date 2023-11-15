<?php
session_start();
require_once 'conexion.php';
require_once 'header.php';
// Crear una conexión
$conn = mysqli_connect("$DB_HOST", "$DB_USER", "$DB_PASSWORD", "$DB_NAME", "$DB_PORT");
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
        $user = mysqli_real_escape_string($conn, $_SESSION['nombre']);
        $monto = mysqli_real_escape_string($conn, $_POST['monto']);
        $interes = mysqli_real_escape_string($conn, $_POST['interes']);
        $saldo = mysqli_real_escape_string($conn, $_POST['saldo']);
        $plazo = mysqli_real_escape_string($conn, $_POST['plazo']);
        $cuota = mysqli_real_escape_string($conn, $_POST['cuota']);
        $fechaPrestamo = date("Y-m-d H:i:s");
        $fechaPago = date("Y-m-d", strtotime($fechaPrestamo . " + " . 32 . " days"));

        $dui = sprintf('%09s', $dui);

        if (empty($dui) || empty($user) || empty($monto) || empty($interes) || empty($saldo) || empty($plazo) || empty($cuota)) {
            mostrarSweetAlert("error", "No se pudo realizar el insert ya que no se llenaron todos los campos. Por favor, revise los campos: DUI, Usuario, Monto, Interés, Saldo, Plazo y Cuota.", "prestamos.php");
        } else {
            // Consulta SQL de inserción
            $insertPrestamo = "INSERT INTO prestamo (idcliente, usuario, fprestamo, monto, interes, saldo, fpago, plazo, estado, cuota)
                VALUES ('$dui', '$user', '$fechaPrestamo', '$monto', '$interes', '$saldo', '$fechaPago', '$plazo', 1, '$cuota')";

            // Ejecuta la consulta
            if (mysqli_query($conn, $insertPrestamo)) {
                // La inserción se realizó con éxito
                // La inserción se realizó con éxito
                mostrarSweetAlert("success", "Prestamo fue insertado con exito.", "prestamos.php");
            } else {
                // Ocurrió un error
                mostrarSweetAlert("error", "Error al registrar al socio: " . mysqli_error($conn), "prestamos.php");
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
                mostrarSweetAlert("error", "SOCIO NO EXISTE." . mysqli_error($conn), "prestamos.php");
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
        <h2>Formulario para agregar un nuevo préstamo</h2>
        <form name="formulario" action="newPrestamo.php" id="formulario" method="POST">
            <div class="row">
                <div class="form-group col-md-3 col-sm-9 col-xs-12">
                    <label>Dui Socio</label>
                    <input type="text" name="id" value="<?php echo isset($id) ? $id : ''; ?>" class="form-control" required maxlength="9" oninput="validarDUI(this)">
                </div>
                <div class="form-group col-md-2 col-sm-9 col-xs-12">
                    <button class="btn btn-primary" type="submit" name="buscar" id="buscar"><i class="fa fa-search"></i> Buscar</button>
                </div>

                <div class="form-group col-md-6 col-sm-9 col-xs-12">
                    <label>Nombre</label>
                    <input type="text" name="name" value="<?php echo isset($nombre) ? $nombre : ''; ?>" id="dui" class="form-control" placeholder="" disabled>
                </div>
                <div class="form-group col-md-6 col-sm-9 col-xs-12">
                    <label>Direccion</label>
                    <input type="text" name="direc" value="<?php echo isset($direc) ? $direc : ''; ?>" class="form-control" placeholder="" disabled>
                </div>
                <div class="form-group col-md-6 col-sm-9 col-xs-12">
                    <label>Telefono</label>
                    <input type="text" name="tel" + value="<?php echo isset($tel) ? $tel : ''; ?>" class="form-control" placeholder="" disabled>
                </div>
                <div class="row">
                    <div class="form-group col-sm-3 col-xs-12">
                        <label>Monto</label>
                        <input type="number" name="monto" id="monto" class="form-control" placeholder="Monto">
                    </div>
                    <div class="form-group col-sm-3 col-xs-12">
                        <label>Interes</label>
                        <select class="form-control select-picker" name="interes" id="interes">
                            <option value="">Seleccione una opcion</option>
                            <option value="20">20 %</option>
                            <option value="15">15 %</option>
                            <option value="13">13 %</option>
                            <option value="10">10 %</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-3 col-xs-12">
                        <label>Saldo</label>
                        <input type="number" name="saldo" id="saldo" class="form-control" placeholder="Saldo" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-3 col-xs-12">
                        <label>Plazo</label>
                        <select class="form-control select-picker" name="plazo" id="plazo" onchange="calcularCuota()">
                            <option value="">Selccione un plazo</option>
                            <option value="36">3 años</option>
                            <option value="48">4 años</option>
                            <option value="60">5 años</option>
                            <option value="96">8 años</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-3 col-xs-12">
                        <label>Cuota</label>
                        <input type="number" name="cuota" id="cuota" class="form-control" placeholder="Cuota" disabled>
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
            // Eliminar caracteres no numéricos
            input.value = input.value.replace(/[^0-9]/g, '');

            // Limitar la longitud a 9 caracteres
            if (input.value.length > 9) {
                input.value = input.value.slice(0, 9);
            }
        }

        //SCRIP PARA CALCULAR EL SALDO EN BASE AL MONTO Y INTERES
        document.addEventListener('DOMContentLoaded', function() {
            var montoInput = document.getElementById('monto');
            var interesInput = document.getElementById('interes');
            var saldoInput = document.getElementById('saldo');

            montoInput.addEventListener('input', calcularSaldo);
            interesInput.addEventListener('input', calcularSaldo);

            function calcularSaldo() {
                var monto = parseFloat(montoInput.value) || 0;
                var interes = parseFloat(interesInput.value) || 0;

                var saldo = monto + (monto * (interes / 100));
                saldoInput.value = saldo.toFixed(2);
            }
        });
        //SCRIP PARA CALCULAR LA CUOTA EN BASE AL SALDO Y EL PLAZO
        document.addEventListener('DOMContentLoaded', function() {
            var saldoInput = document.getElementById('saldo');
            var plazoInput = document.getElementById('plazo');
            var cuotaInput = document.getElementById('cuota');

            saldoInput.addEventListener('input', calcularCuota);
            plazoInput.addEventListener('input', calcularCuota);

            function calcularCuota() {
                var saldo = parseFloat(saldoInput.value) || 0;
                var plazo = parseFloat(plazoInput.value) || 0;

                var cuota = saldo / plazo;
                cuotaInput.value = cuota.toFixed(2);
            }
        });
        //SCRIP PARA PODER MANDAR LOS DATOS SALDO Y CUOTA
        document.addEventListener('DOMContentLoaded', function() {
            var formulario = document.getElementById('formulario');
            var saldoInput = document.getElementById('saldo');
            var cuotaInput = document.getElementById('cuota');

            formulario.addEventListener('submit', function() {
                // Habilitar los campos antes de enviar el formulario
                saldoInput.disabled = false;
                cuotaInput.disabled = false;
            });
        });
    </script>
</body>