<?php
session_start();
require_once 'conexion.php';
require_once 'header.php';
$conn = new mysqli($servername, $username, $password, $dbname);
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
<style>
    .bg-light-gray {
        background-color: #D5D8DC;
        /* Puedes ajustar el color gris claro según tu preferencia */
    }
</style>

<body>
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box clearfix" style="height: 520px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
                <header class="main-box-header clearfix">
                    <h2 class="box-title">Asociados <button class="btn btn-success" id="btnagregar" onclick="window.location.href = 'newsocio.php';"><i class="fa fa-plus-circle"></i> Nuevo Socio</button></h2>
                </header>
                <div class="main-box-body clearfix" id="listadoregistros">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover text-center" id="tbllistado">
                            <thead>
                                <tr>
                                    <th class="text-center bg-light-gray">Opciones</th>
                                    <th class="text-center bg-light-gray">Dui</th>
                                    <th class="text-center bg-light-gray">Nombre</th>
                                    <th class="text-center bg-light-gray">Direccion</th>
                                    <th class="text-center bg-light-gray">Telefono</th>
                                    <th class="text-center bg-light-gray">Estado</th>
                                </tr>


                            </thead>
                            <tbody>
                                <?php
                                // Asegúrate de incluir tu archivo de conexión a la base de datos.

                                // Realizar una consulta para obtener los préstamos.
                                $query = "SELECT * FROM clientes"; // Puedes personalizar esta consulta según tus necesidades.

                                $result = mysqli_query($conn, $query);

                                if (!$result) {
                                    die("Error al ejecutar la consulta: " . mysqli_error($conn));
                                }

                                while ($row = mysqli_fetch_assoc($result)) {

                                ?>
                                    <tr>
                                        <td class="mdl-data-table__cell--non-numeric text-center">
                                            <!-- Enlace para editar -->
                                            <a href="#editar" onclick="confirmarEditar(<?php echo $row['idcliente']; ?>)" class="modal-trigger modal-trigger waves-light">
                                                <i class="fa fa-pencil" style="font-size: 15px; color: blue;"></i>
                                            </a>

                                            <!-- Enlace para eliminar -->
                                            <a href="#eliminar" onclick="confirmarEliminacion(<?php echo $row['idcliente'] ?>)" class="modal-trigger modal-trigger waves-light">
                                                <i class="fa fa-trash" style="font-size: 15px; color: red;"></i>
                                            </a>
                                        </td>
                                        <td> <?php echo $row['idcliente'] ?></td>
                                        <td> <?php echo $row['nombre'] ?></td>
                                        <td> <?php echo $row['direccion'] ?></td>
                                        <td> <?php echo $row['telefono'] ?></td>
                                        <td> <?php echo $row['estado'] ?></td>
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
            function confirmarEditar(idcliente) {
                Swal.fire({
                    title: '¿Estás seguro de editar este elemento?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, editar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var idusuario = <?php echo $_SESSION['idusuario']; ?>;
                        // Redirige a la página de edición incluyendo idcliente en la URL
                        window.location.href = "editarCliente.php?idCliente=" + idcliente + "&idUsuario=" + idusuario;
                    }
                });
            }

            function confirmarEliminacion(idcliente) {
                Swal.fire({
                    title: '¿Estás seguro de eliminar este elemento?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var idusuario = <?php echo $_SESSION['idusuario']; ?>;
                        idcliente = String(idcliente);
                        // Redirige a la página de eliminación incluyendo idcliente en la URL
                        window.location.href = "eliminar.php?idCliente=" + idcliente + "&idUsuario=" + idusuario;
                    }
                });
            }
        </script>
</body>

</html>
<?php require_once 'footer.php'; ?>