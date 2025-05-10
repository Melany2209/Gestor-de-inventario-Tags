<?php
//Incluir la conexion a la base de datos
require("../config/Conexion.php");

class Productos
{

    //constructor
    public function __construct(){
    }

//--------------------------------------------------------------------------------//

    //metodo para guardar registros
    public function guardar($nombre_producto,$stock_actual,$tipo_unidadR,$stock_minimo,$id_sub_categoria)
    {
        //Obtener id de la categoria y id de la sub categoria
        $q1 = "SELECT id_categoria, id_sub_categoria FROM categoria_sub_categoria WHERE id = '$id_sub_categoria'";

        //die($q1);
        $rspta1 = ejecutarConsultaSimpleFila($q1);//Ejecutar consulta simple
        $id_sub_categoria = $rspta1['id_sub_categoria'];
        $id_categoria = $rspta1['id_categoria'];
    
        if ($rspta1) {
            //Insertar producto
            $q2="INSERT INTO productos (producto,stock_actual,tipo_de_unidad,stock_minimo,id_sub_categoria,id_categoria) 
            VALUES ('$nombre_producto','$stock_actual','$tipo_unidadR','$stock_minimo','$id_sub_categoria','$id_categoria')";

            //die($q2);
            $rspta2 = ejecutarConsulta($q2);//Ejecutar consulta
            return $rspta2;
        }   
    }

//--------------------------------------------------------------------------------//

    public function comprobarSubCategorias() {
        $q = "SELECT COUNT(*)
              FROM sub_categorias 
              WHERE status = '1'";

        //die($q);
        $rspta = ejecutarConsulta($q);

        $num_rows = mysqli_fetch_row($rspta)[0];
        if ($num_rows > 0) {
            return "existenSubCategorias";
        }else{
            return "sinResultados";
        }
    }

//--------------------------------------------------------------------------------//

    //metodo para mostrar registros que se van a editar
   public function mostrar($id_producto)
    {
        $q = "SELECT id,producto,stock_actual,tipo_de_unidad,stock_minimo,id_sub_categoria FROM productos WHERE id = '$id_producto'";

        //die($q);
        $rspta = ejecutarConsultaSimpleFila($q);//Ejecutar consulta simple
        return $rspta; 
    }

//--------------------------------------------------------------------------------//

    //metodo para editar registros
    public function editar($nombre_producto,$stock_actual,$tipo_unidadR,$stock_minimo,$id_sub_categoria,$id_producto)
    {
        //Obtener id de la categoria y id de la sub categoria
        $q1 = "SELECT id_categoria, id_sub_categoria FROM categoria_sub_categoria WHERE id = '$id_sub_categoria'";

        //die($q1);
        $rspta1 = ejecutarConsultaSimpleFila($q1);//Ejecutar consulta simple
        $id_sub_categoria = $rspta1['id_sub_categoria'];
        $id_categoria = $rspta1['id_categoria'];

        if ($rspta1) {
            $q2 = "UPDATE productos SET
               producto = '$nombre_producto',
               stock_actual = '$stock_actual',
               tipo_de_unidad = '$tipo_unidadR',
               stock_minimo = '$stock_minimo',
               id_categoria = '$id_categoria',
               id_sub_categoria = '$id_sub_categoria'
               WHERE id = '$id_producto'";

               //die($q2);
               $rspta2 = ejecutarConsulta($q2);//Ejecutar consulta
               return $rspta2;
        }
    }

//--------------------------------------------------------------------------------//

    //metodo para activar registros
    public function activar($id_producto)
    {
        $q="UPDATE productos SET
        status = 1
        WHERE id = '$id_producto'";

        //die($q);
        $rspta = ejecutarConsulta($q);//Ejecutar consulta
        return $rspta;
    }

    //metodo para desactivar registros
    public function desactivar($id_producto)
    {
        $q="UPDATE productos SET
        status = 0
        WHERE id = '$id_producto'";

        //die($q);
        $rspta = ejecutarConsulta($q);//Ejecutar consulta
        return $rspta;
    }

//--------------------------------------------------------------------------------//

    //metodo para listar los registros 
    public function listar($nombre_producto,$id_categoria,$id_sub_categoria,$status){

        $q = "SELECT p.id, p.producto, p.status, p.fecha_creacion, 
            c.categoria AS nombre_categoria, 
            sc.id AS id_sub_categoria,
            sc.sub_categoria AS nombre_sub_categoria, p.stock_minimo, p.stock_actual, p.tipo_de_unidad
            FROM productos p 
            INNER JOIN categorias c ON p.id_categoria = c.id
            INNER JOIN sub_categorias sc ON p.id_sub_categoria = sc.id
            WHERE 1 = 1 ";

        if (isset($status) && $status !== '') {
            $q .= "AND p.status = '$status' ";
        }
        if (isset($nombre_producto) && $nombre_producto !== '') {
            $q .= "AND p.producto LIKE '%$nombre_producto%' ";
        }
        if (isset($id_categoria) && $id_categoria !== '') {
            $q .= "AND p.id_categoria = '$id_categoria' ";
        }
        if (isset($id_sub_categoria) && $id_sub_categoria !== '') {
            $q .= "AND sc.id = '$id_sub_categoria' ";
        }

       //die($q);
       $rspta = ejecutarConsulta($q);//Ejecutar consulta
       return $rspta; 
    }

//--------------------------------------------------------------------------------//

}//Fin de la clase
?>