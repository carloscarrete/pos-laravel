<?php>
session_start();
error_reporting(0);
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
include('includes/config.php');
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
        
$dia_cmp=date("w");
$hoy = date('d-m-Y');
if($dia_cmp==0){//Domingo
    $Lu = strtotime ( '-6 day' , strtotime ( $hoy ) );$Lu= date ( 'd/m' , $Lu );
    $Ma = strtotime ( '-5 day' , strtotime ( $hoy ) ); $Ma= date ( 'd/m' , $Ma );
    $Mi = strtotime ( '-4 day' , strtotime ( $hoy ) ); $Mi= date ( 'd/m' , $Mi );
    $Ju = strtotime ( '-3 day' , strtotime ( $hoy ) ); $Ju= date ( 'd/m' , $Ju );
    $Vi = strtotime ( '-2 day' , strtotime ( $hoy ) ); $Ju= date ( 'd/m' , $Ju );
    $Sa = strtotime ( '-1 day' , strtotime ( $hoy ) ); $Sa= date ( 'd/m' , $Sa );
    $Do= date ( 'd/m');
}
if($dia_cmp==1){//Lunes
    $Lu= date ( 'd/m');
    $Ma = strtotime ( '+1 day' , strtotime ( $hoy ) ); $Ma= date ( 'd/m' , $Ma );
    $Mi = strtotime ( '+2 day' , strtotime ( $hoy ) ); $Mi= date ( 'd/m' , $Mi );
    $Ju = strtotime ( '+3 day' , strtotime ( $hoy ) ); $Ju= date ( 'd/m' , $Ju );
    $Vi = strtotime ( '+4 day' , strtotime ( $hoy ) ); $Ju= date ( 'd/m' , $Ju );
    $Sa = strtotime ( '+5 day' , strtotime ( $hoy ) ); $Sa= date ( 'd/m' , $Sa );
    $Do = strtotime ( '+6 day' , strtotime ( $hoy ) ); $Do= date ( 'd/m' , $Do );
}
if($dia_cmp==2){//Martes
    $Lu = strtotime ( '-1 day' , strtotime ( $hoy ) );$Lu= date ( 'd/m' , $Lu );
    $Ma= date ( 'd/m');
    $Mi = strtotime ( '+1 day' , strtotime ( $hoy ) ); $Mi= date ( 'd/m' , $Mi );
    $Ju = strtotime ( '+2 day' , strtotime ( $hoy ) ); $Ju= date ( 'd/m' , $Ju );
    $Vi = strtotime ( '+3 day' , strtotime ( $hoy ) ); $Ju= date ( 'd/m' , $Ju );
    $Sa = strtotime ( '+4 day' , strtotime ( $hoy ) ); $Sa= date ( 'd/m' , $Sa );
    $Do = strtotime ( '+5 day' , strtotime ( $hoy ) ); $Do= date ( 'd/m' , $Do );
}
if($dia_cmp==3){//Miercoles
    $Lu = strtotime ( '-2 day' , strtotime ( $hoy ) );$Lu= date ( 'd/m' , $Lu );
    $Ma = strtotime ( '-1 day' , strtotime ( $hoy ) ); $Ma= date ( 'd/m' , $Ma );
    $Mi= date ( 'd/m');
    $Ju = strtotime ( '+1 day' , strtotime ( $hoy ) ); $Ju= date ( 'd/m' , $Ju );
    $Vi = strtotime ( '+2 day' , strtotime ( $hoy ) ); $Ju= date ( 'd/m' , $Ju );
    $Sa = strtotime ( '+3 day' , strtotime ( $hoy ) ); $Sa= date ( 'd/m' , $Sa );
    $Do = strtotime ( '+4 day' , strtotime ( $hoy ) ); $Do= date ( 'd/m' , $Do );
}
if($dia_cmp==4){//Jueves
    $Lu = strtotime ( '-3 day' , strtotime ( $hoy ) );$Lu= date ( 'd/m' , $Lu );
    $Ma = strtotime ( '-2 day' , strtotime ( $hoy ) ); $Ma= date ( 'd/m' , $Ma );
    $Mi = strtotime ( '-1 day' , strtotime ( $hoy ) ); $Mi= date ( 'd/m' , $Mi );
    $Ju= date ( 'd/m');
    $Vi = strtotime ( '+1 day' , strtotime ( $hoy ) ); $Ju= date ( 'd/m' , $Ju );
    $Sa = strtotime ( '+2 day' , strtotime ( $hoy ) ); $Sa= date ( 'd/m' , $Sa );
    $Do = strtotime ( '+3 day' , strtotime ( $hoy ) ); $Do= date ( 'd/m' , $Do );
}
if($dia_cmp==5){//Viernes
    $Lu = strtotime ( '-4 day' , strtotime ( $hoy ) );$Lu= date ( 'd/m' , $Lu );
    $Ma = strtotime ( '-3 day' , strtotime ( $hoy ) ); $Ma= date ( 'd/m' , $Ma );
    $Mi = strtotime ( '-2 day' , strtotime ( $hoy ) ); $Mi= date ( 'd/m' , $Mi );
    $Ju = strtotime ( '-1 day' , strtotime ( $hoy ) ); $Ju= date ( 'd/m' , $Ju );
    $Vi= date ( 'd/m');
    $Sa = strtotime ( '+1 day' , strtotime ( $hoy ) ); $Sa= date ( 'd/m' , $Sa );
    $Do = strtotime ( '+2 day' , strtotime ( $hoy ) ); $Do= date ( 'd/m' , $Do );
}
if($dia_cmp==6){//Sabado
    $Lu = strtotime ( '-5 day' , strtotime ( $hoy ) );$Lu= date ( 'd/m' , $Lu );
    $Ma = strtotime ( '-4 day' , strtotime ( $hoy ) ); $Ma= date ( 'd/m' , $Ma );
    $Mi = strtotime ( '-3 day' , strtotime ( $hoy ) ); $Mi= date ( 'd/m' , $Mi );
    $Ju = strtotime ( '-2 day' , strtotime ( $hoy ) ); $Ju= date ( 'd/m' , $Ju );
    $Vi = strtotime ( '-1 day' , strtotime ( $hoy ) ); $Ju= date ( 'd/m' , $Ju );
    $Sa= date ( 'd/m');
    $Do = strtotime ( '+1 day' , strtotime ( $hoy ) ); $Do= date ( 'd/m' , $Do );
}

