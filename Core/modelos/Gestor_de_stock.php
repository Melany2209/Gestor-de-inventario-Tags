<?php
//Incluir la conexion a la base de datos
require("../config/Conexion.php");

class Gestor_de_stock
{

    //constructor
    public function __construct(){
    }

//--------------------------------------------------------------------------------//

    //metodo para Actualizar registros
    public function actualizar($entrada, $salida, $stock_actual, $fecha, $id_producto)
    {

        // Función para obtener salidas basada en $id_entradasalidaTotal
        function obtenerEntradaSalidaActual($id_entradasalidaTotal, $entrada, $salida) {
            // Verificar si $salida está vacío
            if (empty($salida)) {
                // Si $salida está vacío, ejecutar consulta $qB
                $qB = "SELECT salidas FROM entradasalidaTotal WHERE id = '$id_entradasalidaTotal'";
                $rsptaB = ejecutarConsultaSimpleFila($qB); // Ejecutar consulta simple
                if ($rsptaB) {
                    $salidaActual = $rsptaB['salidas'];
                    return $salidaActual;
                }
            } 
            
            // Verificar si $entrada está vacío
            if (empty($entrada)) {
                // Si $entrada está vacío, ejecutar consulta $qC
                $qC = "SELECT entradas FROM entradasalidaTotal WHERE id = '$id_entradasalidaTotal'";
                $rsptaC = ejecutarConsultaSimpleFila($qC); // Ejecutar consulta simple
                if ($rsptaC) {
                    $entradaActual = $rsptaC['entradas'];
                    return $entradaActual;
                }
            }

            return null; // Devuelve null si no hay resultado en ninguna consulta
        }

        //Recorrer "$id_producto" para determinar cuantas veces se va a iterar
        for ($i = 0; $i < count($id_producto); $i++) {

            //-------------------------------------------------------------------//
            //Verificar si hay movimientos en (entradasalidaTotal) 
            //(retorna 1 si hay movimientos en (entradasalidaTotal), y si no retorna 0)
            $q1 = "SELECT COUNT(id) FROM entradasalidaTotal";

            //die($q1);
            $rspta1 = ejecutarConsulta($q1);

            $num_rows = mysqli_fetch_row($rspta1)[0];
            if ($num_rows > 0) {

                // Obtener el ultimo id del movimiento en especifico
                $qA = "SELECT id FROM entradasalidaTotal WHERE id_producto = '$id_producto[$i]' ORDER BY id DESC LIMIT 1";

                //die($qA);
                $rsptaA = ejecutarConsultaSimpleFila($qA); // Ejecutar consulta simple
                
                // Verificar si $rsptaA no es null
                if ($rsptaA) {
                    // Solo acceder a los valores si $rsptaA no es null
                    $id_entradasalidaTotal = $rsptaA['id'];

                    //Obtener entradas y salidas del movimiento en especifico (entradasalidaTotal)
                    $q2 = "SELECT entradas,salidas FROM entradasalidaTotal WHERE id = '$id_entradasalidaTotal'";

                    //die($q2);
                    $rspta2 = ejecutarConsultaSimpleFila($q2); // Ejecutar consulta simple

                        $entradasMov = $rspta2['entradas'];
                        $salidasMov = $rspta2['salidas'];
                        //------------------//
                        $resultadoValue = 1; // hay movimientos en (entradasalidaTotal)
                        //------------------//
                } else {
                    // Si no hay datos, asignar valores por defecto de lo contrario nos dara error
                    $id_entradasalidaTotal = 0;
                    $entradasMov = 0;
                    $salidasMov = 0;
                    //------------------//
                    $resultadoValue = 0;// no hay movimientos en (entradasalidaTotal) 
                    //------------------//
                }
                //-------------------------------------------------------------------//
            } else {
                $resultadoValue = 0; // no hay movimientos en (entradasalidaTotal)
            }
            //-------------------------------------------------------------------//     

            // Validar que exista una salida o una entrada
            if (!empty($entrada[$i]) || !empty($salida[$i])) {

            //Verificar que la entrada no contenga numeros menores a cero.
            if ($entrada[$i] < 0) {
                return "La entrada no puede ser un numero negativo.";
            }else{ 
                $stock_actual[$i] += $entrada[$i]; // Sumar la entrada al stock actual
                // Verificamos el valor de retorno de movimientos
                if ($resultadoValue == 1) {
                    $entradasMov += $entrada[$i]; // Sumar la entrada a la entrada actual 
                }
            }
            
            //Verificar que la salida no contenga numeros menores a cero.
            if ($salida[$i] < 0) {
                return "La salida no puede ser un numero negativo.";
            }else{
                //verificar si hay suficiente stock para realizar la salida
                if ($stock_actual[$i] >= $salida[$i]) {
                    $stock_actual[$i] -= $salida[$i]; // Restar la salida del stock actual
                    // Verificamos el valor de retorno de movimientos
                    if ($resultadoValue == 1) {
                        $salidasMov += $salida[$i]; // Sumar la salida a la salida actual 
                    }
                } else {
                    return "No hay suficiente stock para realizar la salida.";
                }
            }

            //-------------------------------------------------------------------//
            /*// Imprimir el resultado final de cada producto
            //var_dump($entrada[$i], $salida[$i], $stock_actual[$i]);
            echo "Producto ID: " . $id_producto[$i]."<br>";
            echo "Entro: " . $entrada[$i]."<br>";
            echo "Salio: " . $salida[$i]."<br>"; 
            echo "tiene un stock final de: " . $stock_actual[$i]."<br>";
            echo "Fecha completa: ".$fecha[$i]."<br>";
            echo "<br>";
            die();*/
            //-------------------------------------------------------------------//

                $q3 = "UPDATE productos SET
                        entradas = '$entrada[$i]',
                        salidas = '$salida[$i]',
                        stock_actual = '$stock_actual[$i]',
                        fecha_modificacion = '$fecha[$i]'
                        WHERE id = '$id_producto[$i]'";
                //die($q3);
                $rspta3 = ejecutarConsulta($q3);//Ejecutar consulta
                if ($rspta3) {

                    //-------------------------------------------------------------------//
                    //insertar movimiento de entradas y salidas (para un seguimiento mas detallado)
                        if (!empty($entrada[$i]) && !empty($salida[$i])) {

                            $qD = "INSERT INTO movimientos (entradas, salidas, stock_actual, fecha_entrada, fecha_salida, id_producto) 
                                    VALUES ('$entrada[$i]','$salida[$i]', '$stock_actual[$i]', '$fecha[$i]','$fecha[$i]','$id_producto[$i]')";
                            //die($qD);
                            $rsptaD = ejecutarConsulta($qD); // Ejecutar consulta

                        } elseif (empty($salida[$i]) && !empty($entrada[$i])) {

                            $qD = "INSERT INTO movimientos (entradas, stock_actual, fecha_entrada, id_producto) 
                                    VALUES ('$entrada[$i]','$stock_actual[$i]', '$fecha[$i]','$id_producto[$i]')";
                            //die($qD);
                            $rsptaD = ejecutarConsulta($qD); // Ejecutar consulta

                        } elseif (empty($entrada[$i]) && !empty($salida[$i])) {

                            $qD = "INSERT INTO movimientos (salidas, stock_actual, fecha_salida, id_producto) 
                                    VALUES ('$salida[$i]', '$stock_actual[$i]','$fecha[$i]','$id_producto[$i]')";
                            //die($qD);
                            $rsptaD = ejecutarConsulta($qD); // Ejecutar consulta

                        }
                    //-------------------------------------------------------------------//

                    if ($resultadoValue == 1) {
                        //verificar si hay entradas y salidas
                        if (!empty($entrada[$i]) && !empty($salida[$i])) {

                            //insertar movimiento de entrada y salida
                            $q5 = "INSERT INTO entradasalidaTotal (entradas, salidas, stock_actual, fecha_entrada, fecha_salida, id_producto) 
                                    VALUES ('$entradasMov','$salidasMov', '$stock_actual[$i]', '$fecha[$i]','$fecha[$i]','$id_producto[$i]')";
                            //die($q5);
                            $rspta5 = ejecutarConsulta($q5); // Ejecutar consulta

                        } elseif (empty($salida[$i]) && !empty($entrada[$i])) {

                            // Llamar funcion para obtener la salida actual
                            $salidaActual = obtenerEntradaSalidaActual($id_entradasalidaTotal, $entrada[$i], $salida[$i]);
                            //echo $salidaActual;
                            //die();

                            // Insertar solo movimiento de entrada y la fecha de entrada
                            $q6 = "INSERT INTO entradasalidaTotal (entradas, salidas, stock_actual, fecha_entrada, id_producto) 
                                    VALUES ('$entradasMov','$salidaActual','$stock_actual[$i]', '$fecha[$i]', '$id_producto[$i]')";
                            //die($q6);
                            $rspta6 = ejecutarConsulta($q6); // Ejecutar consulta

                        } elseif (empty($entrada[$i]) && !empty($salida[$i])) {

                            // Llamar funcion para obtener la entrada actual
                            $entradaActual = obtenerEntradaSalidaActual($id_entradasalidaTotal, $entrada[$i], $salida[$i]);
                            //echo $entradaActual;
                            //die();

                            // Insertar solo movimiento de salida y la fecha de salida
                            $q7 = "INSERT INTO entradasalidaTotal (entradas, salidas, stock_actual, fecha_salida, id_producto) 
                                    VALUES ('$entradaActual', '$salidasMov', '$stock_actual[$i]', '$fecha[$i]', '$id_producto[$i]')";
                            //die($q7);
                            $rspta7 = ejecutarConsulta($q7); // Ejecutar consulta
                        }
                    }else{
                        //-------------------------------------------------------------------//
                        //verificar si hay entradas y salidas
                        if (!empty($entrada[$i]) && !empty($salida[$i])) {

                            //insertar movimiento de entradas y salidas e insertar sus fechas
                            $q5 = "INSERT INTO entradasalidaTotal (entradas, salidas, stock_actual, fecha_entrada, fecha_salida, id_producto) 
                                    VALUES ('$entrada[$i]','$salida[$i]', '$stock_actual[$i]', '$fecha[$i]','$fecha[$i]','$id_producto[$i]')";
                            //die($q5);
                            $rspta5 = ejecutarConsulta($q5); // Ejecutar consulta
                        //verificar si hay entradas e insertar su fecha
                        } elseif (empty($salida[$i]) && !empty($entrada[$i])) {

                            // Insertar solo movimiento de entrada y la fecha de entrada
                            $q6 = "INSERT INTO entradasalidaTotal (entradas, stock_actual, fecha_entrada, id_producto) 
                                    VALUES ('$entrada[$i]', '$stock_actual[$i]', '$fecha[$i]', '$id_producto[$i]')";
                            //die($q6);
                            $rspta6 = ejecutarConsulta($q6); // Ejecutar consulta
                        //verificar si hay salidas e insertar su fecha
                        } elseif (empty($entrada[$i]) && !empty($salida[$i])) {

                            // Insertar solo movimiento de salida y la fecha de salida
                            $q7 = "INSERT INTO entradasalidaTotal (salidas, stock_actual, fecha_salida, id_producto) 
                                    VALUES ('$salida[$i]', '$stock_actual[$i]', '$fecha[$i]', '$id_producto[$i]')";
                            //die($q7);
                            $rspta7 = ejecutarConsulta($q7); // Ejecutar consulta
                        }
                        //-------------------------------------------------------------------//
                    }   
                }
            }
            //-------------------------------------------------------------------//
        }//Fin del bucle For
        return "Actualizacion exitosa";
    }

//--------------------------------------------------------------------------------//

