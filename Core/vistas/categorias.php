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
        <b>Categorias</b>
      </div>
    </div>
    <!--==---------------------------------------------------------------------------------==-->
    <div class="col-12" id="formulariobusqueda" style="margin-bottom: -13px;">
      <div class="card card-outline card-orange collapsed-card">

        <div class="card-header">
          <h3 class="card-title">Opciones de Busqueda</h3>
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-search text-white bg-orange p-2 rounded shadow"></i>
            </button>
        </div>

        <div class="card-body">
          <!--========================================== Formulario De Consulta ==========================================-->
  <form role="form" name="formulario_consulta" id="formulario_consulta" method="POST">
<div class="row">
        <div class="form-group col-md-3 col-sm-6 col-xs-1">
          <label>Estado</label>
            <select name="status" id="status" class="form-control">
               <option value="">Seleccione el estado</option>
               <option value="1">Activo</option>
               <option value="0">Inactivo</option>
           </select>
        </div>

        <div class="form-group col-sm-3 col-xs-12">
          <label>Categoria</label>
          <input type="text" name="categoria" id="categoria" class="form-control" placeholder="Ingresar categoria" 
          maxlength="100" required> 
        </div>
</div>
</form>
        <!--========================================== FIN Formulario De Consulta ==========================================-->
        <div class="card-footer">
          <button type="submit" name="btnbuscar" id="btnbuscar" class="btn float-right" onclick="listar()" style="background: #fd7e14; color:white;">
          <i class="fas fa-search"></i>Buscar
          </button>

          <button type="submit" name="btnbuscar" id="btnbuscar" class="btn btn-danger float-left" onclick="limpiarFormBuscar()">
            <i class="fa fa-eraser"></i>Limpiar
          </button>
        </div>
      </div>
    </div>
  </div>

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
                <th>Estado</th>
                <th class="noExport">Opciones</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td></td>
                <td></td>
                <td></td><!--Opciones-->                         
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
    <b>Formulario de categorias</b>
  </div>

  <!--===================== Formulario De Registro y Edicion =====================-->
      <form name="formularioREG_EDIT" id="formularioREG_EDIT" method="POST">
        <div class="card-body"> 
          <div class="row">
          <!--======== Campos ocultos ========-->
          <input type="hidden" name="id_categoria" id="id_categoria" class="form-control" readonly> 
        </div>

        <div class="row">
          <div class="form-group col-sm-3 col-xs-12">
            <label>Categoria</label>
            <input type="text" name="categoria" id="categoriaR" class="form-control" placeholder="Ingresar categoria" 
            maxlength="100" required> 
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
<script type="text/javascript" src="scripts/categorias.js<?php echo '?r='.date('Y-m-d H:i:s');?>"></script>
</body>
</html>
<?php 
ob_end_flush();
?>