// Función que se ejecuta al inicio
function init() {
    listar();
    verificarEntradasalidaTotal();
    $("#btnActualizar").prop("disabled", true);
}

//verificar si existen movimientos
function verificarEntradasalidaTotal()
{
//----------------------------------------------------------------------//
$.post("../ajax/concepto.php?op=verificarEntradasalidaTotal&r=" + new Date().getTime(), {
}, function(data) {
    //alert(data);
    if (data === "existe") {
    $("#custom-tabs-02-tab").removeClass("tab-disable");
    $("#custom-tabs-03-tab").removeClass("tab-disable");
}else{
    $("#custom-tabs-02-tab").addClass("tab-disable");
    $("#custom-tabs-03-tab").addClass("tab-disable");
}
});
//----------------------------------------------------------------------//
}

//================================================================//
function listar() {

var fechaFormateada = obtenerFechaFormateada();

// Inicializa DataTable con las propiedades deseadas
var table = $('#datatable1').DataTable({
     language: {
        processing:     "Tratamiento en curso...",
        search:         "Buscar:" ,
        lengthMenu:     "Filtro de _MENU_ registros",
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
              /*{
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel', // Añadiendo icono de Excel
                exportOptions: {
                  columns: function (idx, data, node) {
                    // Excluir columnas con la clase "noExport"
                    if ($(node).hasClass('noExport')) {
                      return false;
                    }
                    // Exportar todas las demás columnas
                    return true;
                  },
                  customize: function (xlsx) {
                    // Personalización de la exportación de Excel, si es necesario
                  }
                }
              },*/
              /*{
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF', // Añadiendo icono de PDF
                title: 'reportePDF-'+fechaFormateada,
                exportOptions: {
                  columns: function (idx, data, node) {
                    // Excluir columnas con la clase "noExport"
                    if ($(node).hasClass('noExport')) {
                      return false;
                    }
                    // Exportar todas las demás columnas
                    return true;
                  },
                  customize: function (doc) {
                    // Personalización de la exportación de PDF, si es necesario
                  }
                }
              }*/
            ],
    "columnDefs": [
        {"className": "dt-center", "targets": "_all"}, // Para centrar todas las columnas
        {"targets": 0, "width": "12.73%"},
        {"targets": 1, "width": "12.73%"},
        {"targets": 2, "width": "25.45%"},
        {"targets": 3, "width": "10.91%"},
        {"targets": 4, "width": "9.09%"},
        {"targets": 5, "width": "9.09%"},
        {"targets": 6, "width": "9.09%"},
        {"targets": 7, "width": "10.91%"}
    ],
    //"dom": 'frtip',
    "dom": 'Bti',
    "autoWidth": false, // Hacer DataTable responsive
    "responsive": true, // Hacer DataTable responsive
    "bDestroy": true,
    "iDisplayLength": 998, // Paginación 998 registros
    "order": [
        [0, "asc"]
    ] // Ordenar (columna, orden)
});

// Llama al AJAX para obtener los datos
$.ajax({
    url: '../ajax/concepto.php?op=listar&r=' + new Date().getTime(),
    method: 'POST',
    dataType: 'json',
    success: function(response) {
        // Limpia la tabla antes de llenarla
        table.clear();

        var contador = 0;

        // Recorre los datos y llena la tabla
        $.each(response.data, function(index, data) {
            var rowClass = '';
            contador++;

            //------------------------------------------------------------------------//
            var fechas = obtenerFechaFormateada();
            var fechaFormateada = fechas.fechaFormateada; // 'd-m-Y'
            var fechaCompleta = fechas.fechaCompleta; // 'Y-m-d H:M:S'
            //------------------------------------------------------------------------//

            //Imprimir el tipo de dato con "typeof"
            //alert(typeof data.stock_actual);
            //alert(typeof data.stock_minimo);

            // Función para limpiar y convertir el valor a float
            var stock_actual = parseFloat(data.stock_actual.replace('.', '').replace(',', '.'));
            var stock_minimo = parseFloat(data.stock_minimo.replace('.', '').replace(',', '.'));
            //alert(stock_actual);
            //alert(stock_minimo);

            // Validar el stock_actual
            if (stock_actual < stock_minimo) {
                rowClass = 'rojo'; // Asignar la clase roja si (stock_actual es menor a stock_minimo)
            }

            if (stock_actual === stock_minimo) {
                rowClass = 'naranja'; // Asignar la clase naranja si (stock_actual es igual a stock_minimo)
            }

            //------------------------------------------------------------------------//

            // Crea una fila con inputs
            var rowNode = table.row.add([
                '<input type="text" class="form-control" placeholder="Categoria"'+ 
                'value="'+data.nombre_categoria+'" style="cursor: not-allowed;" title="'+data.nombre_categoria+'" readonly/>',

                '<input type="text" class="form-control" placeholder="Sub Categoria"'+ 
                'value="'+data.nombre_sub_categoria+'" style="cursor: not-allowed;" title="'+data.nombre_sub_categoria+'" readonly/>',

                '<input type="text" name="id_producto" id="id_productoR" class="form-control"'+
                'value="'+data.id+'" readonly style="display:none;" />'+
                '<span class="form-control"'+ 
                'style="background-color: #e9ecef; color: #495057; cursor: not-allowed;" title="'+data.producto+'">'+data.producto+'</span>',

                '<input type="text" name="tipo_de_unidad" id="tipo_de_unidadR'+contador+'" class="form-control" placeholder="Tipo de unidad"'+ 
                'value="'+data.tipo_de_unidad+'" style="cursor: not-allowed;" title="'+data.tipo_de_unidad+'" readonly/>',

                '<input type="text" name="entrada" id="entradaR'+contador+'" class="form-control" placeholder="Entradas"'+ 
                'value="0" />',

                '<input type="text" name="salida" id="salidaR'+contador+'" class="form-control" placeholder="Salidas"'+ 
                'value="0" />',

                '<input type="text" name="stock_actual" id="stock_actualR'+contador+'" class="form-control" placeholder="Stock Actual"'+ 
                'value="'+data.stock_actual+'" style="cursor: not-allowed;" title="'+data.stock_actual+'" readonly/>',

                '<input type="text" name="fecha" id="fechaR" class="form-control"'+
                'value="'+fechaCompleta+'" readonly style="display:none;" />'+
                '<span class="form-control" id="fechaDisplay"'+ 
                'style="background-color: #e9ecef; color: #495057; cursor: not-allowed;" title="'+fechaCompleta+'">'+fechaFormateada+'</span>'
            ]).draw();

            // Agregar la clase a la fila si corresponde
            $(rowNode.node()).addClass(rowClass);

             //=================== Validaciones ===================//
            let entradaRValue = '0'; // Inicializar variable
            let salidaRValue = '0'; // Inicializar variable 

            $("#entradaR" + contador).change(function(e) {
                if ($(this).val() === '') {
                    $(this).val('0'); // Asigna 0 si está vacío
                }
                entradaRValue = $(this).val(); // Actualizar el valor
                validarBoton(entradaRValue);
            });

            Inputmask("decimal", {
                radixPoint: ",",
                groupSeparator: ".",
                autoGroup: true,
                digits: 2,
                integerDigits: 6,
                greedy: false,
            }).mask("#entradaR" + contador);

            /*// Validación del input para evitar letras y limitar caracteres
            $("#entradaR" + contador).on('input', function() {
                entradaRValue = $(this).val().replace(/\D/g, ''); // Eliminar caracteres no numéricos
                if (entradaRValue.length > 6) {
                    entradaRValue = entradaRValue.slice(0, 6);
                }
                $(this).val(entradaRValue); // Asignar el valor limpio
                validarBoton(entradaRValue);
            });*/

            //---------------------------------------------------//

            $("#salidaR" + contador).change(function(e) {
                if ($(this).val() === '') {
                    $(this).val('0'); // Asigna 0 si está vacío
                }
                salidaRValue = $(this).val(); // Actualizar el valor
                validarBoton(salidaRValue);
            });

            Inputmask("decimal", {
                radixPoint: ",",
                groupSeparator: ".",
                autoGroup: true,
                digits: 2,
                integerDigits: 6,
                greedy: false,
            }).mask("#salidaR" + contador);

            /*// Validación del input para evitar letras y limitar caracteres
            $("#salidaR" + contador).on('input', function() {
                salidaRValue = $(this).val().replace(/\D/g, ''); // Eliminar caracteres no numéricos
                if (salidaRValue.length > 6) {
                    salidaRValue = salidaRValue.slice(0, 6);
                }
                $(this).val(salidaRValue); // Asignar el valor limpio
                validarBoton(salidaRValue); // Validar salidaRValue
            });*/

            //---------------------------------------------------//
            // Función para validar el valor del input y habilitar/deshabilitar el botón
            function validarBoton(value) {
                if (parseInt(value) > 0) {
                    $("#btnActualizar").prop("disabled", false); // Habilitar el botón
                } else {
                    $("#btnActualizar").prop("disabled", true); // Deshabilitar el botón
                }
            }
            //=================== Fin Validaciones ===================//

        });
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
    }
});
}