$lab=0;
$sem_arr= array(null,$Lu,$Ma,$Mi,$Ju,$Vi,$Sa);
for($z = 0; $z <= 6; $z++) {
    
    if(!in_array($sem_arr[$z],$Carga))
            {
                $user=intval($_GET['ex']);
                $consulta="SELECT * FROM tblemployees WHERE id=:user";
                $QRYconsulta = $dbh -> prepare($consulta);
                $QRYconsulta->bindParam(':user',$user,PDO::PARAM_STR); 
                $QRYconsulta->execute();
                $resultsC=$QRYconsulta->fetchAll(PDO::FETCH_OBJ);
                if($QRYconsulta->rowCount() > 0){
                    foreach($resultsC as $rsC){
                        if($z==0){if($rsC->DOMINGO==1){$lab++;}}
                        if($z==1){if($rsC->LUNES==1){$lab++;}}
                        if($z==2){if($rsC->MARTES==1){$lab++;}}
                        if($z==3){if($rsC->MIERCOLES==1){$lab++;}}
                        if($z==4){if($rsC->JUEVES==1){$lab++;}}
                        if($z==5){if($rsC->VIERNES==1){$lab++;}}
                        if($z==6){if($rsC->SABADO==1){$lab++;}}
                   } 
                }
            }
    
}



