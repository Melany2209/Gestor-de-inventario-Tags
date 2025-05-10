// Función que se ejecuta al inicio
function init() {
    mostrarform(false);//ocultar formulario de registro
    mostrartable(false);//ocultar table 
    listar();

    $("#formularioREG_EDIT").on("submit",function(e)
    {
        e.preventDefault(); //Evita el envío del formulario por defecto
        guardaryeditar(e);  
    });
}

//Función limpiar (campos especificos en el formulario de busqueda)
function limpiarFormBuscar()
{
  $("#categoria").val("");
}

//Función limpiar (campos especificos en el formulario de registro)
function limpiarFormReg()
{
  $("#categoriaR").val("");
}

//================================================================//
    function listar(){ 

        var tabla;
        var formData = new FormData($("#formulario_consulta")[0]);
        tabla = $('#datatable').dataTable({
                language: {
                processing:     "Tratamiento en curso...",
                search:         "Buscar:" ,
                lengthMenu:    "Filtro de _MENU_ registros",
                info:           "Mostrando del registro _START_ al _END_ de un total de _TOTAL_ registros",
                infoEmpty:      "No existen registros",
                infoFiltered:   "(filtrado de _MAX_ registros en total)",
                infoPostFix:    "",
                loadingRecords: "Cargando elementos...",
                zeroRecords:    "No se encontraron los datos de tu busquda..",
                emptyTable:     "No hay ningun registro en la tabla",
                paginate: {
                    first:      "Primero",
                    previous:   "Anterior",
                    next:       "Siguiente",
                    last:       "Ultimo"
                },
                aria: {
                    sortAscending:  ": Active para odernar en modo ascendente",
                    sortDescending: ": Active para ordenar en modo descendente  ",
                }
            },
            buttons: [
                //'copyHtml5',
                'excelHtml5',
                'pdf'
                ],
            "ajax": {
                url: '../ajax/categorias.php?op=listar&r=' + new Date().getTime(),
                data: {
                    categoria: $("#categoria").val(),
                    status: $("#status").val(),
                },
                type: "POST",
                dataType: "json",
                error: function (e) {
                    //console.log(e.responseText);
                    //console.log("Error en la llamada AJAX:", e);
                    //alert("Error: " + e.responseText);
                }
            },
            "columnDefs": [{
            "className": "dt-center",
            //"targets": "_all" // Para centrar todas las columnas
            "targets": [1,2] // Para centrar solo las columnas deseadas
            }],
            "autoWidth": false,//hacer datatable responsive
            "responsive": true,//hacer datatable responsive
            "bDestroy": true,
            "iDisplayLength": 10, //Paginación
            "order": [
                [0, "asc"]
            ] //Ordenar (columna,orden)
        });
        mostrartable(true);//mostrar table 
    }
//================================================================//

//mostrar el "formulario de registro (al hacer click)
function registrar(flag)
{
  mostrarform(true);//mostrar formulario 
  $("#btnGuardar").show(); //mostrar el boton de registrar
}

//================================================================//

//Funcion mostrar - ocultar formulario
function mostrarform(flag)
{
  //limpiar formularios
  limpiarFormReg();
  limpiarFormBuscar();
  if (flag)
  {
    //entrando al formulario desde (el boton btnAgregar en la vista php)
    $("#tabla").hide();//ocultar tabla
    $("#card_header").hide();
    $("#formulariobusqueda").hide();
    $("#formularioregistros").show();
    $("#btnGuardar").prop("disabled",false);
    $("#btnagregar").hide();
  }
  else
  {
    $("#card_header").show();
    $("#formulariobusqueda").show();
    $("#formularioregistros").hide();//ocultar formulario registro
    $("#btnagregar").show();
  }
}

//================================================================//

//Función cancelar formulario registro
function Cancelarform()
{
  //limpiar();
  limpiarFormReg();
  $("#id_categoria").val("");
  mostrarform(false);//ocultar formulario registro
  mostrartable(true);
}

//================================================================//

//Funcion guardar formulario
function guardaryeditar(e) {

  e.preventDefault(); // No se activará la acción predeterminada del evento
  $("#btnGuardar").prop("disabled", true);

  var formData = new FormData($("#formularioREG_EDIT")[0]);

$.ajax({
    url: "../ajax/categorias.php?op=guardaryeditar&r=" + new Date().getTime(),
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function(data) {
        Swal.fire({
            title: 'Resultado',
            text: data,
            icon: 'success',
            showConfirmButton: false,
            timer: 1300 // Tiempo antes de cerrar automáticamente
        }).then(() => {
            //location.reload(); // Recargar la página

            $("#id_categoria").val("");
            mostrarform(false);//ocultar formulario de registro
            mostrartable(true);//mostrar tabla
            $('#datatable').DataTable().ajax.reload(); // Recargar datatable
        });
    },
    error: function() {
        loadingDialog.close(); // Cerrar el diálogo de loading
        Swal.fire({
            title: 'Error',
            text: "Error en la petición.",
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
});
}

//================================================================//
//Función mostrar u ocultar tabla (datatable)
function mostrartable(flag)
{
  //limpiar();
  limpiarFormReg();
  if (flag)
  {
  $("#tabla").show();//mostrar tabla
  }
  else
  {
  $("#tabla").hide();//ocultar tabla
  }
}

//================================================================//

//mostrar los datos en el formulario (EDITAR)
function mostrar(id_categoria)
{

 $.post("../ajax/categorias.php?op=mostrar&r=" + new Date().getTime(), {
  id_categoria: id_categoria
    }, function(data, status)
  {
    
    //recibir la respuesta del ajax
    var data = JSON.parse(data);

//================================================================//
   //entrando al formulario desde (el boton btnEditar en el AJAX)
   mostrarform(true);//mostrar formulario

//================================================================//

   //rellenar los campos del formulario con los datos que se van a editar
   $("#id_categoria").val(data.id);
   $("#categoriaR").val(data.categoria);

   //Imprimir la respuesta del ajax
   //bootbox.alert(data);
   //return;
 });
}

//================================================================//
//funcion desactivar
function desactivar(id_categoria) {

    Swal.fire({
        title: '¡Atención!',
        text: '¿Realmente está seguro de desactivar este registro?',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Sí, desactivar',
        cancelButtonText: '<i class="fa fa-arrow-circle-left"></i> Cancelar',
        customClass:{
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-danger'
        }
    }).then((result1) => {
        if (result1.value) {

            $.post("../ajax/categorias.php?op=desactivar&r=" + new Date().getTime(), {
                id_categoria: id_categoria

            }).done(function(data) {
                Swal.fire({
                    title: 'Resultado',
                    text: data,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1300 // Tiempo antes de cerrar automáticamente
                }).then(() => {
                    //location.reload(); // Recargar la página

                    $('#datatable').DataTable().ajax.reload(); // Recargar datatable
                });
            })
        } else {
        //else de result1
        }
    });
}
//================================================================//
//funcion activar
function activar(id_categoria) {
    $.post("../ajax/categorias.php?op=activar&r=" + new Date().getTime(), {
        id_categoria: id_categoria
    }).done(function(data) {
        Swal.fire({
            title: 'Resultado',
            text: data,
            icon: 'success',
            showConfirmButton: false,
            timer: 1300 // Tiempo antes de cerrar automáticamente
            }).then(() => {
                //location.reload(); // Recargar la página

                $('#datatable').DataTable().ajax.reload(); // Recargar datatable
            });
        })
}
//================================================================//

init();