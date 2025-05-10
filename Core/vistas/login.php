<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Gestor | Inicio sesion</title>
    <!-- favicon -->
    <link type="image/x-icon" href="../public/images/favicon.png" rel="shortcut icon" />
    
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
<body class="hold-transition login-page" 
style="background: rgb(253,126,20);
background: linear-gradient(0deg, rgba(253,126,20,1) 0%, rgba(0,0,0,1) 57%);">
<!--==============================================================================================-->
<div class="login-box">

<div class="card" style="border-radius: 15px; border-top: 5px solid #fd7e14;">
    <div class="card-body login-card-body">
        <p class="login-box-msg" style="cursor: default;">Entrar al Sistema</p>

        <form name="formulario_login" id="formulario_login" method="POST">
            <div class="input-group mb-3">
                <label>Usuario</label>
                <div class="input-group mb-3">
                    <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Ingresar Usuario" maxlength="250">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <span id="message-usuario" style="color:red;"></span>
            </div>
            <div class="input-group mb-3">
                <label>Clave</label>
                <div class="input-group mb-3">
                    <input type="password" name="clave" id="clave" class="form-control" placeholder="Ingresar Clave" maxlength="20">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-eye" id="eyeOn0"></span>
                        </div>
                    </div>
                </div>
                <span id="message-clave" style="color:red;"></span>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" id="btnEntrar" class="btn btn-block" 
                        style="background: #fd7e14; color:white;">Entrar
                    </button>
                </div>
            </div>
        </form>
    
        
        <div class="social-auth-links text-center mb-3">
            <img src="../public/images/logo.png" class="img-fluid" alt="Descripción de la imagen" />
            <p class="mt-3"></p>
        </div>
    </div>
</div>

</div>
<!--======================= SCRIPTS =======================-->
<!-- jQuery -->
<script src="../public/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../public/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../public/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<!--<script src="../public/plugins/sparklines/sparkline.js"></script>-->
<!-- JQVMap -->
<script src="../public/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../public/plugins/jqvmap/maps/jquery.vmap.south-america.js"></script>
<!-- jQuery Knob Chart -->
<script src="../public/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../public/plugins/moment/moment.min.js"></script>
<script src="../public/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../public/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="../public/dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="../public/dist/js/demo.js"></script>
<!-- inputmask -->
<script src="../public/plugins/inputmask/jquery.inputmask.bundle.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../public/js/bootstrap-select.min.js"></script> 
<script src="../public/plugins/select2/js/select2.full.min.js"></script> 
<!-- DATATABLES -->
<script src="../public/plugins/datatables/jquery.dataTables.min.js"></script>    
<script src="../public/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../public/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../public/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="../public/plugins/jszip/jszip.min.js"></script>
<script src="../public/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../public/plugins/pdfmake/vfs_fonts.js"></script> 
<script src="../public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../public/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../public/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../public/plugins/jszip/jszip.min.js"></script>
<script src="../public/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../public/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../public/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../public/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../public/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- BOOTBOX -->
<script src="../public/js/bootbox.min.js"></script> 
<!-- SweetAlert2 -->
<script src="../public/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- SELECT -->
<script src="../public/js/bootstrap-select.min.js"></script> 
<!-- CHART -->
<script src="../public/plugins/chart.js/Chart.min.js"></script>

<script type="text/javascript" src="scripts/login.js<?php echo '?r='.date('Y-m-d H:i:s');?>"></script>
</body>
</html>