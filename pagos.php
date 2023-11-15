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

        $saldo = mysqli_real_escape_string($conn, $_POST['saldo']);
        $dui = mysqli_real_escape_string($conn, $_POST['id']);
        $user = mysqli_real_escape_string($conn, $_SESSION['nombre']);
        $cuota = mysqli_real_escape_string($conn, $_POST['cuota']);
        $fechaPrestamo = date("Y-m-d ");
        $fechaPago = date("Y-m-d", strtotime($fechaPrestamo . " + " . 32 . " days"));

        if (empty($dui) || empty($user) || empty($saldo) || empty($cuota) || empty($fechaPago) || empty($fechaPrestamo)) {
            mostrarSweetAlert("error", "No se pudo realizar el insert ya que no se llenaron todos los campos. Por favor, revise los campos: Saldo, DUI, Usuario, Cuota, Fecha Prestamo, Fecha Pago", "pagos.php");
        } else {

            $llamandoid = "SELECT idprestamo FROM prestamo WHERE idcliente = '$dui'";
            $result = $conn->query($llamandoid);
            // Obtener el primer resultado como un arreglo asociativo
            $row = $result->fetch_assoc();
            $dato = $row['idprestamo'];

            // Consulta SQL de inserción
            $insertpago = "INSERT INTO  pagos (idprestamo, duiCliente, usuario, fecha, cuota, saldo) 
                    VALUES ('$dato','$dui','$user','$fechaPrestamo','$cuota','$saldo');
                    
                    UPDATE prestamo
                    SET saldo = saldo - '$cuota'
                    WHERE idcliente = '$dui'
                    ";

            if ($conn->multi_query($insertpago) === TRUE) {
                mostrarSweetAlert("success", "Pago fue insertado con exito.", "pagos.php");
            } else {
                // Ocurrió un error
                mostrarSweetAlert("error", "Error al registrar el préstamo: " . mysqli_error($conn), "pagos.php");
            }
            error_reporting(0);
            ini_set('display_errors', 0);
            // Ejecuta la consulta
            if (mysqli_query($conn, $insertpago)) {
                // La inserción se realizó con éxito
                mostrarSweetAlert("success", "Pago fue insertado con exito.", "pagos.php");
            } else {
                // Ocurrió un error
                mostrarSweetAlert("error", "Error al registrar el Pago: " . mysqli_error($conn), "pagos.php");
            }
        }
    }
    if (isset($_POST['buscar'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);

        if (empty($id)) {
            mostrarSweetAlert("error", "POR FAVOR INGRESE DATOS." . mysqli_error($conn), "pagos.php");
        } else {
            $sql = "SELECT prestamo.idcliente,cuota,fpago,fprestamo,interes,monto,plazo,saldo, clientes.nombre, clientes.direccion,clientes.telefono
            FROM prestamo                            
            INNER JOIN clientes ON clientes.idcliente = prestamo.idcliente  and prestamo.idcliente = $id;";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $nombre = $row["nombre"];
                $tel = $row["telefono"];
                $direc = $row["direccion"];
                $id = $row["idcliente"];
                $cuota = $row["cuota"];
                $fpago = $row["fpago"];
                $fprestamo = $row["fprestamo"];
                $interes = $row["interes"];
                $monto = $row["monto"];
                $plazo = $row["plazo"];
                $saldo = $row["saldo"];
            } else {
                mostrarSweetAlert("error", "SOCIO NO EXISTE." . mysqli_error($conn), "pagos.php");
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
    <div class="main-box-body clearfix text-center " id="formularioregistros">
        <h2>PAGO DE PRESTAMO</h2>
        <form name="formulario" action="pagos.php" id="formulario" method="POST">
            <div class="row">
                <div class="form-group col-md-3 col-sm-9 col-xs-12">
                    <label>Dui Socio</label>
                    <input type="text" name="id" value="<?php echo isset($id) ? $id : ''; ?>" class="form-control" maxlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
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
                        <input type="text" name="monto" + value="<?php echo isset($monto) ? $monto : ''; ?>" class="form-control" placeholder="" disabled>
                    </div>
                    <div class="form-group col-sm-3 col-xs-12">
                        <label>Interes</label>
                        <input type="text" name="interes" + value="<?php echo isset($interes) ? $interes : ''; ?>" class="form-control" placeholder="" disabled>
                    </div>
                    <div class="form-group col-sm-3 col-xs-12">
                        <label>Saldo</label>
                        <input type="text" name="saldo" + value="<?php echo isset($saldo) ? $saldo : ''; ?>" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-3 col-xs-12">
                        <label>Plazo</label>
                        <input type="text" name="plazo" + value="<?php echo isset($plazo) ? $plazo : ''; ?>" class="form-control" placeholder="" disabled>
                    </div>
                    <div class="form-group col-sm-3 col-xs-12">
                        <label>Cuota</label>
                        <input type="text" name="cuota" + value="<?php echo isset($cuota) ? $cuota : ''; ?>" class="form-control" placeholder="">
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
<?php require_once 'footer.php'; ?>