<?php   
require("../modelos/Categorias.php");

$categoria = new Categorias; //Creamos nuestro objeto

//======================================================================================================//
    //Definicion de todas las variables
    $op = isset($_GET["op"]) ? limpiarCadena($_GET["op"]) : "";// $_GET
    $nombre_categoria = isset($_POST["categoria"]) ? limpiarCadena($_POST["categoria"]) : "";
    $status = isset($_POST["status"]) ? limpiarCadena($_POST["status"]) : "";
    $id_categoria = isset($_POST["id_categoria"]) ? limpiarCadena($_POST["id_categoria"]) : "";
//======================================================================================================//

switch ($op){
    case 'listar':
    $rspta=$categoria->listar($nombre_categoria,$status);

    $data = [];
    while ($row = $rspta->fetch_assoc()) {
        $data[] = [
            "0" => $row['categoria'],
            "1"=>'
            ' . ($row['status'] != 0 ? '
            <span class="badge badge-success">Activo</span>' : '
            <span class="badge badge-danger">Inactivo</span>'),
            "2"=>'
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
if (empty($id_categoria)){
        $rspta=$categoria->guardar($nombre_categoria);
        echo $rspta ? "Registro exitoso" : "No se pudo registrar";
    }else{
        $rspta=$categoria->editar($nombre_categoria,$id_categoria);
        echo $rspta ? "Registro actualizado" : "No se pudo actualizar";
    }
    break;
 case 'activar':
        $rspta=$categoria->activar($id_categoria);
        echo $rspta ? "Registro activado" : "No se pudo activar";
    break;

 case 'desactivar':
        $rspta=$categoria->desactivar($id_categoria);
        echo $rspta ? "Registro desactivado" : "No se pudo desactivar";
    break;

 case 'mostrar':
        $rspta=$categoria->mostrar($id_categoria);
        echo json_encode($rspta);//Retornar el resultado utilizando json
    break;
}// FIN switch
?>