<?php
session_start();  // Continuar la sesión
// Verificamos si se proporcionó el parámetro 'idCategoria' en la URL
require_once 'conexion.php';
require_once 'header.php';
$conn = mysqli_connect($servername, $username, $password, $dbname); 
//Validamos si trae id_usuario para ver si esta logueado y el idCategoria para saber la tabla
if (isset($_GET['idPrestamo']) && isset($_GET['idUsuario'])) {
    // Obtener el ID de categoría de la URL
    global $idPrestamo;
    $idPrestamo = $_GET['idPrestamo'];
    $idusuario = $_GET['idUsuario'];
    
    // Verificar la conexión a la base de datos
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    
   // Preparar la consulta para eliminar la categoría con el ID proporcionado
$sql = "SELECT idcliente, usuario, fprestamo, monto, interes, saldo, fpago, plazo, estado, cuota FROM prestamo WHERE idprestamo = $idPrestamo";

// Ejecutar la consulta
if ($result = mysqli_query($conn, $sql)) {
    // Comprueba si se obtuvieron resultados
    if (mysqli_num_rows($result) > 0) {
        // Obtiene la primera fila de resultados
        $row = mysqli_fetch_assoc($result);

        // Almacena los resultados en variables
        $idcliente = $row['idcliente'];
        $usuario = $row['usuario'];
        $fprestamo = $row['fprestamo'];
        $monto = $row['monto'];
        $interes = $row['interes'];
        $saldo = $row['saldo'];
        $fpago = $row['fpago'];
        $plazo = $row['plazo'];
        $estado = $row['estado'];
        $cuota = $row['cuota'];

    } else {
        // No se encontraron resultados
        echo "No se encontraron resultados para el ID de préstamo proporcionado.";
    }

    // Liberar el conjunto de resultados
    mysqli_free_result($result);
}
else {
    // Maneja el caso de error si la consulta falla
    echo "Error en la consulta: " . mysqli_error($conn);
}
    
    // Cerrar la conexión a la base de datos
   // mysqli_close($conn);
}
else if (isset($_POST['submit'])){
    $idPrestamo = mysqli_real_escape_string($conn, $_POST['idPrestamo']);
    $dui = mysqli_real_escape_string($conn, $_POST['dui']);
    $user = mysqli_real_escape_string($conn, $_SESSION['nombre']);
    $monto = mysqli_real_escape_string($conn, $_POST['monto']);
    $interes = mysqli_real_escape_string($conn, $_POST['interes']);
    $saldo = mysqli_real_escape_string($conn, $_POST['saldo']);
    $plazo = mysqli_real_escape_string($conn, $_POST['plazo']);
    $cuota = mysqli_real_escape_string($conn, $_POST['cuota']);
    echo $idPrestamo;
    // Consulta SQL de UPDATE
        $updatePrestamo = "UPDATE prestamo SET 
        idcliente = '$dui', 
        usuario = '$user', 
        monto = '$monto', 
        interes = '$interes', 
        saldo = '$saldo', 
        plazo = '$plazo', 
        cuota = '$cuota' 
        WHERE idprestamo = $idPrestamo";

        // Ejecuta la consulta de UPDATE
        if (mysqli_query($conn, $updatePrestamo)) {
            $successMessage  = "Prestamo fue actualizado con exito.";
            echo '<script>alert("' . $successMessage  . '");</script>';
            $redirectionPage = 'prestamos.php';
            echo '<script>window.location.href = "' . $redirectionPage . '";</script>';
        } else {
        echo "Error al actualizar el registro: " . mysqli_error($conn);
        }

        } 
else {
    $errorMessage  = "Lo sentimos algo salio pongase en contacto con su superior";
    echo '<script>alert("' . $errorMessage  . '");</script>';
    $redirectionPage = 'prestamos.php';
    echo '<script>window.location.href = "' . $redirectionPage . '";</script>';
}
?>
<body>
<div class="main-box-body clearfix text-center" id="formularioregistros">
    <h2>Formulario para Editar un préstamo</h2>
    <form name="formulario" action="editar.php" id="formulario" method="POST">
        <div class="form-group col-sm-3 col-xs-12" style="display: none;">
            <label>idPrestamo</label>
            <input type="number" name="idPrestamo" value="<?php echo $idPrestamo; ?>" id="idPrestamo" class="form-control" placeholder="idPrestamo" required>
        </div>
        <div class="row">
            <div class="form-group col-md-6 col-sm-9 col-xs-12">
                <label>Clientes</label>
                <input type="hidden" name="idcliente" id="dui">
                <input type="text" name="dui" id="dui" value="<?php echo isset($idcliente) ? $idcliente : $dui; ?>" class="form-control" placeholder="DUI" maxlength="9" required oninput="validarDUI(this)">

            </div>
            <div class="form-group col-sm-6 col-xs-12">
                <label>Usuarios</label>
                <input type="hidden" name="user" id="user">
                <input type="text" name="user" id="user" class="form-control" placeholder="<?php echo isset($usuario) ? $usuario : $user; ?>" maxlength="20"></div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3 col-xs-12">
                <label>Monto</label>
                <input type="number" name="monto" value="<?php echo $monto; ?>" id="monto" class="form-control" placeholder="Monto" required>
            </div>
            <div class="form-group col-sm-3 col-xs-12">
                <label>Interes</label>
                <select class="form-control select-picker" name="interes" id="interes" required>
                    <option value="<?php echo $interes; ?>"><?php echo $interes; ?>"</option>
                    <option value="20">20 %</option>
                    <option value="15">15 %</option>
                    <option value="13">13 %</option>
                    <option value="10">10 %</option>
                </select>
            </div>
            <div class="form-group col-sm-3 col-xs-12">
                <label>Saldo</label>
                <input type="number" name="saldo" value="<?php echo $saldo; ?>" id="saldo" class="form-control" placeholder="Saldo" disabled>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3 col-xs-12">
                <label>Plazo</label>
                <select class="form-control select-picker" name="plazo" id="plazo" required onchange="calcularCuota()">
                <option value="<?php echo $plazo; ?>">Meses <?php echo $plazo; ?></option>
                <option value="36">3 años</option>
                <option value="48">4 años</option>
                <option value="60">5 años</option>
                <option value="96">8 años</option>
                </select>
            </div>
            <div class="form-group col-sm-3 col-xs-12">
                <label>Cuota</label>
                <input type="number" name="cuota" value="<?php echo $cuota; ?>"id="cuota" class="form-control" placeholder="Cuota" disabled>
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
  // Expresión regular para verificar el formato "000000000"
  var formatoDUI = /^\d{9}/;

  if (formatoDUI.test(input.value)) {
    input.setCustomValidity('');
  } else {
    input.setCustomValidity('El formato del DUI debe ser 000000000');
  }
}
//SCRIP PARA CALCULAR EL SALDO EN BASE AL MONTO Y INTERES
document.addEventListener('DOMContentLoaded', function () {
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
    document.addEventListener('DOMContentLoaded', function () {
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
document.addEventListener('DOMContentLoaded', function () {
  var formulario = document.getElementById('formulario');
  var saldoInput = document.getElementById('saldo');
  var cuotaInput = document.getElementById('cuota');

  formulario.addEventListener('submit', function () {
    // Habilitar los campos antes de enviar el formulario
    saldoInput.disabled = false;
    cuotaInput.disabled = false;
  });
});
</script>
</body>