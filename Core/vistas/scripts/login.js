function init(){
    $("#formulario_login").on('submit', function(e) 
    {
        e.preventDefault(); //Evita el envío del formulario por defecto
        login(e);  
    });
}

function login(e)
{
    e.preventDefault(); //Evita el envío del formulario por defecto

    const usuario = $("#usuario").val();
    const clave = $("#clave").val();

    $.post("../ajax/login.php?op=verificar&r=" + new Date().getTime(), {
        usuario: usuario,
        clave: clave
    }, function(data, status) {
        if (data != false) {
            Swal.fire({
                title: '¡Exito!',
                text: 'Sesión iniciada correctamente',
                icon: 'success',
                showConfirmButton: false, // Oculta el botón de confirmación
                timer: 1300 // Espera 1.3 segundos antes de cerrar la alerta
            }).then(() => {
                $(location).attr("href", "concepto.php");
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: 'Usuario y/o Clave incorrectos',
                icon: 'error',
                confirmButtonText: 'Inténtalo de nuevo'
            });
        }
    });
}

//================================================================//
$('#eyeOn0').on('click', function() {
    const input = $('#clave');
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