<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

//Verificar si el usuario ha iniciado sesion 
if (!isset($_SESSION['_AL_id'])) { 
    header('Location: ../vistas/login.php?Acceso_No_Permitido');
    exit;
}else{

    require('fpdf/fpdf.php');
    require("../config/Conexion.php");
    date_default_timezone_set('America/Caracas');

    // Establecemos la conexión a la base de datos
    $conn = $conexion;

//-------------------------------------------------------------------//

    //Consulta
    $q1 = "SELECT p.id, p.producto, p.status, p.fecha_creacion, 
            c.categoria AS nombre_categoria, 
            sc.sub_categoria AS nombre_sub_categoria, p.stock_minimo,
            p.entradas,p.salidas,p.stock_actual,p.tipo_de_unidad
            FROM productos p 
            INNER JOIN categorias c ON p.id_categoria = c.id
            INNER JOIN sub_categorias sc ON p.id_sub_categoria = sc.id
            WHERE p.status = '1'";

    //die($q1);

    // Verificamos si hubo algún error de conexión
    if (mysqli_connect_errno()) {
    }

    // Inicializamos un array para almacenar los resultados1
    $resultados1 = [];

    // Ejecutamos la consulta SQL usando la conexión '$conn'
    if ($result1 = mysqli_query($conn, $q1)) {
        // Si la consulta fue exitosa, recorremos los resultados1
        while ($obj = mysqli_fetch_object($result1)) {
            $resultados1[] = $obj; // Agregamos el objeto al array
        }
        // Liberamos la memoria ocupada por el resultado
        mysqli_free_result($result1);
    }
//-------------------------------------------------------------------//
    //-------------Global header y footer FPDF-------------//
    class PDF extends FPDF
    {
        function Header()
        {
            $this->SetLeftMargin(10);
            $this->SetFont('Courier','',6);
            $this->Image ("../public/images/logo.png",10,-2,30);//logo superior izquierdo
            //$this->Image ("img/logo2.jpg",5,148,200);//logo central inferior
            $this->SetXY(10, 10); 
            $this->Ln(15);


            $this->SetFont('Arial','B',8);
            $this->SetAligns(array('C'));
            $this->SetWidths(array(196));
            $this->Row(array(
                utf8_decode('Listado de productos')
            ));

            //-------------------------------------------------------------------//

            $this->SetFont('Arial','B',8);
            $this->SetAligns(array('C','C','C','C','C','C'));
            $this->SetWidths(array(32.66,32.66,32.66,32.66,32.66,32.66));
            $this->Row(array(
                utf8_decode('Categoria'),
                utf8_decode('Sub Categoria'),
                utf8_decode('Descripcion'),
                utf8_decode('Tipo de unidad'),
                utf8_decode('Stock Actual'),
                utf8_decode('Fecha')
            ));
        }

        function Footer()
        {
         /*$this->SetFont('helvetica', 'B', 8);
         $this->SetY(267);
         $this->Cell(95,5,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'L');
         $this->Cell(95,5,date('d/m/Y | g:i:a') ,00,1,'R');
         $this->line(10,287,200,287);
         $this->Cell(0,0,utf8_decode("Gestor de inventario Tags Publicidad"),0,0,"C");*/
        }
    }

//-------------------------------------------------------------------//
    //-------------Cuerpo del FPDF-------------//
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','letter');
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->SetTopMargin(20);
    $pdf->SetLeftMargin(10);
    $pdf->SetRightMargin(10);

    //-----------------------------------------//


    //-------------------------------------------------------------------//

    foreach ($resultados1 as $obj) {
    //------------------------------------------//
    $id=$obj->id;
    $producto=$obj->producto;
    $status=$obj->status;
    $fecha_creacion=$obj->fecha_creacion;
    $nombre_categoria=$obj->nombre_categoria;
    $nombre_sub_categoria=$obj->nombre_sub_categoria;
    $stock_minimo=$obj->stock_minimo;
    $entradas=$obj->entradas;
    $salidas=$obj->salidas;
    $stock_actual=$obj->stock_actual;
    $tipo_de_unidad=$obj->tipo_de_unidad;
    //------------------------------------------//

    $FechaHoy = date('d-m-Y');

    $pdf->SetFont('Arial','',8);
    $pdf->SetAligns(array('C','C','C','C','C','C'));
    $pdf->SetWidths(array(32.66,32.66,32.66,32.66,32.66,32.66));
    $pdf->Row(array(
        utf8_decode($nombre_categoria),
        utf8_decode($nombre_sub_categoria),
        utf8_decode($producto),
        utf8_decode($tipo_de_unidad),
        utf8_decode($stock_actual),
        utf8_decode($FechaHoy)
    ));

    }

    //-------------------------------------------------------------------//

    //$pdf->SetFont('Arial','B',6);
    //$pdf->Cell(100.5, 4, 'F2100',0, '', 'L');

    //-------------------------------------------------------------------//

    $pdf->Output('reporteGlobal.pdf','I');//mostrar directamente el pdf en el navegador del usuario



}//Fin del else
ob_end_flush();
?>