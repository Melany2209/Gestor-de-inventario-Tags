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

//================================================================//

//SELECTS 2 sub categoria (formulario de registro)
$.post("../ajax/productos.php?op=listarSub_categorias&r=" + new Date().getTime(), {
        }, function (data, status) {

        $("#id_sub_categoriaR").append(data);
          //bootbox.alert("data="+data);  
        });

    // Inicializamos select2
    $('#id_sub_categoriaR').select2({
      theme: 'bootstrap4'
    });

//---------------------------------------------------------------//
//Select 2 (padre) CATEGORIA (formulario de busqueda)
$.post("../ajax/productos.php?op=listarCategorias&r=" + new Date().getTime(), function (r) {
    $("#id_categoria").append(r);
    // Inicializamos select2
    $('#id_categoria').select2({
      theme: 'bootstrap4'
    });

    //-----------------------------------------//
    // Inicializamos select2 (Hijo) SUB CATEGORIA (formulario de busqueda)
    $('#id_sub_categoria').select2({
      theme: 'bootstrap4'
    });
    $("#id_sub_categoria").prop("disabled", true);//deshabilitar select2
    //-----------------------------------------//

    $("#id_categoria").change(function () {
        var id_categoria = $(this).val();
        if (id_categoria) {

            //Select 2 (Hijo) SUB CATEGORIA 
            $.post("../ajax/productos.php?op=listarSub_categoriasDEP&r=" + new Date().getTime(),
                { id_categoria: id_categoria },
                function (r) {
                    $("#id_sub_categoria").prop("disabled", false);//habilitar select2
                    $("#id_sub_categoria").html(r);
                    // Inicializamos select2
                    $('#id_sub_categoria').select2({
                      theme: 'bootstrap4'
                    });
                }
            );
        } else {
            $("#id_sub_categoria").empty().select2("destroy"); //destruir select2
            $("#id_sub_categoria").prop("disabled", true); //deshabilitar select2
            // Re-inicializar select 2 (hijo)
            $('#id_sub_categoria').select2({
              theme: 'bootstrap4'
            }); 
            // Re-inicializar select 2 (padre)
            $('#id_categoria').select2({
              theme: 'bootstrap4'
            }); 
        }
    });
});

//================================================================//

//Función limpiar (campos especificos en el formulario de busqueda)
function limpiarFormBuscar()
{
  $("#nombre_producto").val("");
  //$("#id_categoria").val("").trigger("change");//select2
}