    //metodo para listar los registros 
    public function listar(){

        $q = "SELECT p.id, p.producto, p.status, p.fecha_creacion, 
            c.categoria AS nombre_categoria, 
            sc.sub_categoria AS nombre_sub_categoria, p.stock_minimo,
            p.entradas,p.salidas,p.stock_actual,p.tipo_de_unidad
            FROM productos p 
            INNER JOIN categorias c ON p.id_categoria = c.id
            INNER JOIN sub_categorias sc ON p.id_sub_categoria = sc.id
            WHERE p.status = '1'";

       //die($q);
       $rspta = ejecutarConsulta($q);//Ejecutar consulta
       return $rspta; 
    }

//--------------------------------------------------------------------------------//

    //metodo para listar las entradas y salidas (Historial)
    public function listarHistorialEntradasySalidas($fecha_desde,$fecha_hasta,$id_categoria,$id_sub_categoria){

        $q = "SELECT m.id AS id_Movimiento, 
       p.producto AS nombre_producto, 
       c.categoria AS nombre_categoria, 
       sc.sub_categoria AS nombre_sub_categoria, 
       m.entradas AS entradasM, 
       m.salidas AS salidasM, 
       m.fecha_entrada AS fechaEntradaM, 
       m.fecha_salida AS fechaSalidaM 
        FROM movimientos m 
        JOIN productos p ON m.id_producto = p.id 
        JOIN sub_categorias sc ON p.id_sub_categoria = sc.id 
        JOIN categorias c ON p.id_categoria = c.id 
        WHERE 1 = 1 ";

        if (isset($id_categoria) && $id_categoria !== '') {
            $q .= "AND p.id_categoria = '$id_categoria' ";
        }
        if (isset($id_sub_categoria) && $id_sub_categoria !== '') {
            $q .= "AND sc.id = '$id_sub_categoria' ";
        }

        //Verificar que esten en el rango de fechas desde-hasta
        if (!empty($fecha_desde) && !empty($fecha_hasta)) {
            $q .= "AND (
                (m.fecha_entrada BETWEEN '$fecha_desde' AND '$fecha_hasta') OR 
                (m.fecha_salida BETWEEN '$fecha_desde' AND '$fecha_hasta')
                )";
        }

