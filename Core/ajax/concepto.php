<?php   
require("../modelos/Gestor_de_stock.php");

$gestor_de_stock = new Gestor_de_stock; //Creamos nuestro objeto

//======================================================================================================//

    //Definicion de todas las variables
    $op = isset($_GET["op"]) ? limpiarCadena($_GET["op"]) : "";// $_GET
    $id_categoria = isset($_POST["id_categoria"]) ? limpiarCadena($_POST["id_categoria"]) : "";
    $id_sub_categoria = isset($_POST["id_sub_categoria"]) ? limpiarCadena($_POST["id_sub_categoria"]) : "";
    $fecha_desde = isset($_POST["fecha_desde"]) ? limpiarCadena($_POST["fecha_desde"]) : "";
    $fecha_hasta = isset($_POST["fecha_hasta"]) ? limpiarCadena($_POST["fecha_hasta"]) : "";

//======================================================================================================//

    $fecha_completa = date('Y-m-d H:i:s');
    $fecha_formateada = date('d-m-Y');

//======================================================================================================//

    // recibimos cada uno de los arrays verificando si existen, y verificando si efectivamente son un array
    if (!empty($_POST['id_producto']) && is_array($_POST['id_producto'])) {
       $id_producto = $_POST['id_producto'];//recibir array
       //echo 'ID Productos: ' . implode(', ', $id_producto) . "\n"; // Imprimir array
    }else {
        $id_producto = []; //arreglo vacío
    }

    if (!empty($_POST['entrada']) && is_array($_POST['entrada'])) {
       $entrada = limpiarNumero(limpiarCadena($_POST['entrada']));//recibir array 
       //echo 'Entradas: ' . implode(', ', $entrada) . "\n"; // Imprimir array
    }else {
        $entrada = []; //arreglo vacío
    }

    if (!empty($_POST['salida']) && is_array($_POST['salida'])) { 
       $salida = limpiarNumero(limpiarCadena($_POST['salida']));//recibir array
       //echo 'Salidas: ' . implode(', ', $salida) . "\n"; // Imprimir array
    }else {
        $salida = []; //arreglo vacío
    }

    if (!empty($_POST['stock_actual']) && is_array($_POST['stock_actual'])) {
       $stock_actual = limpiarNumero(limpiarCadena($_POST['stock_actual']));//recibir array 
       //echo 'Stock actuales: ' . implode(', ', $stock_actual) . "\n"; // Imprimir array
    }else {
        $stock_actual = []; //arreglo vacío
    }

    if (!empty($_POST['fecha']) && is_array($_POST['fecha'])) {
       $fecha = $_POST['fecha'];//recibir array
       //echo 'Fechas Completas: ' . implode(', ', $fecha) . "\n"; // Imprimir array
    }else {
        $fecha = []; //arreglo vacío
    }

//======================================================================================================//

switch ($op){
case 'listar':
    $rspta = $gestor_de_stock->listar();

    //inicializar array donde se almacenarán todos datos recibidos en la respuesta
    $data = [];

    //Bucle para llenar el array con las respuestas obtenidas
    while ($row = $rspta->fetch_assoc()) {

    //Estructura de datos 
        $data[] = [
            "id" => $row['id'],
            "producto" => $row['producto'],
            "entradas" => $row['entradas'],
            "salidas" => $row['salidas'],
            "stock_actual" => muestrafloat($row['stock_actual']),
            "nombre_categoria" => $row['nombre_categoria'],
            "nombre_sub_categoria" => $row['nombre_sub_categoria'],
            "stock_minimo" => muestrafloat($row['stock_minimo']),
            "fecha_creacion" => $row['fecha_creacion'],
            "tipo_de_unidad" => $row['tipo_de_unidad'],
            "fecha_completa" => $fecha_completa,
            "fecha_formateada" => $fecha_formateada,
        ];
    }

    /*Tras recolectar los datos, se agrega un nuevo array a '$data' llamado '$response', 
    que contiene todos los detalles del producto
    toda la respuesta se codifican en formato JSON*/
    $response = [
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "data" => $data
    ];

    echo json_encode($response);//Retornar el resultado utilizando json
    break;

case 'actualizar':
    $rspta = $gestor_de_stock->actualizar($entrada,$salida,$stock_actual,$fecha,$id_producto);
    echo $rspta;
    break;

case 'listarHistorialEntradasySalidas':
    $rspta=$gestor_de_stock->listarHistorialEntradasySalidas($fecha_desde,$fecha_hasta,$id_categoria,$id_sub_categoria);

    $data = [];
    while ($row = $rspta->fetch_assoc()) {

        //-----------------------------------------//
        $fechaEntradaM = $row['fechaEntradaM'];
        $fechaSalidaM = $row['fechaSalidaM'];
        //-----------------------------------------//
        if (!empty($fechaEntradaM)) {
            $fechaEntradaM_formateada = date_format(new DateTime($fechaEntradaM), 'd-m-Y H:i A');
        }else{
           $fechaEntradaM_formateada = "--/--/--";//Default 
        }
        if (!empty($fechaSalidaM)) {
            $fechaSalidaM_formateada = date_format(new DateTime($fechaSalidaM), 'd-m-Y H:i A');
        }else{
            $fechaSalidaM_formateada = "--/--/--";//Default
        }
        //-----------------------------------------//

        $data[] = [
            "0" => $row['nombre_categoria'],
            "1" => $row['nombre_sub_categoria'],
            "2" => $row['nombre_producto'],
            "3" => muestrafloat($row['entradasM']),
            "4" => muestrafloat($row['salidasM']),
            "5" => $fechaEntradaM_formateada,
            "6" => $fechaSalidaM_formateada
        ];
    }
    $results = [
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
    ];

    echo json_encode($results);//Retornar el resultado utilizando json
    break;

case 'listarEntradasySalidas':
    $rspta=$gestor_de_stock->listarEntradasySalidas($id_categoria,$id_sub_categoria);

    $data = [];
    while ($row = $rspta->fetch_assoc()) {

        $data[] = [
            "0" => $row['nombre_categoria'],
            "1" => $row['nombre_sub_categoria'],
            "2" => $row['nombre_producto'],
            "3" => muestrafloat($row['entradasM']),
            "4" => muestrafloat($row['salidasM'])
        ];
    }
    $results = [
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
    ];

    echo json_encode($results);//Retornar el resultado utilizando json
    break;

case 'verificarEntradasalidaTotal':
    $rspta = $gestor_de_stock->verificarEntradasalidaTotal();
    echo $rspta;
    break;
}// FIN switch
?>