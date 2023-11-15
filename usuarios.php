<?php
session_start();
require_once 'conexion.php';
require_once 'header.php';
// Crear una conexión
$conn = mysqli_connect("$DB_HOST", "$DB_USER", "$DB_PASSWORD", "$DB_NAME", "$DB_PORT");
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
            <div class="main-box clearfix">
                <header class="main-box-header clearfix">
                    <h2 class="box-title">Usuarios <button class="btn btn-success" id="btnagregar" onclick="window.location.href = 'newusuario.php';"><i class="fa fa-plus-circle"></i> Nuevo Usuario</button></h2>
                </header>
                <div class="main-box-body clearfix" id="listadoregistros">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="tbllistado">
                            <thead>
                                <tr>
                                    <th class="text-center bg-light-gray">Opciones</th>
                                    <th class="text-center bg-light-gray">Nombre</th>
                                    <th class="text-center bg-light-gray">Departamento</th>
                                    <th class="text-center bg-light-gray">Telefono</th>
                                    <th class="text-center bg-light-gray">Usuario</th>
                                    <th class="text-center bg-light-gray">Contraseña</th>
                                    <th class="text-center bg-light-gray">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Asegúrate de incluir tu archivo de conexión a la base de datos.

                                // Realizar una consulta para obtener los préstamos.
                                $query = "SELECT * FROM usuario  "; // Puedes personalizar esta consulta según tus necesidades.

                                $result = mysqli_query($conn, $query);

                                if (!$result) {
                                    die("Error al ejecutar la consulta: " . mysqli_error($conn));
                                }

                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr class="mdl-data-table__cell--non-numeric text-center">
                                        <!-- Columna de opciones con enlace de editar -->
                                        <td class="mdl-data-table__cell--non-numeric">
                                            <a href="#editar" onclick="confirmarEditar(<?php echo $row['idusuario']; ?>)" class="modal-trigger modal-trigger waves-light">
                                                <i class="fa fa-pencil" style="font-size: 15px; color: blue;"></i>
                                            </a>
                                            <!-- Enlace para eliminar -->
                                            <a href="#eliminar" onclick="confirmarEliminacion(<?php echo $row['idusuario']; ?>)" class="modal-trigger modal-trigger waves-light">
                                                <i class="fa fa-trash" style="font-size: 15px; color: red;"></i>
                                            </a>
                                        </td>
                                        <td> <?php echo $row['nombre'] ?></td>
                                        <td> <?php echo $row['departamento'] ?></td>
                                        <td> <?php echo $row['telefono'] ?></td>
                                        <td> <?php echo $row['user'] ?></td>
                                        <td> <?php echo $row['pass'] ?></td>
                                        <td> <?php echo $row['estado'] == 1 ? 'Activo' : 'Inactivo'; ?></td>
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
            function confirmarEliminacion(idusuario) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'No podrás revertir esto',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminarlo'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Obten el valor de idusuario desde la sesión PHP
                        var idlogin = <?php echo $_SESSION['idusuario']; ?>;
                        // Redirige a la página de eliminación incluyendo idusuario en la URL
                        window.location.href = "eliminar.php?idUser=" + idusuario + "&idUsuario=" + idlogin;
                    }
                });
            }

            function confirmarEditar(idusuario) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Que quieres editar este campo',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, editar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Obten el valor de idusuario desde la sesión PHP
                        var idlogin = <?php echo $_SESSION['idusuario']; ?>;
                        // Redirige a la página de edición incluyendo idusuario en la URL
                        window.location.href = "editarUsuario.php?idUser=" + idusuario + "&idUsuario=" + idlogin;
                    }
                });
            }
        </script>
</body>

</html>
<?php
//Para cambiar el color y poder desplegar la opcion de cierre de sesion
require_once 'footer.php';

?>