<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

//Verificar si el usuario ha iniciado sesion 
if (!isset($_SESSION['_AL_id'])) { 
    header('Location: login.php?Acceso_No_Permitido');
    exit;
}else{

$login = $_SESSION['_AL_login'];
$id_usuario = $_SESSION['_AL_id'];

//Requerir el header 
require 'header.php';
?>
<!-- Inicio Contenido -->
<!--=====================================================================================-->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">

    <div class="card card" id="card_header" style="margin-bottom: 2px; background: #000000; color: white; border-top: 4px solid #fd7e14;">
      <div class="card-header">
          <b>Cambio de Clave</b> 
          <i class="fas fa-unlock-alt"></i>
      </div>
    </div>

          <div class="card-body" id="lista">
            <!--============================= Formulario De Cambio de clave =============================-->
            <form role="form" name="formulario_cambio_clave" id="formulario_cambio_clave" method="POST">
              <div class="row justify-content-center">
                <div class="col-md-6">
                  <div class="col-md-12">
                    <input type="hidden" name="id_usuario" id="id_usuario" class="form-control" 
                    value="<?php echo htmlspecialchars($id_usuario); ?>" readonly> 
                  </div>

                  <!--<div class="col-md-12">
                    <label>Tu Usuario:</label>
                    <input type="text" name="login" id="login" class="form-control" placeholder="Login" maxlength="100" 
                    value="<?php //echo htmlspecialchars($login); ?>" readonly> 
                  </div>-->

                  <div class="form-group col-md-12">
                      <label>Clave actual</label>
                      <div class="input-group mb-3">
                          <input type="password" name="clave_actual" id="clave_actual" class="form-control" 
                          placeholder="Clave Actual" maxlength="16">

                          <div class="input-group-append">
                              <div class="input-group-text">
                                  <span class="fas fa-eye" id="eyeOn0"></span>
                              </div>
                          </div>
                      </div>
                      <span id="message-clave_actual" style="color:red;"></span>
                  </div>

                  <div class="form-group col-md-12">
                      <label>Nueva clave</label>
                      <div class="input-group mb-3">
                          <input type="password" name="clave_nueva" id="clave_nueva" class="form-control" 
                          placeholder="Nueva clave" maxlength="16">

                          <div class="input-group-append">
                              <div class="input-group-text">
                                  <span class="fas fa-eye" id="eyeOn1"></span>
                              </div>
                          </div>
                      </div>
                      <span id="message-clave_nueva" style="color:red;"></span>
                  </div>

                  <div class="form-group col-md-12">
                      <label>Confirmar clave</label>
                      <div class="input-group mb-3">
                          <input type="password" name="rep_clave" id="rep_clave" class="form-control" 
                          placeholder="Confirmar clave" maxlength="16">

                          <div class="input-group-append">
                              <div class="input-group-text">
                                  <span class="fas fa-eye" id="eyeOn2"></span>
                              </div>
                          </div>
                      </div>
                      <span id="message-rep_clave" style="color:red;"></span>
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="btnCambio_clave" id="btnCambio_clave" 
                    class="btn float-right" style="background: #fd7e14; color:white;">
                        Actualizar
                    </button>
                  </div>

                </div>
              </div>

            </form>
            <!--============================= FIN Formulario De Cambio de clave =============================-->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--=====================================================================================-->
<!-- Fin contenido -->
<?php
}
//Requerir el footer
require 'footer.php';
?>
<script type="text/javascript" src="scripts/cambio_clave.js<?php echo '?r='.date('Y-m-d H:i:s');?>"></script>
</body>
</html>
<?php 
ob_end_flush();
?>