if(strlen($_SESSION['alogin'])==0)
    {   
header("location:index");
}
else{
include('includes/config.php');
$eid=intval($_GET['ex']);

$xdL=0;
for($pDay = 0; $pDay <= 6; $pDay++) {
$origin='00:00:00';
$xPE=0;
$xPS=0;
$xdata = "SELECT * FROM tblogin WHERE empid=:user AND Semana=:week AND DIA_LETRA=:pDay";
$xqry = $dbh -> prepare($xdata);
$xqry->bindParam(':user',$eid,PDO::PARAM_STR);
$xqry->bindParam(':week',date("W"),PDO::PARAM_STR);
$xqry->bindParam(':pDay',$pDay,PDO::PARAM_STR);
$xqry->execute();
$xQres=$xqry->fetchAll(PDO::FETCH_OBJ);
    if($xqry->rowCount() > 0){
        foreach($xQres as $xQr){
            $xCmp=$xQr->reg_type;
                if($xCmp=='ENTRADA'){$xPE=1;    $hI[$pDay]=$xQr->HORA;}
                if($xCmp=='SALIDA'){$xPS=1;     $hF[$pDay]=$xQr->HORA;}
        }
    }
    
    $pointdff=(strtotime($hF[$pDay]) - strtotime($hI[$pDay])) + strtotime($origin);
        if($xPE==0 and $xPS==0){$diff[$pDay] = "N/L";}
        if($xPE==1 and $xPS==0){$diff[$pDay] = "N/R";}  
        $fcrse=date("w"); 
        if($pDay==$fcrse){$diff[$pDay] = "Curzando";}
        if($xPE==1 and $xPS==1){    
            if(date('H:i', $pointdff )>0){
                $diff[$pDay] = date('H:i', $pointdff )."h";
            }
    }
    $xPT=$xPE+$xPS;
    if($xPT==2){$xdL++;}
}
	require 'Classes/PHPExcel.php';
	
	$sql = "SELECT *  FROM tblogin WHERE empid=:eid AND Semana=:week ORDER by Entrada";
	$query = $dbh->prepare($sql);
	$query -> bindParam(':eid',$eid, PDO::PARAM_STR);
	$query -> bindParam(':week', date("W"), PDO::PARAM_STR);
	$query -> execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	
	
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
	'rgb' => 'de121c'
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
	'rgb' => '057504'
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
	'rgb' => 'ff8400'
	)
    ),
    'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);

