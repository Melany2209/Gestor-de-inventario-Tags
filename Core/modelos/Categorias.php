<?php
//Incluir la conexion a la base de datos
require("../config/Conexion.php");

class Categorias
{

    //constructor
    public function __construct(){
    }

//--------------------------------------------------------------------------------//

    //metodo para guardar registros
    public function guardar($nombre_categoria)
    {
       $q="INSERT INTO categorias (categoria) 
       VALUES ('$nombre_categoria')";

       //die($q);
       $rspta = ejecutarConsulta($q);//Ejecutar consulta
       return $rspta; 
    }

//--------------------------------------------------------------------------------//

    //metodo para mostrar registros que se van a editar
   public function mostrar($id_categoria)
    {
        $q = "SELECT id,categoria FROM categorias WHERE id = '$id_categoria'";

        //die($q);
        $rspta = ejecutarConsultaSimpleFila($q);//Ejecutar consulta simple
        return $rspta; 
    }

//--------------------------------------------------------------------------------//

    //metodo para editar registros
    public function editar($nombre_categoria,$id_categoria)
    {
    $q = "UPDATE categorias SET
       categoria = '$nombre_categoria'
       WHERE id = '$id_categoria'";

       //die($q);
       $rspta = ejecutarConsulta($q);//Ejecutar consulta
       return $rspta;
    }

//--------------------------------------------------------------------------------//

    //metodo para activar registros
    public function activar($id_categoria)
    {
        $q="UPDATE categorias SET
        status = 1
        WHERE id = '$id_categoria'";

        //die($q);
        $rspta = ejecutarConsulta($q);//Ejecutar consulta
        return $rspta;
    }

    //metodo para desactivar registros
    public function desactivar($id_categoria)
    {
        $q="UPDATE categorias SET
        status = 0
        WHERE id = '$id_categoria'";

        //die($q);
        $rspta = ejecutarConsulta($q);//Ejecutar consulta
        return $rspta;
    }

//--------------------------------------------------------------------------------//

    //metodo para listar los registros 
    public function listar($nombre_categoria,$status){

        $q = "SELECT id,categoria,status FROM categorias WHERE 1=1 ";

        if (isset($status) && $status !== '') {
            $q .= "AND status = '$status' ";
        }
        if (isset($nombre_categoria) && $nombre_categoria !== '') {
            $q .= "AND categoria LIKE '%$nombre_categoria%' ";
        }

       //die($q);
       $rspta = ejecutarConsulta($q);//Ejecutar consulta
       return $rspta; 
    }

//========================== SELECTS 2 =================================//

    //metodo select 2 para unidades ejecutoras
    public static function select2_categorias() {
        $q = "SELECT id, categoria as descripcion FROM categorias WHERE status = 1";
        
        //die($q);
        $rspta = ejecutarConsulta($q);//Ejecutar consulta
        return $rspta;
    }
    
//=======================================================================//

}//Fin de la clase
?>