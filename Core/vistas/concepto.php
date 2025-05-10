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
<!--=====================================================================================-->
<section>
   <div class="container">

        <div class="row">
          <div class="col-12 col-sm-12">
            <div class="card card-orange card-outline card-outline-tabs">
              <!-- ================= Botones del tab ================= -->
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-01-tab" data-toggle="pill" href="#custom-tabs-01" role="tab" 
                    aria-controls="custom-tabs-01" aria-selected="false">Principal</a>
                  </li>
                  <!--nota: se puede agregar esta clase (nav-link tab-disable) para deshabilitar el tab -->
                  <li class="nav-item">
                    <a class="nav-link tab-disable" id="custom-tabs-02-tab" data-toggle="pill" href="#custom-tabs-02" role="tab" 
                    aria-controls="custom-tabs-02" aria-selected="false" 
                    onclick="listarHistorialEntradasySalidas();">Historial Entradas y Salidas</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link tab-disable" id="custom-tabs-03-tab" data-toggle="pill" href="#custom-tabs-03" role="tab" 
                    aria-controls="custom-tabs-03" aria-selected="false" 
                    onclick="listarEntradasySalidas();">Total de Entradas y Salidas</a>
                  </li>
                </ul>
              </div>

              <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-01" role="tabpanel" aria-labelledby="custom-tabs-01-tab">

          <button type="button" class="btn btn-secondary" onclick="imprimirPDF();">
              <i class="fas fa-file-pdf"></i> PDF
          </button>

          <!--========================================== seccion contenido ==========================================-->
           <table id="datatable1" class="table table-bordered table-hover">
               <thead>
                   <tr>
                       <th>Categoria</th>
                       <th>Sub Categoria</th>
                       <th>Descripcion</th>
                       <th>Tipo de unidad</th>
                       <th>Entradas</th>
                       <th>Salidas</th>
                       <th>Stock Actual</th>
                       <th>Fecha</th>
                   </tr>
               </thead>
               <tbody>
                   <!-- Los datos se llenarán aquí mediante JavaScript -->
               </tbody>
           </table>
            <div style="display: flex; flex-direction: row; justify-content: space-between; width: 100%;">
                <button class="btn" type="submit" id="btnActualizar" style="background: #fd7e14; color:white;" onclick="actualizar()">
                    <i class="fa fa-save"></i> Actualizar
                </button>
            </div>  
          <!--==========================================================================================================-->
          
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-02" role="tabpanel" aria-labelledby="custom-tabs-02-tab">

                  <!-- ================= Contenido interno del tab ================= -->
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
                      <form role="form" name="formulario_consulta2" id="formulario_consulta2" method="POST">
                    <div class="row">
                            <!--================ Select 2 categoria ================-->
                            <div class="form-group col-sm-3 col-xs-12">
                              <label>Categoria</label>
                                <select aria-label="Default select example" name="id_categoria" id="id_categoria2" class="form-control">
                                </select>
                            </div>

                            <!--================ Select 2 sub categoria ================-->
                            <div class="form-group col-sm-3 col-xs-12">
                              <label>Sub Categoria</label>
                                <select aria-label="Default select example" name="id_sub_categoria" id="id_sub_categoria2" class="form-control">
                                </select>
                            </div>

                            <div class="form-group col-sm-3 col-xs-12">
                              <label>Desde</label>
                              <input type="date" name="fecha_desde" id="fecha_desde" class="form-control" placeholder="Ingrese Fecha">
                            </div>

                            <div class="form-group col-sm-3 col-xs-12">
                              <label>Hasta</label>
                              <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control" placeholder="Ingrese Fecha">
                            </div>
                    </div>
                    </form>
                      <!--========================================== FIN Formulario De Consulta ==========================================-->
                      <div class="card-footer">
                        <button type="submit" name="btnbuscar" id="btnbuscar" class="btn" style="background: #fd7e14; color:white;" onclick="listarHistorialEntradasySalidas()">
                        <i class="fas fa-search"></i>Buscar
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <!--========================== Tabla ==========================-->
                <div class="container-fluid" id="tabla">
                  <div class="row">
                    <div class="col-12">
                      <div class="card">

                        <div class="card-body" id="contenedorDatatable">
                         <table id="datatable2" class="table table-bordered table-hover">
                          <thead>
                            <tr align="center">
                              <th>Categoria</th>
                              <th>Sub Categoria</th>
                              <th>Descripcion</th>
                              <th>Entradas</th>
                              <th>Salidas</th>
                              <th>Fecha Entrada</th>
                              <th>Fecha Salida</th>
                            </tr>
                          </thead>

                          <tbody>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>                        
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
                    <!-- ================= Fin Contenido interno del tab ================= -->

                  </div>
                  <div class="tab-pane fade" id="custom-tabs-03" role="tabpanel" aria-labelledby="custom-tabs-03-tab">
                  <!-- ================= Contenido interno del tab ================= -->
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
                            <!--================ Select 2 categoria ================-->
                            <div class="form-group col-sm-3 col-xs-12">
                              <label>Categoria</label>
                                <select aria-label="Default select example" name="id_categoria" id="id_categoria" class="form-control">
                                </select>
                            </div>

                            <!--================ Select 2 sub categoria ================-->
                            <div class="form-group col-sm-3 col-xs-12">
                              <label>Sub Categoria</label>
                                <select aria-label="Default select example" name="id_sub_categoria" id="id_sub_categoria" class="form-control">
                                </select>
                            </div>
                    </div>
                    </form>
                      <!--========================================== FIN Formulario De Consulta ==========================================-->
                      <div class="card-footer">
                        <button type="submit" name="btnbuscar" id="btnbuscar" class="btn" style="background: #fd7e14; color:white;" onclick="listarEntradasySalidas()">
                        <i class="fas fa-search"></i>Buscar
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <!--========================== Tabla ==========================-->
                <div class="container-fluid" id="tabla">
                  <div class="row">
                    <div class="col-12">
                      <div class="card">

                        <div class="card-body" id="contenedorDatatable">
                         <table id="datatable3" class="table table-bordered table-hover">
                          <thead>
                            <tr align="center">
                              <th>Categoria</th>
                              <th>Sub Categoria</th>
                              <th>Descripcion</th>
                              <th>Total Entradas</th>
                              <th>Total Salidas</th>
                              <!--<th>Ultima Fecha Entrada</th>-->
                              <!--<th>Ultima Fecha Salida</th>-->
                            </tr>
                          </thead>

                          <tbody>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <!--<td></td>-->
                              <!--<td></td>-->                        
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
                    <!-- ================= Fin Contenido interno del tab ================= -->
                  </div>
                </div>
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
<script type="text/javascript" src="scripts/concepto.js<?php echo '?r='.date('Y-m-d H:i:s');?>"></script>
</body>
</html>
<?php 
ob_end_flush();
?>