$estiloTimeExit = array(
    'font' => array(
	'name'  => 'Arial',
	'bold'  => true,
	'size' =>10,
	'color' => array(
	'rgb' => '000000'
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
	$objPHPExcel->getActiveSheet()->getStyle('A1:F4')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->applyFromArray($estiloTituloColumnas);
	$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($estiloTimeFalse);
	$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($estiloTimeTrue);
	
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
	
	$objPHPExcel->getActiveSheet()->setCellValue('A5', 'Horas trabajadas');
	$objPHPExcel->getActiveSheet()->setCellValue('B5', 'Movimiento');
	$objPHPExcel->getActiveSheet()->setCellValue('C5', 'Fecha');
	$objPHPExcel->getActiveSheet()->setCellValue('D5', 'Alertas ');
	$objPHPExcel->getActiveSheet()->setCellValue('F5', 'Hora');
	
	
	$objPHPExcel->getActiveSheet()->setCellValue('E2', "Dias laborables de la semana: $lab / 7");
	$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Semana en curso: ' . date("W"));
	$objPHPExcel->getActiveSheet()->setCellValue('E5', 'Descripcion');
	
	$objPHPExcel->getActiveSheet()->setCellValue('A6', 'LUNES');
	$objPHPExcel->getActiveSheet()->setCellValue('A8', 'MARTES');
	$objPHPExcel->getActiveSheet()->setCellValue('A10', 'MIERCOLES');
	$objPHPExcel->getActiveSheet()->setCellValue('A12', 'JUEVES');
	$objPHPExcel->getActiveSheet()->setCellValue('A14', 'VIERNES');
	$objPHPExcel->getActiveSheet()->setCellValue('A16', 'SABADO');
	$objPHPExcel->getActiveSheet()->setCellValue('A18', 'DOMINGO');
	
	$retardos=0;
	$dL=0;
	$PEm=0;
    $PSm=0;
    $dia_ct=0;
    $Etda="ENTRADA";
    $Slda="SALIDA";
if($query->rowCount() > 0)
{
    foreach($results as $result)
    {       
        
        $objPHPExcel->getActiveSheet() ->getStyle('F') ->getNumberFormat() ->setFormatCode("[h]:mm:ss");
        if($result->DIA_LETRA==0){ $cP=18; $cN=19;}
        if($result->DIA_LETRA==1){ $cP=6; $cN=7;}
        if($result->DIA_LETRA==2){ $cP=8; $cN=9;}
        if($result->DIA_LETRA==3){ $cP=10; $cN=11;}
        if($result->DIA_LETRA==4){ $cP=12; $cN=13;}
        if($result->DIA_LETRA==5){ $cP=14; $cN=15;}
        if($result->DIA_LETRA==6){ $cP=16; $cN=17;}
	    
	    if($result->reg_type==$Etda){ 
	    
 		    $objPHPExcel->getActiveSheet()->setCellValue('E'.$cP, $result->Description);
 		    $objPHPExcel->getActiveSheet()->setCellValue('B'.$cP, $result->reg_type);
 		    $objPHPExcel->getActiveSheet()->setCellValue('C'.$cP, $result->DIA_NUMERO);
 		    $objPHPExcel->getActiveSheet()->setCellValue('F'.$cP, $result->HORA);
 		    $fechx= $result->DIA_NUMERO;
            $fdia=substr($fechx,0,2);
            $fmes=substr($fechx,3,2);
            $fanio=substr($fechx,6);
            $semana = date('W',  mktime(0,0,0,$fmes,$fdia,$fanio));  
 		    
 		    if($result->valor==1){ $objPHPExcel->getActiveSheet()->setCellValue('D'.$cP, 'Retardo'); 
 		                           $objPHPExcel->getActiveSheet()->getStyle('D'.$cP)->applyFromArray($estiloTimeFalse);
 		                           $retardos++;
 		                           $dL++;$PEm=$PEm+1;
 		    }
 		                           
            if($result->valor==0){$objPHPExcel->getActiveSheet()->setCellValue('D'.$cP, 'Ok');
                $objPHPExcel->getActiveSheet()->getStyle('D'.$cP)->applyFromArray($estiloTimeTrue);
                $dL++;$PEm=$PEm+2;
            }
                 
            if($result->valor==9){ $objPHPExcel->getActiveSheet()->setCellValue('D'.$cP, 'No_Autorizado'); 
 		                           $objPHPExcel->getActiveSheet()->getStyle('D'.$cP)->applyFromArray($estiloTimeNTH);
 		                           }
	    }
	    if($result->reg_type==$Slda){ 
	        $objPHPExcel->getActiveSheet()->setCellValue('E'.$cN, $result->Description);
 		    $objPHPExcel->getActiveSheet()->setCellValue('B'.$cN, $result->reg_type);
 		    $objPHPExcel->getActiveSheet()->setCellValue('C'.$cN, $result->DIA_NUMERO);
 		    $objPHPExcel->getActiveSheet()->setCellValue('F'.$cN, $result->HORA);
 		    $fechx= $result->DIA_NUMERO;
            $fdia=substr($fechx,0,2);
            $fmes=substr($fechx,3,2);
            $fanio=substr($fechx,6);
            $semana = date('W',  mktime(0,0,0,$fmes,$fdia,$fanio));  
 		                           
 		    if($result->valor==9){ $objPHPExcel->getActiveSheet()->setCellValue('D'.$cN, 'No_Autorizado'); 
 		                           $objPHPExcel->getActiveSheet()->getStyle('D'.$cN)->applyFromArray($estiloTimeNTH);
 		                           }
 		                           
 		    if($result->valor==2){ $objPHPExcel->getActiveSheet()->setCellValue('D'.$cN, 'Salida'); 
 		                           $objPHPExcel->getActiveSheet()->getStyle('D'.$cN)->applyFromArray($estiloTimeExit);
 		                           $PSm=$PSm+2;
 		                           }
	    }
 		
 		
 	
 		
 				

    } 
}





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
	$gdImage = imagecreatefrompng("upload/Fotos/$result->foto");
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

$horaslaboradas = array( 
  'borders' => array(
    'outline' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
    ),
    'font' => array(
	'name'  => 'Arial',
	'bold'  => true,
	'size' =>10,
	'color' => array(
	'rgb' => '000000'
	)
    ),
    'fill' => array(
	'type' => PHPExcel_Style_Fill::FILL_SOLID,
	'color' => array('rgb' => 'dedee3')
    ),
    'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);

$bordes = array( 
  'borders' => array(
    'outline' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
    )
);

$bordesG = array( 
  'borders' => array(
    'outline' => array(
      'style' => PHPExcel_Style_Border::BORDER_THICK
    )
    )
);

$FondoBlanco = array( 
    'fill' => array(
	'type' => PHPExcel_Style_Fill::FILL_SOLID,
	'color' => array('rgb' => 'ffffff')
    ),
    'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);


    $objPHPExcel->getActiveSheet()->getStyle('B6:F19')->applyFromArray($FondoBlanco);
    
    
    $objPHPExcel->getActiveSheet()->getStyle('B6:F7')->applyFromArray($bordes);
    $objPHPExcel->getActiveSheet()->getStyle('B8:F9')->applyFromArray($bordes);
    $objPHPExcel->getActiveSheet()->getStyle('B10:F11')->applyFromArray($bordes);
    $objPHPExcel->getActiveSheet()->getStyle('B12:F13')->applyFromArray($bordes);
    $objPHPExcel->getActiveSheet()->getStyle('B14:F15')->applyFromArray($bordes);
    $objPHPExcel->getActiveSheet()->getStyle('B16:F17')->applyFromArray($bordes);
    $objPHPExcel->getActiveSheet()->getStyle('B18:F19')->applyFromArray($bordes);
    
    
    $objPHPExcel->getActiveSheet()->setCellValue('A7', "$diff[1]");
    $objPHPExcel->getActiveSheet()->getStyle('A6:A7')->applyFromArray($horaslaboradas);
    $objPHPExcel->getActiveSheet()->setCellValue('A9', "$diff[2]");
    $objPHPExcel->getActiveSheet()->getStyle('A8:A9')->applyFromArray($horaslaboradas);
    $objPHPExcel->getActiveSheet()->setCellValue('A11', "$diff[3]");
    $objPHPExcel->getActiveSheet()->getStyle('A10:A11')->applyFromArray($horaslaboradas);
    $objPHPExcel->getActiveSheet()->setCellValue('A13', "$diff[4]");
    $objPHPExcel->getActiveSheet()->getStyle('A12:A13')->applyFromArray($horaslaboradas);
    $objPHPExcel->getActiveSheet()->setCellValue('A15', "$diff[5]");
    $objPHPExcel->getActiveSheet()->getStyle('A14:A15')->applyFromArray($horaslaboradas);
    $objPHPExcel->getActiveSheet()->setCellValue('A17', "$diff[6]");
    $objPHPExcel->getActiveSheet()->getStyle('A16:A17')->applyFromArray($horaslaboradas);
    $objPHPExcel->getActiveSheet()->setCellValue('A19', "$diff[0]");
    $objPHPExcel->getActiveSheet()->getStyle('A18:A19')->applyFromArray($horaslaboradas);

    $objPHPExcel->getActiveSheet()->setCellValue('D3', "Retardos:  $retardos");
    $objPHPExcel->getActiveSheet()->setCellValue('E3', "Dias laborados:  $xdL");
    $pctg=$PTm/$lab;
    $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Porcentage de cumplimiento:');
    $objPHPExcel->getActiveSheet()->setCellValue('F4', "$pctg");
    $objPHPExcel->getActiveSheet()->getStyle('F4')->getNumberFormat()->applyFromArray(["code" => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE]);
        
    $objPHPExcel->getActiveSheet()->getStyle('A1:F19')->applyFromArray($bordesG);

	$name=$result->FirstName;
	$clve=$result->EmpId;
	$yc=date("Y");
	$week=date("W");
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header("Content-Disposition: attachment;filename= $clve:Semana:$week:$yc:$name.xlsx");
	header('Cache-Control: max-age=0');
	
	
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	
	$objWriter->save('php://output');}
?>