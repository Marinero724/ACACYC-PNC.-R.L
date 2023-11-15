<?php
session_start();  // Continuar la sesión
// Verificamos si se proporcionó el parámetro 'idCategoria' en la URL
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

if (isset($_GET['idUser']) && isset($_GET['idUsuario'])) {
    global $idUser;
    $idUser = $_GET['idUser'];
    $idUsuario = $_GET['idUsuario'];
    $idRol = $_SESSION['idRol'];
    $idRolValidar = $_SESSION['idRol'];

    $sqlUsuario = "SELECT * FROM usuario WHERE idusuario = $idUser";
    if ($result = mysqli_query($conn, $sqlUsuario)) {
        // Comprueba si se obtuvieron resultados
        if (mysqli_num_rows($result) > 0) {
            // Obtiene la primera fila de resultados
            $row = mysqli_fetch_assoc($result);
            // Asigna los valores a las variables para usar en el formulario
            $idUser = $row['idusuario'];
            $idPermiso = $row['idPermiso'];
            $nombre = $row['nombre'];
            $depa = $row['departamento'];
            $telefono = $row['telefono'];
            $user = $row['user'];
            $pass = $row['pass'];
            $estado = $row['estado'];

            // Asignar el valor de $_SESSION['idPermiso'] a $idRolValidar
            $idRolValidar = (isset($idRolValidar) && $idRolValidar == 6) ? $idPermiso : $idRolValidar;

            // Determinar el tipo según el valor de $idPermiso con switch
            switch ($idRolValidar) {
                case 1:
                    $tipo = 'Recepcion';
                    break;
                case 2:
                    $tipo = 'Analista de creditos';
                    break;
                case 3:
                    $tipo = 'Gestor de cobros';
                    break;
                case 4:
                    $tipo = 'Atencion al cliente';
                    break;
                case 5:
                    $tipo = 'Cajas';
                    break;
                case 6:
                    $tipo = 'Supervisor';
                    break;
                default:
                    $tipo = '-';
            }
        } else {
            mostrarSweetAlert("error", "No se encontraron resultados para el idUsuario: $iduser" . mysqli_error($conn), "clientes.php");
        }
    } else {
        mostrarSweetAlert("error", "Error en la consulta: " . mysqli_error($conn));
    }
} else if (isset($_POST['submit']) && isset($_SESSION['idRol'])) {
    //Capturamos la variable de sesion
    $idMiId = ($_SESSION['idRol']);
    // Capturar los valores del formulario.
    $idUs = mysqli_real_escape_string($conn, $_POST['idUs']);
    $nombre = mysqli_real_escape_string($conn, $_POST['name']);
    $depa = mysqli_real_escape_string($conn, $_POST['dep']);
    $telefono = mysqli_real_escape_string($conn, $_POST['tel']);
    $rol = mysqli_real_escape_string($conn, $_POST['rol']);
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $estado = mysqli_real_escape_string($conn, $_POST['estado']);

    // Ahora puedes utilizar estas variables para realizar tu lógica de actualización en la base de datos
    // ...

    // Ejemplo de cómo imprimir los valores capturados
    // echo "Antes de hacer el update <br>";
    // echo "IDActualizarUser: $idUs<br>";
    // echo "Nombre: $nombre<br>";
    // echo "Departamento: $depa<br>";
    // echo "Teléfono: $telefono<br>";
    // echo "Rol: $rol<br>";
    // echo "Usuario: $user<br>";
    // echo "Estado: $estado<br><br>";
    // echo "Mi ID: $idMiId<br><br>";


    // Consulta SQL de Update
    // Consulta de actualización
    $updateUser = "UPDATE usuario SET nombre = '$nombre', departamento = '$depa', telefono = '$telefono', idPermiso = '$rol', user = '$user', estado = '$estado' WHERE idusuario = '$idUs'";
    // Ejecuta la consulta
    if (mysqli_query($conn, $updateUser)) {
        // La inserción se realizó con éxito
        $redirectionPage = ($idMiId != 6) ? 'concepto.php' : 'usuarios.php';
        mostrarSweetAlert("success", "Usuario fue actualizado con exito.", $redirectionPage);
        //$conn->close();
    } else {
        // Ocurrió un error
        $redirectionPage = ($idRolValidar != 6) ? 'concepto.php' : 'usuarios.php';
        mostrarSweetAlert("error", "Error al actualizar el usuario." . mysqli_error($conn), $redirectionPage);
    }
}
?>
<div class="main-box-body clearfix text-center" id="formularioregistros">
    <h2>Formulario para editar un usuario</h2>
    <form action="editarUsuario.php" method="POST">
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
                <input type="text" name="name" id="name" style="text-align: center;" value="<?php echo $nombre; ?>" class="form-control" placeholder="" required>
                <input type="hidden" id="valor">
            </div>

            <div class="form-group col-sm-6 col-xs-12">
                <label>Departamento</label>
                <input type="text" name="dep" id="dep" style="text-align: center;" value="<?php echo $depa; ?>" class="form-control" placeholder="" required>
                <input type="hidden" id="valor">
            </div>

        </div>

        <div class="row">
            <div class="form-group col-sm-6 col-xs-12">
                <label>telefono</label>
                <input type="text" name="tel" id="tel" style="text-align: center;" value="<?php echo $telefono; ?>" class="form-control" placeholder="" required>
                <input type="hidden" id="valor">
            </div>
            <div class="form-group col-sm-6 col-xs-12">
                <label>Usuario</label>
                <select class="form-control select-picker" name="rol" id="rol" <?php echo ($idRol == 6) ? '' : 'disabled'; ?>>
                    <option value="<?php echo $idPermiso ?>" style="text-align: center;"><?php echo $tipo ?></option>
                    <option value="1" <?php echo ($idRolValidar == 6) ? '' : 'disabled'; ?>>Recepcion</option>
                    <option value="2" <?php echo ($idRolValidar == 6) ? '' : 'disabled'; ?>>Analista de créditos</option>
                    <option value="3" <?php echo ($idRolValidar == 6) ? '' : 'disabled'; ?>>Gestor de cobros</option>
                    <option value="4" <?php echo ($idRolValidar == 6) ? '' : 'disabled'; ?>>Atencion al cliente</option>
                    <option value="5" <?php echo ($idRolValidar == 6) ? '' : 'disabled'; ?>>Cajas</option>
                    <option value="6">Supervisor</option>
                </select>

            </div>




        </div>
        <div class="row">

            <div class="form-group col-sm-6 col-xs-12">
                <label>usuario</label>
                <input type="text" name="user" id="user" style="text-align: center;" value="<?php echo $user; ?>" class="form-control" placeholder="" required>
                <input type="hidden" id="valor">
            </div>
            <?php
            // Supongamos que tienes $idRolValidar definido antes de este punto

            if ($idRol == 6) {
                // Muestra el campo "Estado" solo si $idRolValidar es igual a 6
            ?>
                <div class="form-group col-sm-6 col-xs-12">
                    <label>Estado</label>
                    <select class="form-control" style="text-align: center;" name="estado" id="estado" required>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
            <?php
            }
            ?>
            <div class="form-group col-sm-6 col-xs-12" style="display: none;">
                <label>idUsuario</label>
                <input type="text" name="idUs" id="idUs" style="text-align: center;" value="<?php echo $idUser; ?>" class="form-control" placeholder="" required>
                <input type="hidden" id="valor">
            </div>




        </div>

        <div class="form-group col-xs-12">
            <button class="btn btn-primary" name="submit" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Actualizar</button>
            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
        </div>
        <script>
            function cancelarform() {
                // Redirige a la página anterior en el historial del navegador
                history.back();
            }
        </script>

    </form>
</div>

</html>
<?php
//Para cambiar el color y poder desplegar la opcion de cierre de sesion
require_once 'footer.php';

?>
