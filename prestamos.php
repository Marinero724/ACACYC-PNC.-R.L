<?php
session_start();
require_once 'conexion.php';
require_once 'header.php';
// Crear una conexión
$conn = mysqli_connect("$DB_HOST", "$DB_USER", "$DB_PASSWORD", "$DB_NAME", "$DB_PORT");
if (isset($_SESSION['idusuario'])) {
} else {
    // El usuario no ha iniciado sesión, redirigirlo al formulario de inicio de sesión
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Agregar enlaces a FontAwesome CSS -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Tu otro código del encabezado -->
</head>

<body>
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box clearfix" style="height: 520px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
                <header class="main-box-header clearfix">
                    <h2 class="box-title">Prestamos <button class="btn btn-success" id="btnagregar" onclick="window.location.href = 'newPrestamo.php';"><i class="fa fa-plus-circle"></i> Nuevo</button></h2>
                </header>
                <div class="main-box-body clearfix" id="listadoregistros">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="tbllistado">
                            <thead>
                                <tr>
                                    <th>DUI Socio</th>
                                    <th>Nombre Socio</th>
                                    <th>Direccion</th>
                                    <th>Telefono</th>
                                    <th>Fecha Prestamo</th>
                                    <th>Monto</th>
                                    <th>Interes</th>
                                    <th>Saldo</th>
                                    <th>Fecha Pago</th>
                                    <th>Cuota</th>
                                    <th>Plazo</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Asegúrate de incluir tu archivo de conexión a la base de datos.

                                // Realizar una consulta para obtener los préstamos.
                                $query = "SELECT prestamo.idcliente,cuota,fpago,fprestamo,interes,monto,plazo,saldo, clientes.nombre, clientes.direccion,clientes.telefono
                            FROM prestamo                            
                            INNER JOIN clientes ON clientes.idcliente = prestamo.idcliente ;"; // Puedes personalizar esta consulta según tus necesidades.

                                $result = mysqli_query($conn, $query);

                                if (!$result) {
                                    die("Error al ejecutar la consulta: " . mysqli_error($conn));
                                }

                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr>
                                        <!-- Columna de opciones con enlace de editar 
                                    <td class="mdl-data-table__cell--non-numeric">
                                        <a href="#editar" onclick="confirmarEditar(<?/*php echo $row['idprestamo']; */ ?>)">
                                            <i class="fa fa-pencil" style="font-size: 15px;"></i>
                                        </a>
                                         Enlace para eliminar 
                                        <a href="#eliminar" onclick="confirmarEliminacion(<?/*php echo $row['idprestamo']; */ ?>)">
                                            <i class="fa fa-trash" style="font-size: 15px;"></i>
                                        </a>-->
                                        </td>
                                        <td> <?php echo $row['idcliente'] ?></td>
                                        <td> <?php echo $row['nombre'] ?></td>
                                        <td> <?php echo $row['direccion'] ?></td>
                                        <td> <?php echo $row['telefono'] ?></td>
                                        <td> <?php echo $row['fprestamo'] ?></td>
                                        <td> <?php echo $row['monto'] ?></td>
                                        <td> <?php echo $row['interes'] ?></td>
                                        <td> <?php echo $row['saldo'] ?></td>
                                        <td> <?php echo $row['fpago'] ?></td>
                                        <td> <?php echo $row['cuota'] ?></td>
                                        <td> <?php echo $row['plazo'] ?></td>
                                    </tr>
                                <?php
                                }

                                echo '</tbody>
                            </table>
                        </div>
                    </div>';
                                // Cerrar la conexión a la base de datos.
                                mysqli_close($conn);
                                ?>

                                <div class="main-box-body clearfix" id="formularioregistros">
                                    <!-- Tu formulario de registros aquí -->
                                </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function confirmarEliminacion(idprestamo) {
                if (confirm("¿Estás seguro de que deseas eliminar este elemento?")) {
                    // Obten el valor de idusuario desde la sesión PHP
                    var idusuario = <?php echo $_SESSION['idusuario']; ?>;

                    // Redirige a la página de eliminación incluyendo idusuario en la URL
                    window.location.href = "eliminar.php?idPrestamo=" + idprestamo + "&idUsuario=" + idusuario;
                } else {
                    // El usuario hizo clic en "Cancelar", no se realiza ninguna acción
                }
            }

            function confirmarEditar(idprestamo) {
                if (confirm("¿Estás seguro de que deseas editar este elemento?")) {
                    // Obten el valor de idusuario desde la sesión PHP
                    var idusuario = <?php echo $_SESSION['idusuario']; ?>;

                    // Redirige a la página de eliminación incluyendo idusuario en la URL
                    window.location.href = "editarPrestamo.php?idPrestamo=" + idprestamo + "&idUsuario=" + idusuario;
                } else {
                    // El usuario hizo clic en "Cancelar", no se realiza ninguna acción
                }
            }
        </script>
</body>

</html>
<?php
//Para cambiar el color y poder desplegar la opcion de cierre de sesion
require_once 'footer.php';

?>
