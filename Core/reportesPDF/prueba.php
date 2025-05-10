<?php
//$id_civil='';

//if (isset($_POST["id_civil"])) {

    require('fpdf/fpdf.php');
    require("../config/Conexion.php");
    date_default_timezone_set('America/Caracas');

    // Establecemos la conexión a la base de datos
    $conn = $conexion;

//-------------------------------------------------------------------//

    //Consulta
    $q1 = "SELECT id,descripcion,razon,domicilio,fecha_creacion,ciudad,estado,telefono,
    fax,web_site,alcalde,personal,concejales,cpostal,status 
    FROM puser_alcaldia 
    WHERE status = '1'";

    // Verificamos si hubo algún error de conexión
    if (mysqli_connect_errno()) {
    }

    // Ejecutamos la consulta SQL usando la conexión '$link'
    if ($result1 = mysqli_query($conn,$q1)) {

        // Si la consulta fue exitosa, recorremos los resultados
        while ($obj = mysqli_fetch_object($result1)) {
            // Asignamos los valores de la fila actual del resultado a variables PHP
            $id=$obj->id;
            $descripcion=$obj->descripcion;
            $razon=$obj->razon;
            $domicilio=$obj->domicilio;
            $fecha_creacion=$obj->fecha_creacion;
            $ciudad=$obj->ciudad;
            $estado=$obj->estado;
            $telefono=$obj->telefono;
            $fax=$obj->fax;
            $web_site=$obj->web_site;
            $alcalde=$obj->alcalde;
            $personal=$obj->personal;
            $concejales=$obj->concejales;
            $cpostal=$obj->cpostal;
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
            $this->Image ("img/logo1.jpg",5,-2,55);//logo superior izquierdo
            $this->Image ("img/logo2.jpg",5,148,200);//logo central inferior
            $this->SetXY(10, 10); 
            $this->Ln(15);
        }

        function Footer()
        {
         $this->SetFont('helvetica', 'B', 8);
         $this->SetY(267);
         $this->Cell(95,5,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'L');
         $this->Cell(95,5,date('d/m/Y | g:i:a') ,00,1,'R');
         $this->line(10,287,200,287);
         $this->Cell(0,0,utf8_decode("Alcaldia de Libertador Estado Carabobo © Todos los derechos reservados."),0,0,"C");
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

    $pdf->Ln();//salto de linea
    $pdf->Ln();//salto de linea
    $pdf->SetFillColor(0,0,0);//color de la celda
    $pdf->SetTextColor(0,0,0);//color del texto

    //-------------------------------------------------------------------//

    $ano = date('Y') + 1;

    $pdf->SetFont('Arial','',8);
    $pdf->SetAligns(array('L'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(
        utf8_decode('ENTIDAD FEDERAL: ESTADO CARABOBO')."\n".
        utf8_decode('MUNICIPIO: LIBERTADOR')."\n".
        utf8_decode('PRESUPUESTO AÑO: '.$ano.'')
    ));

    $pdf->SetFont('Arial','B',8);
    $pdf->SetAligns(array('C'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(
        utf8_decode('INFORMACIÓN GENERAL DEL MUNICIPIO')
    ));
    //-------------------------------------------------------------------//

    $pdf->SetFont('Arial','',8);
    $pdf->SetAligns(array('L'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(utf8_decode('BASE LEGAL: Gaceta oficial del Estado Carabobo, Número Extraordinario 616 Resolución No 003, de Fecha 14 de Enero de 1994')
    )); 

    $pdf->SetAligns(array('L'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(
        utf8_decode('IDENTIFICACIÓN DE LOS ÓRGANOS DEL PODER PÚBLICO MUNICIPAL:')
    )); 

    $pdf->SetAligns(array('L'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(
        utf8_decode($descripcion)
    ));

    $pdf->SetAligns(array('L'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(
        utf8_decode('DOMICILIO LEGAL DE LA ALCALDIA: '.$domicilio)
    )); 
    
    //-------------------------------------------------------------------//

    $pdf->SetFont('Arial','B',8);
    $pdf->SetAligns(array('C','C','C','C'));
    $pdf->SetWidths(array(49,49,49,49));
    $pdf->Row(array(
        utf8_decode('TELEFONOS'),
        utf8_decode('PAGINA WEB'),
        utf8_decode('FAX(S)'),
        utf8_decode('CODIGO POSTAL')
    ));

    $pdf->SetFont('Arial','',8);
    $pdf->SetAligns(array('C','C','C','C'));
    $pdf->SetWidths(array(49,49,49,49));
    $pdf->Row(array(
        utf8_decode($telefono),
        utf8_decode($web_site),
        utf8_decode($fax),
        utf8_decode($cpostal)
    ));

    //-------------------------------------------------------------------//

    $pdf->SetFont('Arial','B',8);
    $pdf->SetAligns(array('L'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(utf8_decode('NOMBRES Y APELLIDOS DEL ALCALDE (SA)')));

    $pdf->SetFont('Arial','B',8);
    $pdf->SetAligns(array('C'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(utf8_decode($alcalde)));

    $pdf->SetFont('Arial','B',8);
    $pdf->SetAligns(array('L'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(utf8_decode('PERSONAL DIRECTIVO DE LA ALCALDIA Y ORGANOS AUXILIARES')));

    //-------------------------------------------------------------------//

    $pdf->SetFont('Arial','B',8);
    $pdf->SetAligns(array('C','C','C','C'));
    $pdf->SetWidths(array(49,49,49,49));
    $pdf->Row(array(
        utf8_decode('DIRECCIÓN ADMINISTRATIVA'),
        utf8_decode('NOMBRES Y APELLIDOS'),
        utf8_decode('CORREO ELECTRONICO'),
        utf8_decode('TELEFONO(S)')
    ));

/*
### Explicación del codigo ###
1. Explode por línea: Usamos explode para dividir el texto plano en un array de líneas usando el separador ;.
2. Bucle foreach: Recorremos cada línea y la limpiamos de espacios en blanco.
3. Dividir las partes: Para cada línea no vacía, dividimos por comas y almacenamos los resultados en los arrays correspondientes.
4. Instanciar PDF: Usamos implode para unir los elementos de cada array con saltos de línea (\n) y los pasamos al método Row().
*/

// Separar el texto de $personal en líneas
$lineas = explode(";", $personal);

// Inicializar arrays para los datos requeridos
$departamentos = [];
$nombres = [];
$correos = [];
$telefonos = [];

// Recorrer cada linea y preparar los datos
foreach ($lineas as $linea) {
    $linea = trim($linea); // Eliminar espacios en blanco al inicio y al final
    if (!empty($linea)) { // Asegurarse de que la línea no esté vacía
        // Dividir la línea por comas
        $parts = explode(",", $linea);
        
        // Completar los arrays según la parte encontrada
        $departamentos[] = isset($parts[0]) ? trim($parts[0]) : '';
        $nombres[] = isset($parts[1]) ? trim($parts[1]) : '';
        $correos[] = isset($parts[2]) ? trim($parts[2]) : '';
        $telefonos[] = isset($parts[3]) ? trim($parts[3]) : '';
    }
}

// Construir el PDF con los datos preparados
$pdf->SetFont('Arial', '', 8);
$pdf->SetAligns(array('C', 'C', 'C', 'C'));
$pdf->SetWidths(array(49, 49, 49, 49));

$pdf->Row(array(
    utf8_decode(implode("\n", $departamentos)),
    utf8_decode(implode("\n", $nombres)),
    utf8_decode(implode("\n", $correos)),
    utf8_decode(implode("\n", $telefonos))
));

    //-------------------------------------------------------------------//

    $pdf->SetFont('Arial','B',8);
    $pdf->SetAligns(array('L'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(utf8_decode('CONTRALORÍA MUNICIPAL')
    ));

    $pdf->SetFont('Arial','',8);
    $pdf->SetAligns(array('L'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(utf8_decode('NOMBRES Y APELLIDOS DEL CONTRALOR (A)')
    )); 

    $pdf->SetFont('Arial','B',8);
    $pdf->SetAligns(array('C'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(utf8_decode('JULIO CESAR CENTENO RAMIREZ')
    )); 

    $pdf->SetFont('Arial','B',8);
    $pdf->SetAligns(array('L'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(utf8_decode('DOMICILIO LEGAL:')
    )); 

    $pdf->SetFont('Arial','',8);
    $pdf->SetAligns(array('C'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(utf8_decode('Av. La Luz Casa Ejido 23, Piso PB Frente de Agropeciaria El Garabato. Sector Pocaterra, Municipio Libertador Estado Carabobo')
    ));  

    //-------------------------------------------------------------------//

    $pdf->SetFont('Arial','B',8);
    $pdf->SetAligns(array('C','C','C'));
    $pdf->SetWidths(array(98,49,49));
    $pdf->Row(array(
        utf8_decode('TELEFONO(S)'),
        utf8_decode('PAGINA WEB'),
        utf8_decode('FAX(S)'),
    ));

    $pdf->SetFont('Arial','',8);
    $pdf->SetAligns(array('C','C','C'));
    $pdf->SetWidths(array(98,49,49));
    $pdf->Row(array(
        utf8_decode('0241 - 8940483'),
        utf8_decode('www.cmeclibertador.gob.ve'),
        utf8_decode('0241 - 8940483'),
    ));

    //-------------------------------------------------------------------//

    $pdf->SetFont('Arial','B',8);
    $pdf->SetAligns(array('L'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(utf8_decode('CONCEJO MUNICIPAL O CABILDO:')
    ));

    $pdf->SetFont('Arial','',8);
    $pdf->SetAligns(array('L'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(utf8_decode('NOMBRES Y APELLIDOS DEL PRESIDENTE (A): Iris Leydi Colmenares Gil')
    ));

    $pdf->SetFont('Arial','',8);
    $pdf->SetAligns(array('L'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(utf8_decode('NOMBRES Y APELLIDOS DEL SECRETARIO (A): Ana Angélica Escalona Herrera')
    ));

    $pdf->SetFont('Arial','B',8);
    $pdf->SetAligns(array('L'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(utf8_decode('DOMICILIO LEGAL:')
    ));

    $pdf->SetFont('Arial','',8);
    $pdf->SetAligns(array('C'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(utf8_decode('Calle Sucre Entre Avenida Bolivar y Farriar, Frente a la Plaza La Victoria, Edificio Alcaldia, Ofic. 4-1')
    ));

    //-------------------------------------------------------------------//

    $pdf->SetFont('Arial','B',8);
    $pdf->SetAligns(array('C','C','C'));
    $pdf->SetWidths(array(98,49,49));
    $pdf->Row(array(
        utf8_decode('TELEFONO(S) Y FAX(S)'),
        utf8_decode('PAGINA WEB'),
        utf8_decode('CORREO ELECTRÓNICO'),
    ));

    $pdf->SetFont('Arial','',8);
    $pdf->SetAligns(array('C','C','C'));
    $pdf->SetWidths(array(98,49,49));
    $pdf->Row(array(
        utf8_decode('0241 - 9951625'),
        utf8_decode('NO POSEE'),
        utf8_decode('NO POSEE'),
    ));

    //-------------------------------------------------------------------//

    $pdf->SetFont('Arial','B',8);
    $pdf->SetAligns(array('L'));
    $pdf->SetWidths(array(196));
    $pdf->Row(array(utf8_decode('CONSEJO LOCAL DE PLANIFICACIÓN PÚBLICA:')
    ));


    $pdf->SetFont('Arial','',8);
    $pdf->SetAligns(array('C','C','C'));
    $pdf->SetWidths(array(98,49,49));
    $pdf->Row(array(
        utf8_decode('NOMBRES Y APELLIDOS DE LOS CONSEJEROS (AS) :')
            ."\n".utf8_decode('Maria Olga Castillo')
            ."\n".utf8_decode('Bruno Salazar')
            ."\n".utf8_decode('Mirna Sevilla')
            ."\n".utf8_decode('Pablo Carrillo')
            ."\n".utf8_decode('Orlando Leon')
            ."\n".utf8_decode('Jose Miguel Sanchez')
            ."\n".utf8_decode('Manuel Fontalbo')
            ."\n".utf8_decode('Alejo Acosta')
            ."\n".utf8_decode('Maria Gutierrez')
            ."\n".utf8_decode('Magalis Navas')
            ."\n".utf8_decode('Glenda Ygarza'),
        utf8_decode(''),
        utf8_decode(''),
    ));

    $pdf->SetFont('Arial','B',6);
    $pdf->Cell(100.5, 4, 'F2100',0, '', 'L');

    //-------------------------------------------------------------------//

    $pdf->Output('I');//mostrar directamente el pdf en el navegador del usuario

//}else{
  //header("Location: ../index.php");
//}
?>