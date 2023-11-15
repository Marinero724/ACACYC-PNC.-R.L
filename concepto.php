<?php
session_start();  // Continuar la sesión
// Verificamos si se proporcionó el parámetro 'idCategoria' en la URL
require_once 'conexion.php';
require_once 'header.php';
$conn =mysqli_connect("$DB_HOST", "$DB_USER", "$DB_PASSWORD", "$DB_NAME", "$DB_PORT");
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Inicio Contenido PHP-->
<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <h1 class="box-title">BIENVENIDO</h1>
            </header>
            <?php
            // Generar datos (ejemplo: ventas mensuales)
            $ventas = [150, 200, 250, 180, 300, 270, 200];
            $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio'];
            ?>
            <div class="row">
                <div class="col-6" style="width: 500px;">
                    <canvas id="miGrafico"></canvas>
                </div>
            </div>

            <script>
                // Pasar datos de PHP a JavaScript
                var ventas = <?php echo json_encode($ventas); ?>;
                var meses = <?php echo json_encode($meses); ?>;

                // Configuración del gráfico
                var ctx = document.getElementById('miGrafico').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar', // Tipo de gráfico (puedes cambiarlo a 'line', 'radar', etc.)
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Ventas Mensuales',
                            data: ventas,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Color del gráfico
                            borderColor: 'rgba(75, 192, 192, 1)', // Color de los bordes
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>


        </div>
    </div>
</div>
<!-- Fin Contenido PHP-->
<?php
require 'footer.php';
?>