//================================================================//

//Actualizar (al hacer click)
function actualizar() {

    $("#btnActualizar").prop("disabled", true);
    //-----------------------------------------------------------//

    // Inicializar arrays
    let fechas = [];
    let id_productos = [];
    let entradas = [];
    let salidas = [];
    let stock = [];

    //-----------------------------------------------------------//
    // Recorrer todos los inputs de la tabla
    $("input[id^='id_productoR']").each(function() {
        id_productos.push($(this).val()); // Agrega el valor de cada elemento al array
    });

    $("input[id^='entradaR']").each(function() {
        entradas.push($(this).val()); // Agrega el valor de cada elemento al array
    });

    $("input[id^='salidaR']").each(function() {
        salidas.push($(this).val()); // Agrega el valor de cada elemento al array
    });

    $("input[id^='stock_actualR']").each(function() {
        stock.push($(this).val()); // Agrega el valor de cada elemento al array
    });

    $("input[id^='fechaR']").each(function() {
        fechas.push($(this).val()); // Agrega el valor de cada elemento al array
    });
    //-----------------------------------------------------------//

    // Muestra el array con los valores
    //alert(id_productos.join(", "));
    //alert(entradas.join(", "));
    //alert(salidas.join(", "));
    //alert(stock.join(", "));
    //alert(fechas.join(", "));

    //-----------------------------------------------------------//

// Crear un nuevo objeto FormData para llenarlo con los arrays
let formData = new FormData();

// Agregar valores al FormData
id_productos.forEach(function(id_producto) {
    formData.append('id_producto[]', id_producto);
});

entradas.forEach(function(entrada) {
    formData.append('entrada[]', entrada);
});

salidas.forEach(function(salida) {
    formData.append('salida[]', salida);
});

stock.forEach(function(stock_actual) {
    formData.append('stock_actual[]', stock_actual);
});

fechas.forEach(function(fecha) {
    formData.append('fecha[]', fecha);
});

$.ajax({
    url: "../ajax/concepto.php?op=actualizar&r=" + new Date().getTime(),
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function(data) {
        if (data == 'Actualizacion exitosa') {
            Swal.fire({
                title: 'Resultado',
                text: data,
                icon: 'success',
                showConfirmButton: false,
                timer: 1300
            }).then(() => {
                location.reload(); // Recargar la página
                //$('#datatable1').DataTable().ajax.reload(); // Recargar datatable
            });
        }else{
            Swal.fire({
                title: 'Resultado',
                text: data,
                icon: 'error',
                showConfirmButton: false,
                timer: 1800
            }).then(() => {
                location.reload(); // Recargar la página
                //$('#datatable1').DataTable().ajax.reload(); // Recargar datatable
            });
        }
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

//---------------------------------------------------------------//
//Select 2 (padre) CATEGORIA (formulario de busqueda)
$.post("../ajax/productos.php?op=listarCategorias&r=" + new Date().getTime(), function (r) {
    $("#id_categoria2").append(r);
    // Inicializamos select2
    $('#id_categoria2').select2({
      theme: 'bootstrap4'
    });

    //-----------------------------------------//
    // Inicializamos select2 (Hijo) SUB CATEGORIA (formulario de busqueda)
    $('#id_sub_categoria2').select2({
      theme: 'bootstrap4'
    });
    $("#id_sub_categoria2").prop("disabled", true);//deshabilitar select2
    //-----------------------------------------//

    $("#id_categoria2").change(function () {
        var id_categoria2 = $(this).val();
        if (id_categoria2) {

            //Select 2 (Hijo) SUB CATEGORIA 
            $.post("../ajax/productos.php?op=listarSub_categoriasDEP&r=" + new Date().getTime(),
                { id_categoria : id_categoria2 },
                function (r) {
                    $("#id_sub_categoria2").prop("disabled", false);//habilitar select2
                    $("#id_sub_categoria2").html(r);
                    // Inicializamos select2
                    $('#id_sub_categoria2').select2({
                      theme: 'bootstrap4'
                    });
                }
            );
        } else {
            $("#id_sub_categoria2").empty().select2("destroy"); //destruir select2
            $("#id_sub_categoria2").prop("disabled", true); //deshabilitar select2
            // Re-inicializar select 2 (hijo)
            $('#id_sub_categoria2').select2({
              theme: 'bootstrap4'
            }); 
            // Re-inicializar select 2 (padre)
            $('#id_categoria2').select2({
              theme: 'bootstrap4'
            }); 
        }
    });
});
//================================================================//

function validarFechas() {
    var fecha_desde = $('#fecha_desde').val(); 
    var fecha_hasta = $('#fecha_hasta').val();

    // Validación de fechas
    if ((fecha_desde === "" && fecha_hasta !== "") || (fecha_desde !== "" && fecha_hasta === "")) {
        Swal.fire({
            title: 'Error!',
            text: 'Es necesario completar ambos campos de fecha. Asegúrate de no dejar ninguno vacío.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
        $("#fecha_desde").addClass("is-invalid");
        $("#fecha_hasta").addClass("is-invalid");
        return;  
    }else{
        $("#fecha_desde").removeClass("is-invalid");
        $("#fecha_hasta").removeClass("is-invalid"); 
    } 

    if (fecha_desde !== "" && fecha_hasta !== "" && fecha_desde > fecha_hasta) {
        Swal.fire({
            title: 'Error!',
            text: '¡Atención! La fecha de inicio no puede ser posterior a la fecha final. Por favor, verifica tus fechas.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
        $("#fecha_desde").addClass("is-invalid");
        $("#fecha_hasta").addClass("is-invalid");
        return;
    }else{
        $("#fecha_desde").removeClass("is-invalid");
        $("#fecha_hasta").removeClass("is-invalid"); 
    } 
}

//================================================================//

    function listarHistorialEntradasySalidas(){ 
        validarFechas();

        //var fechaFormateada = obtenerFechaFormateada();
        var fechas = obtenerFechaFormateada();
        var fechaFormateada = fechas.fechaFormateada; // 'd-m-Y'

        var tabla2;
        var formData = new FormData($("#formulario_consulta2")[0]);
        tabla2 = $('#datatable2').dataTable({
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
              /*{
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel', // Añadiendo icono de Excel
                exportOptions: {
                  columns: function (idx, data, node) {
                    // Excluir columnas con la clase "noExport"
                    if ($(node).hasClass('noExport')) {
                      return false;
                    }
                    // Exportar todas las demás columnas
                    return true;
                  },
                  customize: function (xlsx) {
                    // Personalización de la exportación de Excel, si es necesario
                  }
                }
              },*/
              {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF', // Añadiendo icono de PDF
                title: 'Historial Entradas y Salidas - '+fechaFormateada,
                exportOptions: {
                  columns: function (idx, data, node) {
                    // Excluir columnas con la clase "noExport"
                    if ($(node).hasClass('noExport')) {
                      return false;
                    }
                    // Exportar todas las demás columnas
                    return true;
                  },
                  customize: function (doc) {
                    // Personalización de la exportación de PDF, si es necesario
                  }
                }
              }
            ],
            "ajax": {
                url: '../ajax/concepto.php?op=listarHistorialEntradasySalidas&r=' + new Date().getTime(),
                data: {
                    fecha_desde: $("#fecha_desde").val(),
                    fecha_hasta: $("#fecha_hasta").val(),
                    id_categoria: $("#id_categoria2").val(),
                    id_sub_categoria: $("#id_sub_categoria2").val(),
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
            "targets": [0,1,2,3,4,5,6] // Para centrar solo las columnas deseadas
            }],
            "dom": 'B',
            "autoWidth": false,//hacer datatable responsive
            "responsive": true,//hacer datatable responsive
            "bDestroy": true,
            "iDisplayLength": 990, //Paginación
            "order": [
                [0, "asc"]
            ] //Ordenar (columna,orden)
        });
    }

//================================================================//

    function listarEntradasySalidas(){ 

        //var fechaFormateada = obtenerFechaFormateada();
        var fechas = obtenerFechaFormateada();
        var fechaFormateada = fechas.fechaFormateada; // 'd-m-Y'

        var tabla3;
        var formData = new FormData($("#formulario_consulta")[0]);
        tabla3 = $('#datatable3').dataTable({
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
                /*{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    title: 'reporteExel', // título del archivo
                    exportOptions: {
                        columns: function (idx, data, node) {
                            if ($(node).hasClass('noExport')) {
                                return false;
                            }
                            return true;
                        },
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            var col = $('row c[r^="D"], row c[r^="E"]', sheet); // Cambia "A" por la columna que necesites

                            col.each(function () {
                                var cell = $(this);
                                var value = cell.text();

                                // Reemplaza la coma con un punto
                                cell.text(value.replace(',', '.'));
                                // Cambia el formato a numérico
                                cell.attr('t', 'n'); 
                            });
                        }
                    }
                },*/
              {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF', // Añadiendo icono de PDF
                title: 'Total de Entradas y Salidas - '+fechaFormateada,
                exportOptions: {
                  columns: function (idx, data, node) {
                    // Excluir columnas con la clase "noExport"
                    if ($(node).hasClass('noExport')) {
                      return false;
                    }
                    // Exportar todas las demás columnas
                    return true;
                  },
                  customize: function (doc) {
                    // Personalización de la exportación de PDF, si es necesario
                  }
                }
              }
            ],
            "ajax": {
                url: '../ajax/concepto.php?op=listarEntradasySalidas&r=' + new Date().getTime(),
                data: {
                    id_categoria: $("#id_categoria").val(),
                    id_sub_categoria: $("#id_sub_categoria").val(),
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
            "targets": [0,1,2,3,4] // Para centrar solo las columnas deseadas
            }],
            "dom": 'B',
            "autoWidth": false,//hacer datatable responsive
            "responsive": true,//hacer datatable responsive
            "bDestroy": true,
            "iDisplayLength": 990, //Paginación
            "order": [
                [0, "asc"]
            ] //Ordenar (columna,orden)
        });
    }

//================================================================//

function obtenerFechaFormateada() {
    // Obtener la fecha actual en UTC
    let fechaUTC = new Date();
    // Sumar la diferencia horaria (Venezuela es UTC-4)
    let diferenciaHoraria = -4; // horas
    let fechaVenezuela = new Date(fechaUTC.getTime() + (diferenciaHoraria * 60 * 60 * 1000));

    // Formatear la fecha como 'd-m-Y'
    let dia = String(fechaVenezuela.getDate()).padStart(2, '0');
    let mes = String(fechaVenezuela.getMonth() + 1).padStart(2, '0'); // Los meses comienzan desde 0
    let anio = fechaVenezuela.getFullYear();
    let fechaFormateada = dia + '-' + mes + '-' + anio;

    // Formatear la fecha para mostrarla en el formato deseado
    let fechaCompleta = fechaVenezuela.toISOString().slice(0, 19).replace('T', ' ');

    //retornar solo fechaFormateada
    //return fechaFormateada; 

    //Retornar fechaCompleta y fechaFormateada como un objeto
    return {
        fechaFormateada: fechaFormateada,
        fechaCompleta: fechaCompleta
    };
}

//================================================================//

//funcion redireccionar al pdf
function imprimirPDF() {
    // Crear un formulario
    var form = document.createElement("form");
    form.method = "POST";
    form.action = "../reportesPDF/reporteGlobal.php";
    form.target = "_blank"; //Abrir reporte en una nueva pestaña

    /*// Crear un elemento input para id_alcaldia
    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "id_alcaldia";
    input.value = id_alcaldia;
    // Agregar el input al formulario
    form.appendChild(input);*/

    // Agregar el formulario al documento y enviarlo
    document.body.appendChild(form);
    form.submit();
}

//================================================================//

init();