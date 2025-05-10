<?php 
require_once "../modelos/Usuarios.php";

$opciones_usuario = new Usuarios();

//======================================================================//
$op=isset($_GET["op"]) ? limpiarCadena($_GET["op"]) : "";// $_GET
//Recibir clave y Encriptarla (caso: registro o edicion)

$clave_actual = isset($_POST["clave_actual"]) ? limpiarCadena($_POST["clave_actual"]) : "";
$clave_actualMD5 = md5($clave_actual);//encriptar clave $clave_actual

$clave_nueva = isset($_POST["clave_nueva"]) ? limpiarCadena($_POST["clave_nueva"]) : "";
$clave_nuevaMD5 = md5($clave_nueva);//encriptar clave $clave_nueva

$id_usuario=isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
//======================================================================//
switch ($op){
case 'cambio_clave':
     $rspta=$opciones_usuario->cambio_clave($clave_actualMD5, $clave_nuevaMD5, $id_usuario);
        echo $rspta;
    break; 
}
?>