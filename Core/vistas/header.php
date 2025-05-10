<?php
//Verificar si el usuario ha iniciado sesion 
if (!isset($_SESSION['_AL_id'])) { 
  header("Location: login.php?Acceso_No_Permitido");
  exit;
}

$usuario = $_SESSION['_AL_login'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gestor</title>
    <!-- favicon -->
    <link type="image/x-icon" href="../public/images/favicon.png" rel="shortcut icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../public/dist/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="../public/dist/css/fonts_googleapis_com.css">
    <!-- Select2 -->                              
    <link rel="stylesheet" href="../public/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../public/plugins/sweetalert2/sweetalert2.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../public/plugins/jqvmap/jqvmap.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../public/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../public/plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="../public/mapa.css">
</head>
<!-- Estilos css para centrar el boton salir -->
<style type="text/css">
.dropdown-menu .salir {
    display: flex;
    justify-content: center;
    background-color: #ecfbff;
}
</style>
<body class="hold-transition sidebar-mini layout-fixed text-sm">
    <div class="wrapper" id="theme-wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-secondary" style="background: #000000;">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="concepto.php" class="nav-link">Inicio</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Opciones <i class="fas fa-wrench"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="cambio_de_clave.php">Cambio de clave <i class="fas fa-lock"></i></a>
                    <div class="dropdown-divider"></div>
                        <a class="dropdown-item salir" href="../ajax/login.php?op=salir">Salir</a>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-secondary elevation-4" style="background: #000000;">
            <!-- Brand Logo -->
            <a href="#" class="brand-link navbar-secondary" style="cursor: default; background: #000000;">
                <img src="../public/images/logo.png" alt="" class="brand-image elevation-3" style="opacity: .8">
                <span class="brand-text">Gestor de inventario</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../public/images/default.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <span class="right badge badge-success" style="margin-bottom: 5px;">En Línea</span> 
                        <a href="#" class="d-block"><?php echo htmlspecialchars($usuario); ?></a>
                    </div>
                </div>


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-compact" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="concepto.php" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Inicio
                                <!--<span class="right badge badge-info">New</span> -->
                            </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="categorias.php" class="nav-link">
                            <i class="nav-icon fas fa-list"></i>
                            <p>
                                Agregar Categorias
                                <!--<span class="right badge badge-info">New</span> -->
                            </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sub_categorias.php" class="nav-link">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>
                                Agregar Sub Categorias
                                <!--<span class="right badge badge-info">New</span> -->
                            </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="productos.php" class="nav-link">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>
                                Agregar Productos
                                <!--<span class="right badge badge-info">New</span> -->
                            </p>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">

<!--============================ a continuacion van las Vistas ============================-->