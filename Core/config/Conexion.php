<?php 
require_once "global.php";

$conexion = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

mysqli_query($conexion, 'SET NAMES "'.DB_ENCODE.'"');

//Si tenemos un posible error en la conexión lo mostramos
if (mysqli_connect_errno())
{
	printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
	exit();
}

if (!function_exists('ejecutarConsulta'))
{
	function ejecutarConsulta($sql)
	{
		global $conexion;
		$query = $conexion->query($sql);
		return $query;
	}

	function ejecutarConsultaSimpleFila($sql)
	{
		global $conexion;
		$query = $conexion->query($sql);		
		$row = $query->fetch_assoc();
		return $row;
	}

	function ejecutarConsulta_retornarID($sql)
	{
		global $conexion;
		$query = $conexion->query($sql);		
		return $conexion->insert_id;			
	}

	/*function limpiarCadena($str)
	{
		global $conexion;
		$str = mysqli_real_escape_string($conexion,trim($str));
		return htmlspecialchars($str);
	}*/

	function limpiarCadena($input) {
	    global $conexion;

	    if (is_array($input)) {
	        // Si es un array, limpiamos cada elemento
	        return array_map('limpiarCadena', $input);
	    } else {
	        // Si es un string, limpiamos como antes
	        $input = mysqli_real_escape_string($conexion, trim($input));
	        return htmlspecialchars($input);
	    }
	}

	function ejecutarConsultaSimpleValor($sql)
    {
     global $conexion;
     $query = $conexion->query($sql);
     $row = $query->fetch_row();
     return $row[0];
    }

    function ejecutarConsultaMultipleFilas($sql)
	{
    global $conexion;
    $query = $conexion->query($sql);
    $result = [];
    
    while ($row = $query->fetch_assoc()) {
        $result[] = $row; // Agregar cada fila al arreglo de resultados
    }
    
    return $result; // Devolver todas las filas
	}
//===================================================//
	//remover . entre numeros
	function limpiarNumero($numero) {
	    // Si es un array, aplica la limpieza a cada elemento
	    if (is_array($numero)) {
	        return array_map('limpiarNumero', $numero); // Aplica la función recursivamente
	    }

    	// Elimina los puntos y reemplaza la coma por un punto
    	$numero = str_replace('.', '', $numero); // Elimina los puntos 
    	$numero = str_replace(',', '.', $numero); // en caso de existir coma , Reemplaza la coma , por un punto .
    	return (float)$numero; // Convierte a float y lo retorna
	}

	//formatear cedula con divisor . en unidades de miles y sin decimales
	function formatearCedula($cedula){
  		return number_format($cedula, 0, ',', '.');
	}
	
	//formatear valores numericos con divisor . en unidades de miles y con dos decimales (1,00)
	function muestrafloat($monto){
  		return number_format($monto, 2, ',', '.');
	}
//===================================================//
}
?>