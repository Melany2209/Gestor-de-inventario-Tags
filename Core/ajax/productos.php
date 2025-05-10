<?php   
require("../modelos/Productos.php");
require("../modelos/Categorias.php");
require("../modelos/Sub_categorias.php");

$producto = new Productos; //Creamos nuestro objeto

//======================================================================================================//
    //Definicion de todas las variables
    $op = isset($_GET["op"]) ? limpiarCadena($_GET["op"]) : "";// $_GET
    $nombre_producto = isset($_POST["nombre_producto"]) ? limpiarCadena($_POST["nombre_producto"]) : "";
    $stock_actual = isset($_POST["stock_actual"]) ? limpiarNumero(limpiarCadena($_POST["stock_actual"])) : "";
    //$stock_actual = isset($_POST["stock_actual"]) ? limpiarCadena($_POST["stock_actual"]) : "";
    $tipo_unidadR = isset($_POST["tipo_unidad"]) ? limpiarCadena($_POST["tipo_unidad"]) : "";
    $stock_minimo = isset($_POST["stock_minimo"]) ? limpiarNumero(limpiarCadena($_POST["stock_minimo"])) : "";
    //$stock_minimo = isset($_POST["stock_minimo"]) ? limpiarCadena($_POST["stock_minimo"]) : "";
    $id_categoria = isset($_POST["id_categoria"]) ? limpiarCadena($_POST["id_categoria"]) : "";
    $id_sub_categoria = isset($_POST["id_sub_categoria"]) ? limpiarCadena($_POST["id_sub_categoria"]) : "";
    $status = isset($_POST["status"]) ? limpiarCadena($_POST["status"]) : "";
    $id_producto = isset($_POST["id_producto"]) ? limpiarCadena($_POST["id_producto"]) : "";
//======================================================================================================//

switch ($op){

 case 'comprobarSubCategorias':
        $rspta=$producto->comprobarSubCategorias();
            if ($rspta == "existenSubCategorias") {
                echo $rspta = "existe";
            }else{
                echo $rspta = "sinResultados";  
            }
    break;

    case 'listar':
    $rspta=$producto->listar($nombre_producto,$id_categoria,$id_sub_categoria,$status);

    $data = [];
    while ($row = $rspta->fetch_assoc()) {
        $data[] = [
            "0" => $row['nombre_categoria'],
            "1" => $row['nombre_sub_categoria'],
            "2" => $row['producto'],
            "3" => muestrafloat($row['stock_actual']),
            "4" => $row['tipo_de_unidad'],
            "5" => muestrafloat($row['stock_minimo']),
            "6"=>'
            ' . ($row['status'] != 0 ? '
            <span class="badge badge-success">Activo</span>' : '
            <span class="badge badge-danger">Inactivo</span>'),
            "7"=>'
            <div class="dropdown">
                <button class="btn" style="background: #fd7e14; color:white;" id="dropdownMenuButton" data-toggle="dropdown">
                    <i class="fa fa-ellipsis-v"></i>
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" onclick="mostrar('.$row['id'].')" style="cursor: pointer;">
                    <i class="fa fa-edit"></i> Editar
                    </a>

                    <!-- Verificar el status para "desactivar" o "activar" -->
                    ' . ($row['status'] != 0 ? '
                         <a class="dropdown-item text-danger" onclick="desactivar('.$row['id'].')" style="cursor: pointer;">
                            <i class="fa fa-eye-slash"></i> Desactivar
                        </a>
                        ' : '
                        <a class="dropdown-item text-success" onclick="activar('.$row['id'].')" style="cursor: pointer;">
                            <i class="fa fa-eye"></i> Activar
                        </a>')
                    . '
                </div>
            </div>'
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

case 'guardaryeditar':
if (empty($id_producto)){
        $rspta=$producto->guardar($nombre_producto,$stock_actual,$tipo_unidadR,$stock_minimo,$id_sub_categoria);
        echo $rspta ? "Registro exitoso" : "No se pudo registrar";
    }else{
        $rspta=$producto->editar($nombre_producto,$stock_actual,$tipo_unidadR,$stock_minimo,$id_sub_categoria,$id_producto);
        echo $rspta ? "Registro actualizado" : "No se pudo actualizar";
    }
    break;
 case 'activar':
        $rspta=$producto->activar($id_producto);
        echo $rspta ? "Registro activado" : "No se pudo activar";
    break;

 case 'desactivar':
        $rspta=$producto->desactivar($id_producto);
        echo $rspta ? "Registro desactivado" : "No se pudo desactivar";
    break;

 case 'mostrar':
        $rspta=$producto->mostrar($id_producto);
        echo json_encode($rspta);//Retornar el resultado utilizando json
    break;
//========================== SELECTS 2 =================================//
case 'listarCategorias':
    
    $rspta = Categorias::select2_categorias();

    echo '<option value="">Seleccione</option>';
    while ($row = $rspta->fetch_object()) {
      echo '<option value=' . $row->id . '>' . $row->descripcion . '</option>';
    }
    break;
case 'listarSub_categoriasDEP':
        $id_categoria = $_POST['id_categoria'];
        $rspta = Sub_categorias::select2_sub_categoriasDEP($id_categoria);

        echo '<option value="">Seleccione</option>';
            while ($row = $rspta->fetch_object()) {
            echo '<option value=' . $row->id . '>' . $row->descripcion . '</option>';
        }
    break;
case 'listarSub_categorias':
    
    $rspta = Sub_categorias::select2_sub_categorias();

    echo '<option value="">Seleccione</option>';
    while ($row = $rspta->fetch_object()) {
      echo '<option value=' . $row->id . '>' . $row->descripcion . '</option>';
    }
    break;
}// FIN switch
?>