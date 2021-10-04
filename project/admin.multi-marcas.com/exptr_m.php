<?php>
session_start();
error_reporting(0);
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
include('admin/includes/config.php');
$dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
$Meses = array(null,"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $Festivos= "SELECT * FROM feriados";
	$FQ = $dbh->prepare($Festivos);
	$FQ -> execute();
	$Fresults=$FQ->fetchAll(PDO::FETCH_OBJ);
	$FCc=$FQ->rowCount();
	$FCt=1;
	if($FQ->rowCount() > 0)
        {
        foreach($Fresults as $Fresult)
            { 
             
                $Carga[$FCt] = $Fresult->Fecha;
                
                $FCt++;
            }             
            
        }
        
$feriados=0;
$L=0;$Ma=0;$Mi=0;$J=0;$V=0;$S=0;$D=0;
$MesCurso = date('t');

for($i = 1; $i <= $MesCurso; $i++) {
       
        $fech=   $i ."-". date("m")."-". date("Y");
        
        $fechrt= $i ."/". date("m");
        if($i<=9){
        $fechrt= 0 . $i ."/". date("m");
        }
        
        $a=strftime('%d/%m/%Y',strtotime($fech));
        
        $b=$dias[date("w",strtotime($fech))];
        
        if(!in_array($fechrt,$Carga)){
                    $user=$_SESSION['eid'];
        $consulta="SELECT * FROM tblemployees WHERE id=:user";
        $QRYconsulta = $dbh -> prepare($consulta);
        $QRYconsulta->bindParam(':user',$user,PDO::PARAM_STR); 
        $QRYconsulta->execute();
        $resultsC=$QRYconsulta->fetchAll(PDO::FETCH_OBJ);
        if($QRYconsulta->rowCount() > 0){
            foreach($resultsC as $rsC){
                if(date("w",strtotime($fech))==1){if($rsC->LUNES==1){$L++;}}
                if(date("w",strtotime($fech))==2){if($rsC->MARTES==1){$Ma++;}}
                if(date("w",strtotime($fech))==3){if($rsC->MIERCOLES==1){$Mi++;}}
                if(date("w",strtotime($fech))==4){if($rsC->JUEVES==1){$J++;}}
                if(date("w",strtotime($fech))==5){if($rsC->VIERNES==1){$V++;}}
                if(date("w",strtotime($fech))==6){if($rsC->SABADO==1){$S++;}}
                if(date("w",strtotime($fech))==0){if($rsC->DOMINGO==1){$D++;}}
            }
        }
}
        if(in_array($fechrt,$Carga))
            {$feriados++;
            }
            
}

$c=$L+$Ma+$Mi+$J+$V+$S+$D;


if(strlen($_SESSION['emplogin'])==0)
    {   
header("location:index");
}
else{
include('admin/includes/config.php');

    $eid=intval($_GET['exp']);

	require 'admin/Classes/PHPExcel.php';
	
	$sql = "SELECT *  FROM tblogin WHERE empid=:eid AND Mes=:mes ORDER by Entrada DESC";
	$query = $dbh->prepare($sql);
	$query -> bindParam(':eid',$eid, PDO::PARAM_STR);
	$query -> bindParam(':mes', date("n"), PDO::PARAM_STR);
	$query -> execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$cnt=6;
	
	$objPHPExcel  = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("Multi Marcas")->setDescription("Reporte de horas");
	
	/*Estilo*/
	$estiloTituloReporte = array(
    'font' => array(
	'name'      => 'Arial',
	'bold'      => true,
	'italic'    => false,
	'strike'    => false,
	'size' =>13
    ),
    'fill' => array(
	'type'  => PHPExcel_Style_Fill::FILL_SOLID
	),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_NONE
	)
    ),
    'alignment' => array(
	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);
	
	
	$estiloTituloColumnas = array(
    'font' => array(
	'name'  => 'Arial',
	'bold'  => true,
	'size' =>10,
	'color' => array(
	'rgb' => 'FFFFFF'
	)
    ),
    'fill' => array(
	'type' => PHPExcel_Style_Fill::FILL_SOLID,
	'color' => array('rgb' => '000000')
    ),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
    ),
    'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);

	$estiloTimeFalse = array(
    'font' => array(
	'name'  => 'Arial',
	'bold'  => true,
	'size' =>10,
	'color' => array(
	'rgb' => 'FFFFFF'
	)
    ),
    'fill' => array(
	'type' => PHPExcel_Style_Fill::FILL_SOLID,
	'color' => array('rgb' => 'de121c')
    ),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
    ),
    'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);
	
	$estiloTimeTrue = array(
    'font' => array(
	'name'  => 'Arial',
	'bold'  => true,
	'size' =>10,
	'color' => array(
	'rgb' => 'FFFFFF'
	)
    ),
    'fill' => array(
	'type' => PHPExcel_Style_Fill::FILL_SOLID,
	'color' => array('rgb' => '057504')
    ),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
    ),
    'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);

	$estiloTimeNTH = array(
    'font' => array(
	'name'  => 'Arial',
	'bold'  => true,
	'size' =>10,
	'color' => array(
	'rgb' => 'FFFFFF'
	)
    ),
    'fill' => array(
	'type' => PHPExcel_Style_Fill::FILL_SOLID,
	'color' => array('rgb' => 'ff8400')
    ),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
    ),
    'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);	
	
	$estiloInformacion = new PHPExcel_Style();
	$estiloInformacion->applyFromArray( array(
    'font' => array(
	'name'  => 'Arial',
	'color' => array(
	'rgb' => '000000'
	)
    ),
    'fill' => array(
	'type'  => PHPExcel_Style_Fill::FILL_SOLID
	),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
    ),
	'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	));
	
	/*Aplicaciones*/
	$objPHPExcel->getActiveSheet()->getStyle('A1:G4')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->applyFromArray($estiloTituloColumnas);
	$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($estiloTimeFalse);
	$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($estiloTimeTrue);
	$objPHPExcel->getActiveSheet()->setAutoFilter("A5:E5");
	
	/*Tamaños*/
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(45);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
    
	
	/*Fin Formatos*/
	

	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("Horas");
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Nombre:');
    $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Telefono:');
    $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Codigo:');
	
	$objPHPExcel->getActiveSheet()->setCellValue('A5', 'Semana');
	$objPHPExcel->getActiveSheet()->setCellValue('B5', 'Movimiento');
	$objPHPExcel->getActiveSheet()->setCellValue('C5', 'Fecha');
	$objPHPExcel->getActiveSheet()->setCellValue('D5', 'Dia');
	$objPHPExcel->getActiveSheet()->setCellValue('F5', 'Hora');
	$objPHPExcel->getActiveSheet()->setCellValue('G5', 'Descripcion');
	
	
	$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Dias Laborables de ' . $Meses[date("m")] . ": " . $c ." / ".$MesCurso);
	$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Semana en curso: ' . date("W"));
	$objPHPExcel->getActiveSheet()->setCellValue('E5', 'Alertas');
	$retardos=0;
	$dL=0;
	$PEm=0;
    $PSm=0;
if($query->rowCount() > 0)
{
foreach($results as $result)
{       
    $objPHPExcel->getActiveSheet() ->getStyle('F') ->getNumberFormat() ->setFormatCode("[h]:mm:ss");
	
 		$objPHPExcel->getActiveSheet()->setCellValue('G'.$cnt, $result->Description);
 		$objPHPExcel->getActiveSheet()->setCellValue('B'.$cnt, $result->reg_type);
 		$objPHPExcel->getActiveSheet()->setCellValue('C'.$cnt, $result->DIA_NUMERO);
 		$objPHPExcel->getActiveSheet()->setCellValue('D'.$cnt, $dias[$result->DIA_LETRA]);
 		$objPHPExcel->getActiveSheet()->setCellValue('F'.$cnt, $result->HORA);
 		
 		    $fechx= $result->DIA_NUMERO;
            $fdia=substr($fechx,0,2);
            $fmes=substr($fechx,3,2);
            $fanio=substr($fechx,6);
            $semana = date('W',  mktime(0,0,0,$fmes,$fdia,$fanio));
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$cnt, $semana);    
 		
 		if($result->valor==1){ $objPHPExcel->getActiveSheet()->setCellValue('E'.$cnt, 'RETARDO'); 
 		                       $objPHPExcel->getActiveSheet()->getStyle('E'.$cnt)->applyFromArray($estiloTimeFalse);
 		                       $retardos++;
 		                       $PEm=$PEm+1;
 		                       $dL++;
 		}
 		                       
        if($result->valor==0){$objPHPExcel->getActiveSheet()->setCellValue('E'.$cnt, 'Ok');
            $objPHPExcel->getActiveSheet()->getStyle('E'.$cnt)->applyFromArray($estiloTimeTrue);
            $PEm=$PEm+2;
            $dL++;
        }
             
        if($result->valor==9){ $objPHPExcel->getActiveSheet()->setCellValue('E'.$cnt, 'No_Autorizado'); 
 		                       $objPHPExcel->getActiveSheet()->getStyle('E'.$cnt)->applyFromArray($estiloTimeNTH);
 		                       }
 		                       
 		if($result->valor==2){ $PSm=$PSm+2;
 		                       }
 		
 		
 	
 		
 				$cnt++;

} }	
        $PTm=$PEm+$PSm;
        $PTm=$PTm/4;

	$sql = "SELECT * FROM tblemployees WHERE id=:eid";
	$query = $dbh->prepare($sql);
	$query -> bindParam(':eid',$eid, PDO::PARAM_STR);
	$query -> execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$cnt2=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{
 		$objPHPExcel->getActiveSheet()->setCellValue('C1', $result->FirstName);
 		$objPHPExcel->getActiveSheet()->setCellValue('D1', $result->LastName);
 		$objPHPExcel->getActiveSheet()->setCellValue('C2', $result->Phonenumber);
 		$objPHPExcel->getActiveSheet()->setCellValue('C3', $result->EmpId);
 		$objPHPExcel->getActiveSheet()->setCellValue('D2', $result->Department);
		$cnt2++;
		
	/*Imagen*/
	$gdImage = imagecreatefrompng("admin/upload/Fotos/$result->foto");
	$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
	$objDrawing->setName('Empleado');
	$objDrawing->setDescription('Empleado');
	$objDrawing->setImageResource($gdImage);
	$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
	$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
	$objDrawing->setHeight(90);
	$objDrawing->setCoordinates('A1');
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	

} }
    $objPHPExcel->getActiveSheet()->setCellValue('D3', "Retardos:  $retardos");
    $objPHPExcel->getActiveSheet()->setCellValue('E3', "Dias laborados:  $dL");
    $pctg=$PTm/$c;
    $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Porcentage de cumplimiento:');
    $objPHPExcel->getActiveSheet()->setCellValue('F4', "$pctg");
    $objPHPExcel->getActiveSheet()->getStyle('F4')->getNumberFormat()->applyFromArray(["code" => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE]);
    

	$name=$result->FirstName;
	$clve=$result->EmpId;
	$month=$Meses[date("m")];
	$y=date("Y");
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header("Content-Disposition: attachment;filename= $clve:$month:$y:$name.xlsx");
	header('Cache-Control: max-age=0');
	
	
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	
	$objWriter->save('php://output');}
?>