<?php 
//Incluir la conexion a la base de datos
require "../config/Conexion.php";

Class Usuarios
{
//--------------------------------------------------------------------------------//
	//Implementamos nuestro constructor
	public function __construct(){
	}
//--------------------------------------------------------------------------------//
 	public function cambio_clave($clave_actualMD5, $clave_nuevaMD5, $id_usuario)
	{
	//--------------------------------------------------------------------------------//
	// Verificar la contraseña actual
	$q1 = "SELECT COUNT(*) AS total FROM usuarios WHERE id = '$id_usuario' AND clave = '$clave_actualMD5'";

	//die($q1);
	$rpsta1 = ejecutarConsultaSimpleFila($q1); // Ejecutar la consulta de verificación
	//--------------------------------------------------------------------------------//
	// Obtener el valor del conteo de filas
	if ($rpsta1) {
	    $count = $rpsta1['total']; // Extraer el valor del conteo
	    // Si el conteo devuelve 1, significa que la contraseña actual es correcta
	    if ($count == '1') {
	        $q2 = "UPDATE usuarios SET clave = '$clave_nuevaMD5' WHERE id = '$id_usuario'";

	        //die($q2);
	        $rspta2 = ejecutarConsulta($q2); // Ejecutar consulta para actualizar la contraseña
	        return "Clave actualizada exitosamente.";// Mensaje de exito
	    } else {
	        return "Clave actual incorrecta Intenta nuevalente."; // Mensaje de error
	    }
	} else {
	    return "Error en la consulta."; // Mensaje de error
	}
	}
//--------------------------------------------------------------------------------//
}
?>