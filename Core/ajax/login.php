<?php   
session_start(); 
require("../modelos/Login.php");

$login = new Login; //Creamos nuestro objeto

//======================================================================//
    //Definicion de todas las variables
    $op = isset($_GET["op"]) ? limpiarCadena($_GET["op"]) : "";// $_GET
    $usuario = isset($_POST["usuario"])? limpiarCadena($_POST["usuario"]):"";
    $clave = isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
    $claveMD5 = md5($clave);//encriptar clave
//======================================================================//

switch ($op){
case 'verificar':
        $rspta=$login->inicioSesion($usuario,$claveMD5);
        echo $rspta;
    break;

case 'salir':
        //Limpiamos las variables de sesión   
        session_unset();
        //Destruimos la sesión
        session_destroy();
        //Redireccionamos 
        header("Location: ../vistas/login.php");
    break;

}// FIN switch
?>