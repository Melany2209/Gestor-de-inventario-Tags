// Función que se ejecuta al inicio
function init() {
    $("#formulario_cambio_clave").on("submit",function(e)
    {
        e.preventDefault(); //Evita el envío del formulario por defecto
        cambio_clave(e);  
    });

    $("#btnCambio_clave").prop("disabled", true);//desabilitar el boton
}
//================================================================//
function cambio_clave(e) {
    e.preventDefault(); // No se activará la acción predeterminada del evento

    var claveNueva = $("#clave_nueva").val().trim(); // Obtener el valor de la nueva clave
    var repitaClave = $("#rep_clave").val().trim(); // Obtener el valor de la repetición de clave

    // Validar que no estén vacíos
    if (claveNueva === "" || repitaClave === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Advertencia',
            text: 'Por favor, complete ambos campos de la nueva contraseña'
        });
        validacionInputs.clave_nueva = false;
        validarInputsF();
        return false; // Previene el envío del formulario
    }

    if (claveNueva !== repitaClave) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Las contraseñas no coinciden'
        });
        validacionInputs.clave_nueva = false;
        validarInputsF();
        return false; // Previene el envío del formulario
    }

    //----------------------------------------------------------------//
    var formData = new FormData($("#formulario_cambio_clave")[0]);
    $.ajax({
        url: "../ajax/opciones_de_usuario.php?op=cambio_clave&r=" + new Date().getTime(),
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            if (data != "Clave actualizada exitosamente.") {
                 Swal.fire({
                    title: 'Error',
                    text: data,
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1300
                }).then(() => {
                    location.reload(); // Recargar la página
                });
            }else{
                Swal.fire({
                    title: 'Resultado',
                    text: data,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1300
                }).then(() => {
                    location.reload(); // Recargar la página
                });
            }
        }
    });
    //----------------------------------------------------------------//
}
//================================================================//

//================================================================//
// Objeto para almacenar el estado de validaciones
var validacionInputs = {
    clave_nueva: false
};
//----------------------------------------------------------------//
// Función para validar todos los inputs
function validarInputsF() {
    // Verificar que todos los inputs sean válidos
    var allValid = Object.values(validacionInputs).every(v => v === true);
    
    $("#btnCambio_clave").prop("disabled", !allValid);
    //alert(allValid ? 'habilitado' : 'deshabilitado');
}
//================================================================//

//================================================================//
// Evento se activa al cambiar el valor del input del campo clave
$("#clave_actual").change(function(e) {
    e.preventDefault();

    //----------------------------------------------------------------//
    //limitar el minimo de caracteres permitidos clave
    var clave_actual = $("#clave_actual").val();
    //obtener el elemento message por su ID
    var messageElement = $('#message-clave_actual');
    messageElement.text('');

    if (clave_actual.length < 8) {
        //$("#btnCambio_clave").prop("disabled", true);//deshabilitar el boton 
        $("#clave_actual").addClass("is-invalid");
        messageElement.text('Minimo 8 caracteres!');
        validacionInputs.clave_nueva = false;
        validarInputsF();
    }else{
        $("#clave_actual").removeClass("is-valid is-invalid");
        //$("#btnCambio_clave").prop("disabled", false);//habilitar el boton 
        validacionInputs.clave_nueva = true;
        validarInputsF();
    }
});
//================================================================//
$("#clave_nueva").change(function(e) {
    e.preventDefault();

    //----------------------------------------------------------------//
    //limitar el minimo de caracteres permitidos clave
    var clave_nueva = $("#clave_nueva").val();
    //obtener el elemento message por su ID
    var messageElement = $('#message-clave_nueva');
    messageElement.text('');

    if (clave_nueva.length < 8) {
        //$("#btnCambio_clave").prop("disabled", true);//deshabilitar el boton 
        $("#clave_nueva").addClass("is-invalid");
        messageElement.text('Minimo 8 caracteres!');
        validacionInputs.clave_nueva = false;
        validarInputsF();
    }else{
        $("#clave_nueva").removeClass("is-valid is-invalid");
        //$("#btnCambio_clave").prop("disabled", false);//habilitar el boton 
        validacionInputs.clave_nueva = true;
        validarInputsF();
    }
});
//================================================================//
$("#rep_clave").change(function(e) {
    e.preventDefault();

    //----------------------------------------------------------------//
    //limitar el minimo de caracteres permitidos clave
    var rep_clave = $("#rep_clave").val();
    //obtener el elemento message por su ID
    var messageElement = $('#message-rep_clave');
    messageElement.text('');

    if (rep_clave.length < 8) {
        //$("#btnCambio_clave").prop("disabled", true);//deshabilitar el boton 
        $("#rep_clave").addClass("is-invalid");
        messageElement.text('Minimo 8 caracteres!');
        validacionInputs.clave_nueva = false;
        validarInputsF();
    }else{
        $("#rep_clave").removeClass("is-valid is-invalid");
        //$("#btnCambio_clave").prop("disabled", false);//habilitar el boton 
        validacionInputs.clave_nueva = true;
        validarInputsF();
    }
});
//================================================================//

//================================================================//
//limitar el maximo de caracteres permitidos 
const claveActual = $('#clave_actual');

// Agregar un event listener para el evento 'input'
claveActual.on('input', () => {
    // Obtener el valor actual del input
    let clave_actualR = claveActual.val();

    // limitar a maximo 16 caracteres
    if (clave_actualR.length > 16) {
        claveActual.val(clave_actualR.slice(0, 16));
    }
});
//----------------------------------------------------------------//
//limitar el maximo de caracteres permitidos
const clave_nueva = $('#clave_nueva');

// Agregar un event listener para el evento 'input'
clave_nueva.on('input', () => {
    // Obtener el valor actual del input
    let clave_nuevaR = clave_nueva.val();

    // limitar a maximo 16 caracteres
    if (clave_nuevaR.length > 16) {
        clave_nueva.val(clave_nuevaR.slice(0, 16));
    }
});
//----------------------------------------------------------------//
//limitar el maximo de caracteres permitidos
const rep_clave = $('#rep_clave');

// Agregar un event listener para el evento 'input'
rep_clave.on('input', () => {
    // Obtener el valor actual del input
    let rep_claveR = rep_clave.val();

    // limitar a maximo 16 caracteres
    if (rep_claveR.length > 16) {
        rep_clave.val(rep_claveR.slice(0, 16));
    }
});
//================================================================//

//================================================================//
$('#eyeOn0').on('click', function() {
    const input = $('#clave_actual');
    togglePasswordVisibility(input, $(this));
});

$('#eyeOn1').on('click', function() {
    const input = $('#clave_nueva');
    togglePasswordVisibility(input, $(this));
});

$('#eyeOn2').on('click', function() {
    const input = $('#rep_clave');
    togglePasswordVisibility(input, $(this));
});

function togglePasswordVisibility(input, icon) {
  if (input.attr('type') === 'password') {
    input.attr('type', 'text');
    icon.removeClass('fa-eye').addClass('fa-eye-slash');
  } else {
    input.attr('type', 'password');
    icon.removeClass('fa-eye-slash').addClass('fa-eye');
  }
}
//================================================================//

init();