       //die($q);
       $rspta = ejecutarConsulta($q);//Ejecutar consulta
       return $rspta; 
    }

//--------------------------------------------------------------------------------//

    //metodo para listar las entradas y salidas (total)
    public function listarEntradasySalidas($id_categoria,$id_sub_categoria){

        $q = "SELECT m.id AS id_Movimiento, 
       p.producto AS nombre_producto, 
       c.categoria AS nombre_categoria, 
       sc.sub_categoria AS nombre_sub_categoria, 
       m.entradas AS entradasM, 
       m.salidas AS salidasM, 
       m.fecha_entrada AS fechaEntradaM, 
       m.fecha_salida AS fechaSalidaM 
        FROM entradasalidaTotal m 
        JOIN productos p ON m.id_producto = p.id 
        JOIN sub_categorias sc ON p.id_sub_categoria = sc.id 
        JOIN categorias c ON p.id_categoria = c.id 
        WHERE m.id IN (
            SELECT MAX(m2.id)
            FROM entradasalidaTotal m2
            GROUP BY m2.id_producto
        ) ";

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

    //metodo para verificar movimientos en (entradasalidaTotal)
    public function verificarEntradasalidaTotal(){
        $q = "SELECT COUNT(id) AS id FROM entradasalidaTotal";

       //die($q);
       $rspta = ejecutarConsultaSimpleFila($q);//Ejecutar consulta

       $idMovimiento = $rspta['id'];
       if ($idMovimiento > 0) {
            return "existe";
       }else{
            return "Noexiste";
       }
    }

//--------------------------------------------------------------------------------//

}//Fin de la clase
?>