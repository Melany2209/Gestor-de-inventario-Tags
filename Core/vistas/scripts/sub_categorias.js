// Función que se ejecuta al inicio
function init() {
    mostrarform(false);//ocultar formulario de registro
    mostrartable(false);//ocultar tabla
    listar();

    $("#formularioREG").on("submit",function(e)
    {
        e.preventDefault(); //Evita el envío del formulario por defecto
        guardar(e);  
    });
}

//Función limpiar (campos especificos en el formulario de registro)
function limpiarFormReg()
{
  $("#sub_categoriaR").val("");
  $('.tblChk').prop('checked', false);
  $('#chkAll').prop('checked', false);
}

//================================================================//
    function listarcategorias(){ 
        var tabla1;
        tabla1 = $('#datatableCAT').dataTable({
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
                url: '../ajax/sub_categorias.php?op=listarcategorias&r=' + new Date().getTime(),
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
            "targets": [0,1,2] // Para centrar solo las columnas deseadas
            }],
            "dom": 'frt',
            "autoWidth": false,//hacer datatable responsive
            "responsive": true,//hacer datatable responsive
            "bDestroy": true,
            "iDisplayLength": 10, //Paginación
            "order": [
                [0, "asc"]
            ] //Ordenar (columna,orden)
        });
    }

//================================================================//
    function listar(){ 

        var tabla;
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
                url: '../ajax/sub_categorias.php?op=listar&r=' + new Date().getTime(),
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
            "targets": "_all" // Para centrar todas las columnas
            //"targets": [1,2] // Para centrar las columnas deseadas 
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

//----------------------------------------------------------------------//
$.post("../ajax/sub_categorias.php?op=comprobarCategorias&r=" + new Date().getTime(), {
}, function(data) {
    //alert(data);
    if (data === "existe") {

  mostrarform(true);//mostrar formulario 
  listarcategorias();
  $("#btnGuardar").show(); //mostrar el boton de registrar

}else{
    Swal.fire({
        title: '¡Atención!',
        text: 'No existen categorias registradas, ¿Deseas ir a registrar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No',
        customClass:{
            confirmButton: 'btn-primary',
            cancelButton: 'btn-danger'
        }
    }).then((result1) => {
        if (result1.value) {
            window.location.href = 'categorias.php';
        } else {
        //else de result1
        }
    });
}
});
//----------------------------------------------------------------------//
}

//================================================================//

//Funcion mostrar - ocultar formulario
function mostrarform(flag)
{
  //limpiar formularios
  limpiarFormReg();
  if (flag)
  {
    //entrando al formulario desde (el boton btnAgregar en la vista php)
    //mostrartableCAT(true);
    $("#tabla").hide();//ocultar tabla
    $("#card_header").hide();
    $("#formulariobusqueda").hide();
    $("#formularioregistros").show();
    $("#btnGuardar").prop("disabled",false);
    $("#btnagregar").hide();
  }
  else
  {
    //mostrartableCAT(false);
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
  $("#id_sub_categoriaR").val("");
  mostrarform(false);//ocultar formulario registro
  mostrartable(true);
}

//================================================================//
// Función Seleccionar checkboxes
$('#datatableCAT').on('change', '.tblChk', function () {
    $('#chkAll').prop('checked', $('.tblChk:checked').length === $('.tblChk').length);
});

// Función seleccionar todos los checks
$("#chkAll").change(function () {
    if ($(this).prop('checked')) {
        Swal.fire({
            title: '¡Atención!',
            text: '¿Realmente está seguro de seleccionar todas las categorias?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, seleccionar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.value) {
                $('.tblChk').prop('checked', true);
            } else {
                $('.tblChk').prop('checked', false);
                $('#chkAll').prop('checked', false);
            }
        });
    } else {
        $('.tblChk').prop('checked', false);
    }
});
//================================================================//
//Funcion guardar formulario
function guardar(e) {

    e.preventDefault(); // No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);

    var formData = new FormData($("#formularioREG")[0]);

    // Validar checks
    var checks = [];
    $('.tblChk:checked').each(function () {
        checks.push($(this).attr("id"));
    });

    // verificar que existan categorias seleccionadas
    if (checks.length > 0) {
        //enviar categorias seleccionadas como un array
        checks.forEach(function(check) {
            formData.append('checks[]', check); // Añadir cada valor seleccionado
        });

        // Ahora puedes hacer la llamada AJAX
        $.ajax({
            url: "../ajax/sub_categorias.php?op=guardar&r=" + new Date().getTime(),
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

                    $("#id_sub_categoriaR").val("");
                    mostrarform(false);//ocultar formulario de registro
                    mostrartable(true);//mostrar tabla
                    $('#datatable').DataTable().ajax.reload(); // Recargar datatable
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Debe seleccionar al menos una categoria.',
                    customClass:{
                        confirmButton: 'btn btn-primary'
                    }
                }); // mostrar mensaje 
            }
        });
    } else {
        $("#btnGuardar").prop("disabled", false); // Habilitar botón nuevamente
        Swal.fire({
            icon: 'warning',
            title: '¡Atención!',
            text: '¡Por favor, seleccione al menos una categoría!',
        });
    }
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
//Función mostrar u ocultar tabla (datatable)
function mostrartableCAT(flag)
{
  if (flag)
  {
  $("#tablaCAT").show();//mostrar tabla
  }
  else
  {
  $("#tablaCAT").hide();//ocultar tabla
  }
}
//================================================================//
//funcion eliminar
function eliminar(id_sub_categoria) {
    Swal.fire({
        title: '¡Atención!',
        text: '¿Realmente está seguro de eliminar este registro?',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: '<i class="fa fa-arrow-circle-left"></i> Cancelar',
        customClass:{
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-danger'
        }
    }).then((result1) => {
        if (result1.value) {

            $.post("../ajax/sub_categorias.php?op=eliminar&r=" + new Date().getTime(), {
                id_sub_categoria: id_sub_categoria

            }).done(function(data) {
                Swal.fire({
                    title: 'Resultado',
                    text: data,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1300 // Tiempo antes de cerrar automáticamente
                }).then(() => {
                    //location.reload(); // Recargar la página
                    mostrarform(false);//ocultar formulario de registro
                    mostrartable(true);//mostrar tabla
                    $('#datatable').DataTable().ajax.reload(); // Recargar datatable
                });
            })

        } else {
        //else de result1
        }
    });
}
//================================================================//

init();