<?php
session_start();
require_once 'conexion.php';
require_once 'header.php';

?>

<body>
    <div class="main-box-body clearfix text-center" id="formularioregistros">

        <h1> APORTES</h1>
        <form name="formulario" action="ecahorro.php" id="formulario" method="POST">
            <div class="row">
                <div class="form-group col-md-3 col-sm-9 col-xs-12">
                    <label>Dui Socio</label>
                    <input type="text" name="id" value="" class="form-control" required oninput="s(this)">
                </div>
                <div class="form-group col-md-2 col-sm-9 col-xs-12">
                    <button class="btn btn-primary" type="submit" name="buscar" id="buscar"><i class="fa fa-search"></i> Buscar</button>
                </div>

        </form>
        <div class="row">

            <div class="form-group col-xs-12">
                <div class="main-box-body clearfix" id="listadoregistros" style=" height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
                    <div class="table-responsive">
                        <?php
                        // Verificar si se ha enviado el formulario
                        if (isset($_POST['buscar'])) {

                            // Recuperar el término de búsqueda
                            $id = $_POST['id'];

                            // Verificar la conexión
                            if ($conn->connect_error) {
                                die("Error de conexión: " . $conn->connect_error);
                            }

                            // Realizar la consulta SQL
                            $consulta = "SELECT aportes.fecha,
                            aportes.aporte,
                            aportes.saldo,
                            clientes.nombre,
                            clientes.idcliente,
                            cuentasdeahorro.idcuenta
                            from aportes 
                            inner join clientes on clientes.idcliente = aportes.idcliente
                            inner join cuentasdeahorro on cuentasdeahorro.idcliente=aportes.idcliente
                            
                            WHERE clientes.idcliente = '$id'";
                            $resultado = $conn->query($consulta);

                            // Mostrar los resultados en una tabla
                            echo "<table class='table table-striped table-bordered table-condensed table-hover' id='tbllistado' border='1'>
                                <tr>
                                    <th>DUI</th>
                                    <th>N° Cuenta</th>
                                    <th>Nombre</th>
                                    <th>fecha de pago</th>
                                    <th>aporte </th>
                                    <th>saldo</th>
                                    
                                    <!-- Agrega más columnas según tu tabla -->
                                </tr>";

                            while ($fila = $resultado->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$fila['idcliente']}</td>
                                    <td>{$fila['idcuenta']}</td>
                                    <td>{$fila['nombre']}</td>
                                    <td>{$fila['fecha']}</td>
                                    <td>{$fila['aporte']}</td>
                                    <td>{$fila['saldo']}</td>
                                    
                                    <!-- Agrega más celdas según tu tabla -->
                                </tr>";
                            }

                            echo "</table>";
                            // Cerrar la conexión



                            //$conn->close();


                        }

                        if (isset($_POST['estado'])) {
                        }

                        ?>
                    </div>
                </div>

            </div>
        </div>
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
<?php require_once 'footer.php'; ?>