//Función limpiar (campos especificos en el formulario de registro)
function limpiarFormReg()
{
  $("#nombre_productoR").val("");
  $("#stock_actualR").val("");
  $("#tipo_unidadR").val("");
  $("#stock_minimoR").val("");
  $("#id_sub_categoriaR").val("").trigger("change");//select2
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
                url: '../ajax/productos.php?op=listar&r=' + new Date().getTime(),
                data: {
                    nombre_producto: $("#nombre_producto").val(),
                    id_categoria: $("#id_categoria").val(),
                    id_sub_categoria: $("#id_sub_categoria").val(),
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
            "targets": [0,1,2,3,4,5,6,7] // Para centrar solo las columnas deseadas
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
$.post("../ajax/productos.php?op=comprobarSubCategorias&r=" + new Date().getTime(), {
}, function(data) {
    //alert(data);
    if (data === "existe") {

  mostrarform(true);//mostrar formulario 
  $("#btnGuardar").show(); //mostrar el boton de registrar

}else{
    Swal.fire({
        title: '¡Atención!',
        text: 'No existen sub categorias registradas, ¿Deseas ir a registrar?',
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
            window.location.href = 'sub_categorias.php';
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
  limpiarFormReg();
  $("#id_producto").val("");
  mostrarform(false);//ocultar formulario registro
  mostrartable(true);
}

//================================================================//

//Funcion guardar formulario
function guardaryeditar(e) {

//----------------------------------------------------------------//
// Validar que se seleccione a quien pertenece el producto antes de continuar
// Obtener select
var id_sub_categoriaSelect = $("#id_sub_categoriaR");

// Verificar que el valor estado no está vacío
if (id_sub_categoriaSelect.val() === "") {
    Swal.fire({
        icon: 'warning',
        title: 'Atención',
        text: 'Por favor, seleccione a quien pertenece el producto antes de continuar.',
        customClass: {
            confirmButton: 'btn btn-primary'
        }
    }); // mostrar mensaje
    return false; // evitar el envío de formulario
} 
//----------------------------------------------------------------//
// Validar que se seleccione tipo de unidad antes de continuar
// Obtener select
var tipo_unidadSelect = $("#tipo_unidadR");

// Verificar que el valor estado no está vacío
if (tipo_unidadSelect.val() === "") {
    Swal.fire({
        icon: 'warning',
        title: 'Atención',
        text: 'Por favor, seleccione Tipo de unidad antes de continuar.',
        customClass: {
            confirmButton: 'btn btn-primary'
        }
    }); // mostrar mensaje
    return false; // evitar el envío de formulario
} 
//----------------------------------------------------------------//

  e.preventDefault(); // No se activará la acción predeterminada del evento
  $("#btnGuardar").prop("disabled", true);

  var formData = new FormData($("#formularioREG_EDIT")[0]);

$.ajax({
    url: "../ajax/productos.php?op=guardaryeditar&r=" + new Date().getTime(),
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
            timer: 1300
        }).then(() => {
            //location.reload(); // Recargar la página

            $("#id_producto").val("");
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
function mostrar(id_producto)
{

 $.post("../ajax/productos.php?op=mostrar&r=" + new Date().getTime(), {
  id_producto: id_producto
    }, function(data, status)
  {
    
    //recibir la respuesta del ajax
    var data = JSON.parse(data);

//================================================================//
   //entrando al formulario desde (el boton btnEditar en el AJAX)
   mostrarform(true);//mostrar formulario

//================================================================//
    //buscar los . y remplazarlos por , para mostrar los valores
    var stock_actualR = data.stock_actual.toString().replace(".", ",");
    var stock_minimoR = data.stock_minimo.toString().replace(".", ",");

   //rellenar los campos del formulario con los datos que se van a editar
   $("#id_producto").val(data.id);
   $("#nombre_productoR").val(data.producto);
   $('#stock_actualR').val(stock_actualR);
   $("#tipo_unidadR").val(data.tipo_de_unidad);
   $('#stock_minimoR').val(data.stock_minimo);
   $("#id_sub_categoriaR").val(data.id_sub_categoria).trigger("change");//select2

   //Imprimir la respuesta del ajax
   //bootbox.alert(data);
   //return;
 });
}

//================================================================//
//funcion desactivar
function desactivar(id_producto) {

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

            $.post("../ajax/productos.php?op=desactivar&r=" + new Date().getTime(), {
                id_producto: id_producto

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
function activar(id_producto) {
    $.post("../ajax/productos.php?op=activar&r=" + new Date().getTime(), {
        id_producto: id_producto
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

/*// Obtener el elemento del input
const stock_minimo = $('#stock_minimoR');

// Agregar un event listener para el evento 'input'
stock_minimo.on('input', () => {
    // Obtener el valor actual del input
    let stock_minimoR = stock_minimo.val();

    // Validar si la longitud es mayor a la permitida
    if (stock_minimoR.length > 10) {
        stock_minimo.val(stock_minimoR.slice(0, 10));
    }

    // Validar si contiene caracteres no numéricos
    if (!/^\d+$/.test(stock_minimoR)) {
        stock_minimo.val(stock_minimoR.replace(/\D/g, '')); // Eliminar todos los caracteres no numéricos
    }
});*/

//-------------------------------------------------------------//

/*// Obtener el elemento del input
const stock_actual = $('#stock_actualR');

// Agregar un event listener para el evento 'input'
stock_actual.on('input', () => {
    // Obtener el valor actual del input
    let stock_actualR = stock_actual.val();

    // Validar si la longitud es mayor a la permitida
    if (stock_actualR.length > 10) {
        stock_actual.val(stock_actualR.slice(0, 10));
    }

    // Validar si contiene caracteres no numéricos
    if (!/^\d+$/.test(stock_actualR)) {
        stock_actual.val(stock_actualR.replace(/\D/g, '')); // Eliminar todos los caracteres no numéricos
    }
});*/

//================================================================//

/*
### Formateo de inputs ###
- decimal: Indica que la entrada es un número tipo decimal.
- radixPoint: ",": Define la coma como el separador de decimales.
- groupSeparator: ".": Define el punto como el separador de miles.
- autoGroup: true: Agrupa automáticamente los dígitos en miles.
- placeholder: "0,00": Define el texto de marcador de posición (placeholder).
- digits: 2: Especifica que debe haber 2 decimales.
- integerDigits: Permite un máximo de 9 dígitos antes del punto decimal
- greedy: false: Permite que la máscara complete la entrada solo cuando es relevante.
*/
    Inputmask("decimal", {
        radixPoint: ",",
        groupSeparator: ".",
        autoGroup: true,
        digits: 2,
        integerDigits: 12,
        greedy: false,
    }).mask('#stock_actualR');

    Inputmask("decimal", {
        radixPoint: ",",
        groupSeparator: ".",
        autoGroup: true,
        digits: 2,
        integerDigits: 12,
        greedy: false,
    }).mask('#stock_minimoR');

//================================================================//

init();