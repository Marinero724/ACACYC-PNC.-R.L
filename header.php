<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'conexion.php';

// Crear una conexión
$conn = mysqli_connect("$DB_HOST", "$DB_USER", "$DB_PASSWORD", "$DB_NAME", "$DB_PORT");

if (isset($_SESSION['idusuario'])) {
    $idRol = $_SESSION['idRol'];
    $idUser = $_SESSION['idusuario'];
} else {
    // El usuario no ha iniciado sesión, redirigirlo al formulario de inicio de sesión
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<!-- Mirrored from www.ravijaiswal.com/Afro-v.1.1/tables.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 19 Mar 2017 03:12:20 GMT -->

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Prestamos</title>
    <link rel="stylesheet" type="text/css" href="public/css/bootstrap/bootstrap.min.css" />

    <script src="public/js/demo-rtl.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <link rel="stylesheet" type="text/css" href="public/css/libs/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="public/css/libs/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="public/css/compiled/theme_styles.css" />
    <link rel="stylesheet" href="public/css/libs/daterangepicker.css" type="text/css" />
    <link type="image/x-icon" href="favicon.png" rel="shortcut icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300|Titillium+Web:200,300,400' rel='stylesheet' type='text/css'>

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
  <![endif]-->

    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="public/datatables/jquery.dataTables.min.css">
    <link href="public/datatables/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="public/datatables/responsive.dataTables.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="public/css/bootstrap-select.min.css">

</head>

<body>
    <div id="theme-wrapper" class="position-fixed top-0 start-0 p-3">
        <header class="navbar" id="header-navbar">

            <div class="container">

                <a href="concepto.php" id="logo" class="navbar-brand">ACACYC PNC DE R.L
                </a>

                <div class="clearfix">
                    <button class="navbar-toggle" data-target=".navbar-ex1-collapse" data-toggle="collapse" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="fa fa-bars"></span>
                    </button>
                    <div class="nav-no-collapse navbar-left pull-left hidden-sm hidden-xs">
                        <ul class="nav navbar-nav pull-left">
                            <li>
                                <a class="btn" id="make-small-nav"><i class="fa fa-bars"></i></a>
                            </li>
                        </ul>
                    </div>

                    <div class="nav-no-collapse pull-right" id="header-nav">
                        <ul class="nav navbar-nav pull-left">
                            <li class="dropdown profile-dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="assets/img/avatar-male.png" alt="">
                                    <span class="hidden-xs"><?php echo $_SESSION['user'] ?></span> <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#" onclick="confirmarEditar(<?php echo $_SESSION['idusuario']; ?>)"><i class="fa fa-user"></i>Perfil</a></li>
                                    <li><a href="closeSesion.php"><i class="fa fa-power-off"></i>Cerrar Sesión</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <div id="page-wrapper" class="container fixed-top">
            <div class="row">
                <div id="nav-col">
                    <section id="col-left" class="col-left-nano">
                        <div id="col-left-inner" class="col-left-nano-content">
                            <div id="user-left-box" class="clearfix hidden-sm hidden-xs dropdown profile2-dropdown">
                                <div style="display: flex; justify-content: center; align-items: center; width: 75%; height: 75%;">
                                    <img alt="" src="assets/img/avatar-male.png" width="40" height="50" />
                                </div>

                                <div class="user-box">
                                    <span class="name">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['nombre'] ?> <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" onclick="confirmarEditar(<?php echo $_SESSION['idusuario']; ?>)"><i class="fa fa-user"></i>Perfil</a></li>
                                            <li><a href="closeSesion.php"><i class="fa fa-power-off"></i>Salir</a></li>
                                        </ul>
                                    </span>
                                    <span class="status">
                                        <i class="fa fa-circle"></i> En Linea
                                    </span>
                                </div>
                            </div>
                            <div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav">
                                <ul class="nav nav-pills nav-stacked">
                                    <!-- Opción para todos los roles -->
                                    <?php
                                    // Opciones específicas para cada rol
                                    if ($idRol == 1) {
                                        // Recepcion
                                    ?>
                                        <li>
                                            <a href="clientes.php">
                                                <i class="fa fa-users"></i>
                                                <span>Socios</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-toggle">
                                                <i class="fa fa-bar-chart-o"></i>
                                                <span>Cuentas de Ahorro</span>
                                                <i class="fa fa-angle-right drop-icon"></i>
                                            </a>
                                            <ul class="submenu">
                                                <li>
                                                    <a href="#">
                                                        Abrir Cuenta de Ahorro
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        Consultar Saldo
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        Estado de Cuenta
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                    <?php
                                    } elseif ($idRol == 2) {
                                        // Analista de Creditos
                                    ?>
                                        <li>
                                            <a href="consultarsaldo.php">
                                                Consultar saldo
                                            </a>
                                        </li>
                                        <li>
                                            <a href="pagos.php">
                                                Pago de crédito
                                            </a>
                                        </li>
                                        <li>
                                            <a href="estadocreditos.php">
                                                Estado de Cuenta
                                            </a>
                                        </li>
                                    <?php
                                    } elseif ($idRol == 3) {
                                        //Gestor de cobros
                                    ?>
                                        <li>
                                            <a href="consultarsaldo.php">
                                                Consultar saldo
                                            </a>
                                        <li>
                                            <a href="estadocreditos.php">
                                                Estado de Cuenta
                                            </a>
                                        </li>
                                    <?php
                                    } elseif ($idRol == 4) {
                                        // Atencion al asociado
                                    ?>
                                        <li>
                                            <a href="prestamos.php">
                                                <i class="fa fa-money"></i>
                                                <span>Prestamos</span>

                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" class="dropdown-toggle">
                                                <i class="fa fa-bar-chart-o"></i>
                                                <span>Cuentas de Ahorro</span>
                                                <i class="fa fa-angle-right drop-icon"></i>
                                            </a>
                                            <ul class="submenu">
                                                <li>
                                                    <a href="#">
                                                        Abrir Cuenta de Ahorro
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        Consultar Saldo
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        Estado de Cuenta
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    <?php
                                    } elseif ($idRol == 5) {
                                        // Caja
                                    ?>
                                        <li>
                                            <a href="prestamos.php">
                                                <i class="fa fa-money"></i>
                                                <span>Prestamos</span>

                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" class="dropdown-toggle">
                                                <i class="fa fa-bar-chart-o"></i>
                                                <span>Cuentas de Ahorro</span>
                                                <i class="fa fa-angle-right drop-icon"></i>
                                            </a>
                                            <ul class="submenu">
                                                <li>
                                                    <a href="#">
                                                        Abrir Cuenta de Ahorro
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        Consultar Saldo
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        Estado de Cuenta
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    <?php
                                    } elseif ($idRol == 6) {
                                        // Administrador
                                    ?>
                                        <!--
                                        <li>
                                            <a href="">
                                                <i class="fa fa-dashboard"></i>
                                                <span>Escritorio</span>
                                            </a>
                                        </li>-->

                                        <li>
                                            <a href="clientes.php">
                                                <i class="fa fa-users"></i>
                                                <span>Socios</span>
                                            </a>
                                        </li>

                                        <span>-----------------------------------------------</span>



                                        <li>
                                            <a href="prestamos.php">
                                                <i class="fa fa-money"></i>
                                                <span>Prestamos</span>

                                            </a>
                                            <!-- 
                                            <a href="#" class="dropdown-toggle">
                                                <i class="fa fa-check"></i>
                                                <span>Pagos</span>
                                                <i class="fa fa-angle-right drop-icon"></i>
                                            </a>-->
                                        <li>
                                            <a href="consultarsaldo.php">
                                                <i class=" fa fa-check"> </i>
                                                <span>Consultar saldos</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="pagos.php">
                                                <i class=" fa fa-check"> </i>
                                                <span>pago de credito</span>
                                            </a>
                                        </li>

                                        <!-- <li>
                                                    <a href="estadocreditos.php">
                                                        Estado de Cuenta
                                                    </a>
                                                </li> -->

                                        </li>
                                        <span>-----------------------------------------------</span>
                                        <li>
                                            <a href="usuarios.php">
                                                <i class="fa fa-user"></i>
                                                <span>Usuarios</span>
                                            </a>
                                        </li>
                                        <!--
                                        <li>
                                            <a href="gastos.php">
                                                <i class="fa fa-bullhorn"></i>
                                                <span>Gastos</span>
                                            </a>
                                        </li>-->
                                        <span>-----------------------------------------------</span>
                                        <li>

                                        <li>
                                            <a href="cuentaahorro.php">
                                                <i class=" fa fa-bar-chart-o"> </i>
                                                <span>Abrir Cuenta de Ahorro</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="aporte.php">
                                                <i class=" fa fa-check"> </i>
                                                <span>Aporte de Ahorro</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="ecahorro.php">
                                                <i class=" fa fa-check"> </i>
                                                <span>consultar aportaciones</span>
                                            </a>
                                        </li>
                                        </li>
                                    <?php
                                    } else {
                                        $errorMessage  = "Lo sentimos Rol no esperado";
                                        echo '<script>alert("' . $errorMessage  . '");</script>';
                                        $redirectionPage = 'closeSesion.php';
                                        echo '<script>window.location.href = "' . $redirectionPage . '";</script>';
                                    }
                                    ?>

                                    <!-- 
                                    <li>
                                        <a href="#" class="dropdown-toggle">
                                            <i class="fa fa-bar-chart-o"></i>
                                            <span>Cuentas de Ahorro</span>
                                            <i class="fa fa-angle-right drop-icon"></i>
                                        </a>
                                        <ul class="submenu">
                                            <li>
                                                <a href="#">
                                                    Abrir Cuenta de Ahorro
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    Consultar Saldo
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    Estado de Cuenta
                                                </a>
                                            </li>
                                        </ul>
                                    </li> 
                                -->
                                </ul>
                            </div>
                        </div>
                    </section>
                    <div id="nav-col-submenu"></div>
                </div>
                <!-- Inicio Wrapper -->
                <div id="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Fin header PHP -->
                        </div>
                        <script>
                            function confirmarEditar(idusuario) {
                                if (confirm("¿Estás seguro de que deseas editar este elemento?")) {
                                    // Obten el valor de idusuario desde la sesión PHP
                                    var idlogin = <?php echo $_SESSION['idusuario']; ?>;
                                    // Redirige a la página de edición incluyendo idusuario en la URL
                                    window.location.href = "editarUsuario.php?idUser=" + idlogin + "&idUsuario=" + idlogin;
                                } else {
                                    // El usuario hizo clic en "Cancelar", no se realiza ninguna acción
                                }
                            }
                            // Configura el tiempo de inactividad en milisegundos (por ejemplo, 5 minutos)
                            var tiempoInactividad = 2 * 60 * 1000; // 5 minutos en milisegundos

                            // Inicializa el temporizador
                            var temporizadorInactividad;

                            // Función para restablecer el temporizador cuando hay actividad
                            function resetearTemporizador() {
                                clearTimeout(temporizadorInactividad);
                                temporizadorInactividad = setTimeout(cerrarSesion, tiempoInactividad);
                            }

                            // Función para mostrar SweetAlert con redirección
                            function mostrarCerrarSesionAlert() {
                                Swal.fire({
                                    title: 'Cerrar Sesión',
                                    text: 'La sesión se cerró debido a inactividad.',
                                    icon: 'info',
                                    showCancelButton: false,
                                    confirmButtonText: 'Ir a la página de inicio de sesión'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "closeSesion.php";
                                    }
                                });
                            }

                            // Llama a esta función cuando quieras cerrar la sesión
                            function cerrarSesion() {
                                // Aquí puedes agregar el código para cerrar la sesión del usuario
                                mostrarCerrarSesionAlert();
                            }

                            // Agrega eventos para detectar actividad del usuario
                            document.addEventListener("mousemove", resetearTemporizador);
                            document.addEventListener("keypress", resetearTemporizador);

                            // Inicia el temporizador cuando carga la página
                            resetearTemporizador();
                        </script>

</html>
