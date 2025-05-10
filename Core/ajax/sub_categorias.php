<?php   
require("../modelos/Sub_categorias.php");

$sub_categorias = new Sub_categorias; //Creamos nuestro objeto

//======================================================================================================//
    //Definicion de todas las variables
    $op = isset($_GET["op"]) ? limpiarCadena($_GET["op"]) : "";// $_GET
    $sub_categoria = isset($_POST["sub_categoria"]) ? limpiarCadena($_POST["sub_categoria"]) : "";

    $id_sub_categoria = isset($_POST["id_sub_categoria"]) ? limpiarCadena($_POST["id_sub_categoria"]) : "";
    if ($id_sub_categoria == 0) {
       $id_sub_categoria = "";
    }

    $status = 1;
//======================================================================================================//

switch ($op){

 case 'comprobarCategorias':
        $rspta=$sub_categorias->comprobarCategorias();
            if ($rspta == "existenCategorias") {
                echo $rspta = "existe";
            }else{
                echo $rspta = "sinResultados";  
            }
    break;

    case 'listarcategorias':
    $rspta=$sub_categorias->listarcategorias();

    $data = [];
    while ($row = $rspta->fetch_assoc()) {

    $data[] = [
    "0" => $row['id'],
    "1" => $row['categoria'],
    "2" => '
        <style>
            .largerCheckbox {
                width: 18px;
                height: 18px;
                margin: 0;
            }
        </style>
        <input type="checkbox" id="' . $row['id'] . '" class="largerCheckbox tblChk chk" align="center">
    ',
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

    case 'listar':
    $rspta=$sub_categorias->listar();

    $data = [];
    while ($row = $rspta->fetch_assoc()) {
        $data[] = [
            "0" => $row['categoria'],
            "1" => $row['sub_categoria'],
            "2" => $row['cantidad_productos'],
            /*"3"=>'
            <div class="dropdown">
                <button class="btn" style="background: #fd7e14; color:white;" id="dropdownMenuButton" data-toggle="dropdown">
                    <i class="fa fa-ellipsis-v"></i>
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <!-- Verificar el status para "eliminar" -->
                    ' . ($row['status'] != 0 ? '
                         <a class="dropdown-item text-danger" onclick="eliminar('.$row['id'].')" style="cursor: pointer;">
                            <i class="fa fa-trash"></i> Eliminar
                        </a>
                        ' : '')
                    . '
                </div>
            </div>'*/
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

case 'guardar':
        $rspta = $sub_categorias->guardar($sub_categoria);
        if ($rspta) {
            $id_sub_categoria = $sub_categorias->obtenerID($sub_categoria); // Obtener id del proveedor
            $resultados = []; // Array para almacenar los resultados

            // recibir las categorias seleccionadas
            if (!empty($_POST['checks']) && is_array($_POST['checks'])) {
                $checks = $_POST['checks'];

                // agregar las categorias al proveedor
                foreach ($checks as $id_categoria) {
                    $rspta = $sub_categorias->agregar_categoria_sub_categoria($id_sub_categoria, $id_categoria);
                    $resultados[] = $rspta; // Almacena cada resultado en el array
                }
            }
        }
        echo $rspta ? "Registro exitoso" : "No se pudo registrar";
    break;

 case 'eliminar':
        $rspta=$sub_categorias->eliminar($id_sub_categoria);
        echo $rspta ? "Registro eliminado" : "No se pudo eliminar";
    break;
/*
 case 'mostrar':
        $rspta=$sub_categorias->mostrar($id_sub_categoria);
        echo json_encode($rspta);//Retornar el resultado utilizando json
    break;

 case 'eliminar':
        $rspta=$sub_categorias->eliminar($id_sub_categoria);
        echo $rspta ? "Registro eliminado" : "No se pudo eliminar";
    break;
//========================== SELECTS 2 =================================//
case 'Listar_proveedores':

    $rspta = $sub_categorias->select2_proveedores();

    echo '<option value="">Seleccione</option>';
    while ($row = $rspta->fetch_object()) {
      echo '<option value="' . $row->id . '">' . $row->proveedor . '</option>';
    }
    break;
*/
}// FIN switch
?>