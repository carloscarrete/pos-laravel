<?php>
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header("location:index");
}
else{
include('includes/config.php');
$eid=intval($_GET['ex']);

	require 'Classes/PHPExcel.php';
	
	$sql = "SELECT Entrada, Description, reg_type, valor  FROM tblogin WHERE empid=:eid ORDER by Entrada DESC";
	$query = $dbh->prepare($sql);
	$query -> bindParam(':eid',$eid, PDO::PARAM_STR);
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
	$objPHPExcel->getActiveSheet()->getStyle('A1:E4')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle('A5:E5')->applyFromArray($estiloTituloColumnas);
	$objPHPExcel->getActiveSheet()->setAutoFilter("B5:E5");
	
	/*Tamaños*/
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	$objPHPExcel->getActiveSheet() ->getStyle('D2') ->getNumberFormat() ->setFormatCode("[h]:mm:ss");
	
	/*Fin Formatos*/
	

	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("Horas");
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Nombre:');
    $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Telefono:');
    $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Codigo:');
	
	$objPHPExcel->getActiveSheet()->setCellValue('B5', 'Hora');
	$objPHPExcel->getActiveSheet()->setCellValue('C5', 'Descripcion');
	$objPHPExcel->getActiveSheet()->setCellValue('D5', 'Movimiento');
	$objPHPExcel->getActiveSheet()->setCellValue('E5', 'Alertas');
	
if($query->rowCount() > 0)
{
foreach($results as $result)
{       
    $objPHPExcel->getActiveSheet() ->getStyle('F') ->getNumberFormat() ->setFormatCode("[h]:mm:ss");

 		$objPHPExcel->getActiveSheet()->setCellValue('B'.$cnt, $result->Entrada);
 		$objPHPExcel->getActiveSheet()->setCellValue('C'.$cnt, $result->Description);
 		$objPHPExcel->getActiveSheet()->setCellValue('D'.$cnt, $result->reg_type);
 		
 		if($result->valor==1){ $objPHPExcel->getActiveSheet()->setCellValue('E'.$cnt, 'RETARDO'); 
 		                       $objPHPExcel->getActiveSheet()->getStyle('E'.$cnt)->applyFromArray($estiloTimeFalse);
 		                       }
 		                       
        if($result->valor==0){$objPHPExcel->getActiveSheet()->setCellValue('E'.$cnt, 'Ok');
             $objPHPExcel->getActiveSheet()->getStyle('E'.$cnt)->applyFromArray($estiloTimeTrue);}
             
        if($result->valor==9){ $objPHPExcel->getActiveSheet()->setCellValue('E'.$cnt, 'No_Autorizado'); 
 		                       $objPHPExcel->getActiveSheet()->getStyle('E'.$cnt)->applyFromArray($estiloTimeNTH);
 		                       }
 		
 		
 	
 		
 				$cnt++;

} }	


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
 		$objPHPExcel->getActiveSheet()->setCellValue('D3', $result->Department);
		$cnt2++;
		
	/*Imagen*/
	$gdImage = imagecreatefrompng("upload/Fotos/$result->foto");
	$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
	$objDrawing->setName('Empleado');
	$objDrawing->setDescription('Empleado');
	$objDrawing->setImageResource($gdImage);
	$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
	$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
	$objDrawing->setHeight(100);
	$objDrawing->setCoordinates('A1');
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	

} }


	$name=$result->FirstName;
	$clve=$result->EmpId;
	
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header("Content-Disposition: attachment;filename=$clve:Reporte:$name.xlsx");
	header('Cache-Control: max-age=0');
	
	
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	
	$objWriter->save('php://output');}
?>