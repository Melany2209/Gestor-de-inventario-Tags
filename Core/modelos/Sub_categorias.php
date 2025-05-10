<?php
//Incluir la conexion a la base de datos
require("../config/Conexion.php");

class Sub_categorias
{

    //constructor
    public function __construct(){
    }

//--------------------------------------------------------------------------------//

    //metodo para guardar registros
    public function guardar($sub_categoria)
    {
       $q="INSERT INTO sub_categorias (sub_categoria) 
       VALUES ('$sub_categoria')";

       //die($q);
       $rspta = ejecutarConsulta($q);//Ejecutar consulta
       return $rspta; 
    }

    //metodo para obtener id del proveedor
    public function obtenerID($sub_categoria)
    {
       $q="SELECT id FROM sub_categorias WHERE sub_categoria = '$sub_categoria'";

        //die($q);
        $rspta = ejecutarConsultaSimpleValor($q);//Obtener solo un valor de la consulta
        return $rspta;
    }

    //metodo para agregar categoria al proveedor
    public function agregar_categoria_sub_categoria($id_sub_categoria, $id_categoria)
    {
       $q="INSERT INTO categoria_sub_categoria (id_sub_categoria, id_categoria) 
       VALUES ('$id_sub_categoria', '$id_categoria')";

       //die($q);
       $rspta = ejecutarConsulta($q);//Ejecutar consulta
       return $rspta; 
    }


//--------------------------------------------------------------------------------//
    //metodo para eliminar registros
    public function eliminar($id_sub_categoria)
    {
        $q1="UPDATE sub_categorias SET
        status = 0
        WHERE id = '$id_sub_categoria'";

        //die($q1);
        $rspta1 = ejecutarConsulta($q1);//Ejecutar consulta
        if ($rspta1) {
            $q2="UPDATE categoria_sub_categoria SET
            status = 0
            WHERE id_sub_categoria = '$id_sub_categoria'";

            //die($q2);
            $rspta2 = ejecutarConsulta($q2);//Ejecutar consulta
            return $rspta1;//retornar la respuesta 1
        }
        
    }
//--------------------------------------------------------------------------------//

    //metodo para listar los registros 
    public function listar(){
        
    /*Nota: 
    1) COUNT(DISTINCT ...): Esto asegura que solo cuentes productos y categorías únicos.
    2) GROUP BY: Es necesario para agrupar resultados según la sub categoria. Sin esto, se podrian obtener resultados duplicados.

    3)
    - Se usa un CASE dentro del COUNT() para contar solo los p.id que cumplen con p.status = '1'.
    - Así, el resto de la consulta seguirá funcionando y mostrará las subcategorías aunque no haya productos activos.
    */
        $q = "SELECT sc.id, 
       sc.sub_categoria, 
       sc.status, 
       c.categoria,
       COUNT(DISTINCT CASE WHEN p.status = '1' THEN p.id END) AS cantidad_productos
       FROM sub_categorias sc 
       LEFT JOIN productos p ON sc.id = p.id_sub_categoria
       LEFT JOIN categoria_sub_categoria csc ON sc.id = csc.id_sub_categoria
       LEFT JOIN categorias c ON csc.id_categoria = c.id
       WHERE sc.status = '1'
       GROUP BY sc.id, sc.sub_categoria, sc.status, c.categoria ";

       //die($q);
       $rspta = ejecutarConsulta($q);//Ejecutar consulta
       return $rspta; 
    }

//--------------------------------------------------------------------------------//
    public function comprobarCategorias() {
        $q = "SELECT COUNT(*)
              FROM categorias 
              WHERE status = '1'";

        //die($q);
        $rspta = ejecutarConsulta($q);

        $num_rows = mysqli_fetch_row($rspta)[0];
        if ($num_rows > 0) {
            return "existenCategorias";
        }else{
            return "sinResultados";
        }
    }

    public function listarcategorias() {
    $q = "SELECT id, categoria
          FROM categorias 
          WHERE status = '1'";

    //die($q);
    $rspta = ejecutarConsulta($q);
    return $rspta; 
    }
    
//========================== SELECTS 2 =================================//

    //metodo select 2 para unidades ejecutoras
    public static function select2_sub_categorias() {
        $q = "SELECT id, sub_categoria as descripcion FROM sub_categorias WHERE status = 1";
        
        //die($q);
        $rspta = ejecutarConsulta($q);//Ejecutar consulta
        return $rspta;
    }
    
//=======================================================================//

    public static function select2_sub_categoriasDEP($id_categoria) {
        $q="SELECT sc.id AS id, 
       sc.sub_categoria AS descripcion
       FROM sub_categorias sc 
       LEFT JOIN categoria_sub_categoria csc ON sc.id = csc.id_sub_categoria
       LEFT JOIN categorias c ON csc.id_categoria = c.id
       WHERE c.id = '$id_categoria'
       GROUP BY sc.id";

        //die($q);
        $rspta = ejecutarConsulta($q);//Ejecutar consulta
        return $rspta;
    }

//=======================================================================//
}//Fin de la clase
?>