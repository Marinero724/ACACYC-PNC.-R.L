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

        $idcliente = mysqli_real_escape_string($conn, $_POST['id']);
        $saldo = mysqli_real_escape_string($conn, $_POST['saldo']);
        $concepto = mysqli_real_escape_string($conn, $_POST['concepto']);
        $cuota = mysqli_real_escape_string($conn, $_POST['cuota']);
        $fechaP = date("Y-m-d ");
        // $fechaPago = date("Y-m-d", strtotime($fechaPrestamo . " + " . 32 . " days"));

        if (empty($idcliente) || empty($saldo) || empty($concepto) || empty($cuota) || empty($fechaP)) {

            mostrarSweetAlert("error", "No se pudo realizar el insert ya que no se llenaron todos los campos. Por favor, revise los campos: DUI, Saldo, Concepto, Cuota, Fecha.", "aporte.php");
        } else {

            // Consulta de ejemplo
            $sqlid = "SELECT idcuenta
FROM cuentasdeahorro  
WHERE idcliente ='$idcliente' ";
            $resultado = $conn->query($sqlid);
            $fila = $resultado->fetch_assoc();
            $idcuenta = $fila['idcuenta'];


            // Consulta SQL de inserción
            $insertpago = "INSERT INTO aportes( idcuentaahorro, idcliente, fecha, aporte,saldo) VALUES ('$idcuenta','$idcliente','$fechaP','$cuota','$saldo');
                     UPDATE cuentasdeahorro
                    SET saldo = '$saldo' + '$cuota'
                    WHERE idcliente = '$idcliente'
                    ";

            //echo $insertpago;
            if ($conn->multi_query($insertpago) === TRUE) {
                // La inserción se realizó con éxito
                mostrarSweetAlert("success", "Aporte fue insertado con exito.", "aporte.php");
            } else {
                // Ocurrió un error
                mostrarSweetAlert("error", "Error al registrar el aporte." . mysqli_error($conn), "aporte.php");
            }

            // // Ejecuta la consulta
            // if (mysqli_query($conn, $insertpago)) {
            //     // La inserción se realizó con éxito
            //     $successMessage  = "pago fue insertado con exito.";
            //     echo '<script>alert("' . $successMessage  . '");</script>';
            //     $redirectionPage = 'aporte.php';
            //     echo '<script>window.location.href = "' . $redirectionPage . '";</script>';
            // } else {
            //     // Ocurrió un error
            //     echo "Error al registrar el aporte : " . mysqli_error($conn);
            // }
        }
    }
    if (isset($_POST['buscar'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);

        if (empty($id)) {
            mostrarSweetAlert("error", "POR FAVOR INGRESE DATOS." . mysqli_error($conn), "aporte.php");
        } else {
            $sql = "SELECT clientes.idcliente, clientes.nombre,
            cuentasdeahorro.concepto,
            cuentasdeahorro.cuotadeahorro,
            cuentasdeahorro.saldo,cuentasdeahorro.fechadepago FROM cuentasdeahorro
            INNER join clientes on clientes.idcliente = cuentasdeahorro.idcliente
            where clientes.idcliente = $id;";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                // $id = $row["idcliente"];
                $nombre = $row["nombre"];
                $concepto = $row["concepto"];
                $cuota = $row["cuotadeahorro"];
                $saldo = $row["saldo"];
                $fechap = $row["fechadepago"];
            } else {
                mostrarSweetAlert("error", "SOCIO NO EXISTE." . mysqli_error($conn), "aporte.php");
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
        <h2>APORTE A CUENTA DE AHORRO</h2>
        <form name="formulario" action="aporte.php" id="formulario" method="POST">
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
                    <input type="text" name="id" value="<?php echo isset($nombre) ? $nombre : ''; ?>" id="id" class="form-control" placeholder="" disabled>
                </div>
                <div class="form-group col-md-6 col-sm-9 col-xs-12">
                    <label>Concepto</label>
                    <input type="text" name="concepto" value="<?php echo isset($concepto) ? $concepto : ''; ?>" class="form-control" placeholder="">
                </div>
                <div class="form-group col-md-6 col-sm-9 col-xs-12">
                    <label>Fecha de pago</label>
                    <input type="text" name="fechap" + value="<?php echo isset($fechap) ? $fechap : ''; ?>" class="form-control" placeholder="" disabled>
                </div>
                <div class="row">
                    <div class="form-group col-sm-3 col-xs-12">
                        <label>Saldo</label>
                        <input type="text" name="saldo" + value="<?php echo isset($saldo) ? $saldo : ''; ?>" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-sm-3 col-xs-12">
                        <label>Cuota</label>
                        <input type="text" name="cuota" + value="<?php echo isset($cuota) ? $cuota : ''; ?>" class="form-control" placeholder="">
                    </div>

                </div>
                <div class="row">

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