<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

//Verificar si el usuario ha iniciado sesion 
if (!isset($_SESSION['_AL_id'])) { 
    header('Location: login.php?Acceso_No_Permitido');
    exit;
}else{

//Requerir el header 
require 'header.php';
?>
<!-- Inicio Contenido -->
<section class="content">
  <div class="container-fluid">



    <!--==---------------------------------------------------------------------------------==-->
    <div class="card card" id="card_header" style="margin-bottom: 2px; background: #000000; color: white; border-top: 4px solid #fd7e14;">
      <div class="card-header">
        <button class="btn" id="btnagregar" onclick="registrar(true)" name="btnAgregar" style="background: #fd7e14; color:white;">
          <i class="fa fa-plus-circle"></i> Agregar Nuevo Registro
        </button>
        <b>Sub Categorias</b>
      </div>
    </div>
    <!--==---------------------------------------------------------------------------------==-->

  <!--========================================== Tabla ==========================================-->
  <div class="container-fluid" id="tabla">
    <div class="row">
      <div class="col-12">
        <div class="card" id="listadoregistros">

          <div class="card-body" id="contenedorDatatable">
           <table id="datatable" class="table table-bordered table-hover">
            <thead>
              <tr align="center">
                <th>Categoria</th>
                <th>Sub Categoria</th>
                <th>Productos relacionados</th>
                <!--<th class="noExport">Opciones</th>-->
              </tr>
            </thead>

            <tbody>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <!--<td></td>--><!--Opciones-->                         
              </tr>                      
            </tbody>

            <tfoot>  
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<!--========================================== Contenedor Formulario ==========================================-->
<div class="card card-navy" id="formularioregistros">  

  <div class="card-header" style="background: #000000; color: white; border-top: 4px solid #fd7e14;">
    <b>Formulario de Sub Categorias</b>
  </div>

  <!--===================== Formulario De Registro y Edicion =====================-->
      <form name="formularioREG" id="formularioREG" method="POST">
        <div class="card-body"> 
          <div class="row">
          <!--======== Campos ocultos ========-->
          <input type="hidden" name="id_sub_categoria" id="id_sub_categoriaR" class="form-control" readonly> 
        </div>

        <div class="row">
          <div class="form-group col-sm-3 col-xs-12">
            <label>Sub Categoria</label>
            <input type="text" name="sub_categoria" id="sub_categoriaR" class="form-control" placeholder="Ingresar sub categoria" 
            maxlength="100" required> 
          </div>
        </div>
      
          <div class="row" id="tablaCAT">
              <div class="col-12">
                <div class="table-responsive" id="contenedorDatatable">
                  <table id="datatableCAT" class="table table-bordered table-hover">
                    <thead>
                    <tr align="center">
                        <th>#</th>
                        <th>Categoria</th>
                        <th class="noExport">
                          <label for="chkAll" class="ms-2">Seleccionar Todo</label>
                          <input type="checkbox" id="chkAll" style="margin-left: 5px;" class="largerCheckbox">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td><!--Checkboxs-->                         
                    </tr>                      
                    </tbody>
                  </table>
                </div>
              </div>
          </div>

        <div class="card-footer">
          <button class="btn float-right" style="background: #fd7e14; color:white;" type="submit" id="btnGuardar">
            <i class="fa fa-save"></i> Guardar
          </button>

          <button class="btn btn-danger float-left" id="cancelformR" onclick="Cancelarform();" type="button">
            <i class="fa fa-arrow-circle-left"></i>Cancelar
          </button>
        </div>

      </div>
    </form>
<!--========================================== FIN Formulario De Registro Y Edicion ==========================================-->
</div>

</div>
</section>
<!-- Fin contenido -->
<?php
}
//Requerir el footer
require 'footer.php';
?>
<script type="text/javascript" src="scripts/sub_categorias.js<?php echo '?r='.date('Y-m-d H:i:s');?>"></script>
</body>
</html>
<?php 
ob_end_flush();
?>