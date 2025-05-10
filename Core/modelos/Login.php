<?php
//Incluir la conexion a la base de datos
require("../config/Conexion.php");

class Login
{
    //constructor
    public function __construct(){
    }
//--------------------------------------------------------------------------------//
    //metodo para iniciar sesion 
    function inicioSesion($usuario,$claveMD5){

        $q="SELECT id,usuario,clave FROM usuarios WHERE usuario = '$usuario' AND status = 1 LIMIT 1";

        //die($q);
        $rspta = ejecutarConsulta($q);//Ejecutar consulta

        while ($reg = $rspta->fetch_object()) {
            if ($reg->clave==$claveMD5) {
                $_SESSION['_AL_login'] = $reg->usuario;
                $_SESSION['_AL_id'] = $reg->id;
                return 1;
            }else{
                return 0;
            }
        }
    }
//--------------------------------------------------------------------------------//
}//Fin de la clase
?>