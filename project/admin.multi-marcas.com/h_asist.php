<?php
session_start();
error_reporting(0);
include('admin/includes/config.php');
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
$dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&aacute;bado");
$Meses = array(null,"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Festivos= "SELECT * FROM feriados";
$FQ = $dbh->prepare($Festivos);
$FQ -> bindParam(':eid',$epid, PDO::PARAM_STR);
$FQ -> execute();
$Fresults=$FQ->fetchAll(PDO::FETCH_OBJ);
$FCc=$FQ->rowCount();
$FCt=1;
if($FQ->rowCount() > 0){
    foreach($Fresults as $Fresult){ 
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
    if(in_array($fechrt,$Carga)){$feriados++;}
}
$c=$L+$Ma+$Mi+$J+$V+$S+$D;

//SESION
if(strlen($_SESSION['emplogin'])==0){header("location:/");}
else{
    if(isset($_POST['export'])){
        $exid=$_SESSION['eid'];
        header("location:/exptr_m?exp=$exid");
    }?>
    
<!DOCTYPE html>
<html lang="es">
    <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <!-- Title -->
        <title><?php echo APP_TITLE;?></title>
        <link rel="shortcut icon" type="image/x-icon" href="admin/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Administrador de empresas" />
        <meta name="author" content="Misael Garcia" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
        <link href="assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

            
        <!-- Theme Styles -->
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>
        <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);}
        .succWrap{
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);}
        </style>
    </head>
    
    <body class="body">
        <?php include('includes/header.php');?>
        <?php include('includes/sidebar.php');?>
        <main class="mn-inner">
            <div class="row">
                <div class="card">
                    <div class="card-content">
                        <?php 
                        $user=$_SESSION['eid'];
                        $dL=0;
                        $data = "SELECT * from  tblemployees where id=:user";
                        $qdata = $dbh -> prepare($data);
                        $qdata -> bindParam(':user',$user, PDO::PARAM_STR);
                        $qdata->execute();
                        $qres=$qdata->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($qdata->rowCount() > 0){
                            foreach($qres as $qr){ ?>
                                <font size=5><?php echo htmlentities($qr->FirstName);?>&nbsp;<?php echo htmlentities($qr->LastName);?></font>
                                <?php
                                $paga=$qr->pago;
                                $PEm=0;
                                $PSm=0;
                                $retardos=0;
                                $data = "SELECT * FROM tblogin WHERE empid=:user AND Semana=:week";
                                $qdata = $dbh -> prepare($data);
                                $qdata->bindParam(':user',$user,PDO::PARAM_STR);
                                $qdata->bindParam(':week',date("W"),PDO::PARAM_STR);
                                $qdata->execute();
                                $qres=$qdata->fetchAll(PDO::FETCH_OBJ);
                                $cnt=1;
                                if($qdata->rowCount() > 0){
                                    foreach($qres as $qr){
                                        if($qr->valor==2){$dL++;$PSm=$PSm+2;}
                                        if($qr->valor==1){$retardos++;$PEm=$PEm+1;}
                                        if($qr->valor==0){$PEm=$PEm+2;}
                                        $cnt++;
                                    }
                                }
                                $PTm=$PEm+$PSm;
                                $PTm=$PTm/4;                    
                            }
                        }?><br>
                    </div>
                </div>
                <div class="col s6 m6 l6 ">
                    <div class="card white">
                        <div class="card-content">
                            <font size=5>REPORTE SEMANAL <br> Retardos de la semana:              
                                <?php if($retardos==0){?> <span style="color:green;text-align:center;"><?php echo htmlentities($retardos)?></span> <?php } ?>
                                <?php if($retardos==1){?> <span style="color:orange;text-align:center;"><?php echo htmlentities($retardos)?></span> <?php } ?>
                                <?php if($retardos==2){?> <span style="color:orange;text-align:center;"><?php echo htmlentities($retardos)?></span> <?php } ?>
                                <?php if($retardos>=3){?> <span style="color:red;text-align:center;"><?php echo htmlentities($retardos)?></span> <?php } ?>
                            </font>
                            <hr/>
                            
                            <?php
                            $d_cmp=date("w");
                            if($d_cmp==0){$f_asigncmp=date("d/m");}
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
                            
                            $dlC=0;
                            $lab=0;
                            $gose=0;
                            $sem_arr= array($Do,$Lu,$Ma,$Mi,$Ju,$Vi,$Sa);
                            for($z = 0; $z <= 6; $z++) {
                                
                                if(!in_array($sem_arr[$z],$Carga)){
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
                                if(in_array($sem_arr[$z],$Carga))
                                        {
                                        $gose++;
                                        }
                                
                            }

                            $xdL=0;
                            for($pDay = 0; $pDay <= 6; $pDay++) {
                                $origin='00:00:00';
                                $xPE=0;
                                $xPS=0;
                                $xdata = "SELECT * FROM tblogin WHERE empid=:user AND Semana=:week AND DIA_LETRA=:pDay";
                                $xqry = $dbh -> prepare($xdata);
                                $xqry->bindParam(':user',$user,PDO::PARAM_STR);
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
                                if($xPE==1 and $xPS==0){$diff[$pDay] = "N/S";}  
                                $fcrse=date("w"); 
                                if($pDay==$fcrse){$diff[$pDay] = "Curzando";}
                                if($xPE==1 and $xPS==1){    
                                    if(date('H:i', $pointdff )>0){
                                        $diff[$pDay] = date('H:i', $pointdff )."h";
                                    }
                                }
                                $xPT=$xPE+$xPS;
                                if($xPT==2){$xdL++;}
                            }?>                                            
                            <font size=4>Semana en curso: <?php echo date("W"); ?>&nbsp;&nbsp; Dias laborables de la semana: <?php echo $lab; ?>&nbsp;&nbsp; </font>
                            <?php
                            $dL2=0;
                            $retardos2=0;
                            $PEs=0;
                            $PSs=0;
                            $data2 = "SELECT * FROM tblogin WHERE empid=:user AND Semana=:week";
                            $qdata2 = $dbh -> prepare($data2);
                            $qdata2->bindParam(':user',$user,PDO::PARAM_STR);
                            $qdata2->bindParam(':week',date("W"),PDO::PARAM_STR);
                            $qdata2->execute();
                            $qres2=$qdata2->fetchAll(PDO::FETCH_OBJ);
                            $cnt2=1;
                            if($qdata2->rowCount() > 0){
                                foreach($qres2 as $qr2){
                                    if($qr2->valor==2){$PSs=$PSs + 2;$dL2++;}
                                    if($qr2->valor==1){$retardos2++; $PEs=$PEs + 1;}
                                    if($qr2->valor==0){$PEs=$PEs + 2;}    
                                    $cnt2++;
                                } 
                            }
                            $PT=$PEs+$PSs;
                            $PT=$PT/4;        
                            $Tl=$PT;        
                            $PctD=($Tl/$lab)*100; 
                            $stpt2=$PctD;
                            if($PctD<9){ $stpt2="0" .$PctD;}
                            if($PctD<1){ $stpt2="0";}
                            $pagosemanal=($paga/6)*$Tl;
                            $bonus=($paga/6)*$gose;
                            $pagoTotal=$pagosemanal+$bonus;
                            $printer2= substr($stpt2,0,4) . "%";
                            
                            if($printer2<=0){?>                      
                                <font size=4>
                                    Dias Laborados: <span style="color:gray;text-align:center;"><?php echo $xdL;?></span> &nbsp;&nbsp;
                                    Cumplimiento Semanal:   <span style="color:gray;text-align:center;"><?php echo htmlentities($printer2)?></span>
                                    <?php/*<br>Sueldo Ganado:$<?php echo ($paga/6)*$Tl;?>&nbsp;&nbsp;Sueldo feriado:$<?php echo $bonus;?>
                                    <br>Acumulado: $<span style="color:gray;text-align:center;"><?php echo $pagosemanal;?></span>  */?>
                                </font><?php 
                            }?>
                            
                            <?php
                            if($printer2>0 and $printer2<25){?>       
                                <font size=4>
                                    Dias Laborados: <span style="color:red;text-align:center;"><?php echo $xdL;?></span> &nbsp;&nbsp; 
                                    Cumplimiento Semanal:   <span style="color:red;text-align:center;"><?php echo htmlentities($printer2)?></span>
                                    <?php/*<br>Sueldo Ganado:$<?php echo ($paga/6)*$Tl;?>&nbsp;&nbsp;Sueldo feriado:$<?php echo $bonus;?>
                                    <br>Acumulado: $<span style="color:red;text-align:center;"><?php echo $pagoTotal;?></span></font>  */?>
                                </font><?php 
                            }?>
                            
                            <?php    
                            if($printer2>=25 and $printer2<50){?>     
                                <font size=4>
                                    Dias Laborados: <span style="color:orange;text-align:center;"><?php echo $xdL;?></span> &nbsp;&nbsp; 
                                    Cumplimiento Semanal:   <span style="color:orange;text-align:center;"><?php echo htmlentities($printer2)?></span>
                                    <?php/*<br>Sueldo Ganado:$<?php echo ($paga/6)*$Tl;?>&nbsp;&nbsp;Sueldo feriado:$<?php echo $bonus;?>
                                    <br>Acumulado: $<span style="color:orange;text-align:center;"><?php echo $pagosemanal;?></span></font>  */?>
                                </font><?php 
                            }?>
                            
                            <?php   
                            if($printer2>=50 and $printer2<75){?>     
                                <font size=4>
                                    Dias Laborados: <span style="color:#ebc807;text-align:center;"><?php echo $xdL;?></span> &nbsp;&nbsp; 
                                    Cumplimiento Semanal:   <span style="color:#ebc807;text-align:center;"><?php echo htmlentities($printer2)?></span>
                                    <?php/*<br>Sueldo Ganado:$<?php echo ($paga/6)*$Tl;?>&nbsp;&nbsp;Sueldo feriado:$<?php echo $bonus;?>
                                    <br>Acumulado: $<span style="color:#ebc807;text-align:center;"><?php echo $pagosemanal;?></span></font>  */?>
                                </font><?php 
                            }?>
                            
                            <?php    
                            if($printer2>=75 and $printer2<100){?>    
                                <font size=4>
                                    Dias Laborados: <span style="color:#ffd500;text-align:center;"><?php echo $xdL;?></span> &nbsp;&nbsp; 
                                    Cumplimiento Semanal:   <span style="color:#ffd500;text-align:center;"><?php echo htmlentities($printer2)?></span>
                                    <?php/*<br>Sueldo Ganado:$<?php echo ($paga/6)*$Tl;?>&nbsp;&nbsp;Sueldo feriado:$<?php echo $bonus;?>
                                    <br>Acumulado: $<span style="color:#ffd500;text-align:center;"><?php echo $pagosemanal;?></span></font> */?>
                                </font><?php 
                            }?>
                            
                            <?php    if($printer2==100){?>                    
                                <font size=4>
                                    Dias Laborados: <span style="color:green;text-align:center;"><?php echo $xdL;?></span> &nbsp;&nbsp; 
                                    Cumplimiento Semanal:   <span style="color:green;text-align:center;"><?php echo htmlentities($printer2)?></span>
                                    <?php/*<br>Sueldo Ganado:$<?php echo ($paga/6)*$Tl;?>&nbsp;&nbsp;Sueldo feriado:$<?php echo $bonus;?>
                                    <br>Acumulado: $<span style="color:green;text-align:center;"><?php echo $pagosemanal;?></span></font>  */?>
                                </font><?php 
                            }?>
                            
                            <?php    if($printer2>100){?>                     
                                <font size=4>
                                    Dias Laborados: <span style="color:blue;text-align:center;"><?php echo $xdL;?></span> &nbsp;&nbsp; 
                                    Cumplimiento Semanal:   <span style="color:blue;text-align:center;"><?php echo htmlentities($printer2)?></span>
                                    <?php/*<br>Sueldo Ganado:$<?php echo ($paga/6)*$Tl;?>&nbsp;&nbsp;Sueldo feriado:$<?php echo $bonus;?>
                                    <br>Acumulado: $<span style="color:blue;text-align:center;"><?php echo $pagosemanal;?></span></font> */?>
                                </font><?php 
                            }?>
                            
                            <br>
                            <hr/>
                            
                            <font size=3>
                                Horas Laboradas: <br>
                                Lunes= &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (<?php echo $diff[1];?>)  <br>
                                Martes= &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $diff[2];?>)  <br>
                                Miércoles= (<?php echo $diff[3];?>) <br>
                                Jueves= &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $diff[4];?>)  <br>
                                Viernes= &nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $diff[5];?>)  <br>
                                Sábado= &nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $diff[6];?>) <br>
                                Domingo= &nbsp;(<?php echo $diff[0];?>)
                            </font>
                            <br>
                            
                            <font size=1>
                                N/L= No Laborado,&nbsp;&nbsp;&nbsp;&nbsp;
                                N/S= No registro Salida, &nbsp;&nbsp;&nbsp;&nbsp;
                                Curzando= Día en curzo.
                            </font>
                            <hr/> 
                            <?php 
                            if($msg){?><div class="succWrap"><strong>ÉXITO</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                                
                            
                        </div>
                    </div>
                </div> 
                
                <div class="col s6 m6 l6 <?php echo THEME_HEAD; ?>">
                    <div class="card white">
                        <div class="card-content">
                            <?php 
                            $user=$_SESSION['eid'];
                            $dL=0;
                            $data = "SELECT * from  tblemployees where id=:user";
                            $qdata = $dbh -> prepare($data);
                            $qdata -> bindParam(':user',$user, PDO::PARAM_STR);
                            $qdata->execute();
                            $qres=$qdata->fetchAll(PDO::FETCH_OBJ);
                            $cnt=1;
                            if($qdata->rowCount() > 0){
                                foreach($qres as $qr){ ?>
                                    <?php
                                    $paga=$qr->pago;
                                    $PEm=0;
                                    $PSm=0;
                                    $retardos=0;
                                    $data = "SELECT * FROM tblogin WHERE empid=:user AND Mes=:month";
                                    $qdata = $dbh -> prepare($data);
                                    $qdata->bindParam(':user',$user,PDO::PARAM_STR);
                                    $qdata->bindParam(':month',date("m"),PDO::PARAM_STR);
                                    $qdata->execute();
                                    $qres=$qdata->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    if($qdata->rowCount() > 0){
                                        foreach($qres as $qr){
                                            if($qr->valor==2){$dL++;$PSm=$PSm+2;}
                                            if($qr->valor==1){$retardos++;$PEm=$PEm+1;}
                                            if($qr->valor==0){$PEm=$PEm+2;}
                                            $cnt++;
                                        } 
                                    }
                                    $PTm=$PEm+$PSm;
                                    $PTm=$PTm/4;?>
                                    <font size=5>    
                                        REPORTE MENSUAL <br><?php echo "Retardos de ". $Meses[date("m")].":";?>         
                                        <?php if($retardos==0){?> <span style="color:green;text-align:center;"><?php echo htmlentities($retardos)?></span> <?php } ?>
                                        <?php if($retardos==1){?> <span style="color:orange;text-align:center;"><?php echo htmlentities($retardos)?></span> <?php } ?>
                                        <?php if($retardos==2){?> <span style="color:orange;text-align:center;"><?php echo htmlentities($retardos)?></span> <?php } ?>
                                        <?php if($retardos>=3){?> <span style="color:red;text-align:center;"><?php echo htmlentities($retardos)?></span> <?php } ?>
                                    </font>
                                    <?php 
                                }
                            }?>
                            <br>
                            <hr/>
                            <font size=4>Mes en curso: <?php echo $Meses[date("m")]; ?>&nbsp;&nbsp; Dias laborables: <?php echo $c; ?>&nbsp;&nbsp; </font>
                            <?php                   
                            $yDay = date('t');                                            
                            $ydL=0;
                                for($pMon = 1; $pMon <= $yDay; $pMon++) {
                                    $yPE=0;
                                    $yPS=0;
                                    $ydata = "SELECT * FROM tblogin WHERE empid=:user AND Mes=:month AND dia=:pMon";
                                    $yqry = $dbh -> prepare($ydata);
                                    $yqry->bindParam(':user',$user,PDO::PARAM_STR);
                                    $yqry->bindParam(':month',date("n"),PDO::PARAM_STR);
                                    $yqry->bindParam(':pMon',$pMon,PDO::PARAM_STR);
                                    $yqry->execute();
                                    $yQres=$yqry->fetchAll(PDO::FETCH_OBJ);
                                        if($yqry->rowCount() > 0){
                                            foreach($yQres as $yQr){
                                                $yCmp=$yQr->reg_type;
                                                    if($yCmp=='ENTRADA'){$yPE=1;}
                                                    if($yCmp=='SALIDA'){$yPS=1;}
                                            }
                                        }
                                    $yPT=$yPE+$yPS;
                                    if($yPT==2){$ydL++;}
                                }
                                $Pct=($PTm/$c)*100; 
                                $stpt=$Pct;
                                if($Pct<9){ $stpt="0" .$Pct;}
                                if($Pct<1){ $stpt="0";}
                                $printer= substr($stpt,0,4) . "%";
                                                
                                if($printer<=0){?>                      
                                    <font size=4>
                                        Dias Laborados: <span style="color:gray;text-align:center;"><?php echo $ydL;?></span> &nbsp;&nbsp;
                                        Cumplimiento Mensual:   <span style="color:gray;text-align:center;"><?php echo htmlentities($printer)?></span>
                                    </font> <?php 
                                }
                                
                                if($printer>0 and $printer<25){?>       
                                    <font size=4>
                                        Dias Laborados: <span style="color:red;text-align:center;"><?php echo $ydL;?></span> &nbsp;&nbsp; 
                                        Cumplimiento Mensual:   <span style="color:red;text-align:center;"><?php echo htmlentities($printer)?></span>
                                    </font> <?php 
                                }
                                
                                if($printer>=25 and $printer<50){?>     
                                    <font size=4>
                                        Dias Laborados: <span style="color:orange;text-align:center;"><?php echo $ydL;?></span> &nbsp;&nbsp; 
                                        Cumplimiento Mensual:   <span style="color:orange;text-align:center;"><?php echo htmlentities($printer)?></span>
                                    </font> <?php 
                                } 
                                
                                if($printer>=50 and $printer<75){?>     
                                    <font size=4>
                                        Dias Laborados: <span style="color:#ebc807;text-align:center;"><?php echo $ydL;?></span> &nbsp;&nbsp; 
                                        Cumplimiento Mensual:   <span style="color:#ebc807;text-align:center;"><?php echo htmlentities($printer)?></span>
                                    </font> <?php 
                                }
                                
                                if($printer>=75 and $printer<100){?>    
                                    <font size=4>
                                        Dias Laborados: <span style="color:#ffd500;text-align:center;"><?php echo $ydL;?></span> &nbsp;&nbsp; 
                                        Cumplimiento Mensual:   <span style="color:#ffd500;text-align:center;"><?php echo htmlentities($printer)?></span>
                                    </font> <?php
                                }
                                
                                if($printer==100){?>                    
                                    <font size=4>
                                        Dias Laborados: <span style="color:green;text-align:center;"><?php echo $ydL;?></span> &nbsp;&nbsp; 
                                        Cumplimiento Mensual:   <span style="color:green;text-align:center;"><?php echo htmlentities($printer)?></span>
                                    </font> <?php 
                                }
                                
                                if($printer>100){?>                     
                                    <font size=4>
                                        Dias Laborados: <span style="color:blue;text-align:center;"><?php echo $ydL;?></span> &nbsp;&nbsp; 
                                        Cumplimiento Mensual:   <span style="color:blue;text-align:center;"><?php echo htmlentities($printer)?></span>
                                    </font> <?php 
                                }?>
                            <hr/>
                            
                            <font size=2>  
                                Encontraras los historiales semanal y mensual en esta página mas debajo.
                            </font>
                            <br><br><br><br>
                            <font size=2>  
                                Tienes hasta el dia ultimo del mes para descargar tu reporte.
                            </font>
                            <form name="exportar" method="post">
                                <div align="center"  class="input-field col s12">
                                    <button title="Tienes hasta el dia ultimo para exportar tu reporte" type="submit" name="export" class="waves-effect waves-light btn <?php echo THEME_HEAD; ?> m-b-xs">EXPORTAR A EXCEL</button>
                                </div>
                            </form>
                            
                            
                            <?php 
                            if($msg){?><div class="succWrap"><strong>ÉXITO</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                        </div>    
                    </div>
                </div>
                
                <div class="col s12 m12 l12 ">
                    <div class="card white">
                        <div class="card-content">
                            <font size=5>HISTORIAL SEMANAL</font>
                            <table id="semanas" class="display responsive-table ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th width="220">Fecha</th>
                                        <th width="220">Dia</th>
                                        <th width="220">Hora</th>
                                        <th width="220">Movimiento</th>
                                        <th width="500">Descripcion</th>
                                        <th width="50">Estatus</th>    
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $epid=$_SESSION['eid'];
                                $sql = "SELECT * from tblogin where empid=:eid AND Semana=:week ORDER by Entrada DESC";
                                $query = $dbh -> prepare($sql);
                                $query->bindParam(':eid',$epid,PDO::PARAM_STR);
                                $query->bindParam(':week',date("W"),PDO::PARAM_STR);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                $cnt=1;
                                $retardos=0;
                                    if($query->rowCount() > 0){
                                        foreach($results as $result){?>  
                                            <tr>
                                                <td> <?php echo htmlentities($cnt);?></td>
                                                <td><?php echo htmlentities($result->DIA_NUMERO);?></td>
                                                <?php $dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&aacute;bado");?>
                                                <td><?php echo $dias[($result->DIA_LETRA)];?></td>
                                                <td><?php echo strftime('%I:%M %p',strtotime($result->HORA));?></td>
                                                <td><?php echo htmlentities($result->reg_type);?></td>
                                                <td><?php echo htmlentities($result->Description);?></td>
                                                <td>
                                                    <?php 
                                                    if($result->valor==0){?>
                                                        <font style="color:green">OK</font>
                                                    <?php  
                                                    } 
                                                    else{   
                                                        if($result->valor==1){?>          
                                                            <font style="color:red">RETARDO</font>
                                                            <?php 
                                                        }
                                                        else{
                                                            if($result->valor==9){?>
                                                                <font style="color:orange">NO_PERMITIDO</font>
                                                                <?php    
                                                            }
                                                        }
                                                    } ?>
                                                </td>
                                            </tr>
                                            <?php 
                                            $cnt++;
                                        } 
                                    }?>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
                
                <div class="col s12 m12 l12 ">
                    <div class="card white">
                        <div class="card-content">
                            <font size=5>HISTORIAL MENSUAL</font>
                            <table id="meses" class="display responsive-table ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th width="220">Fecha</th>
                                        <th width="220">Dia</th>
                                        <th width="220">Hora</th>
                                        <th width="220">Movimiento</th>
                                        <th width="500">Descripcion</th>
                                        <th width="50">Estatus</th>    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $epid=$_SESSION['eid'];
                                    $sql = "SELECT * from tblogin where empid=:eid AND Mes=:month ORDER by Entrada DESC";
                                    $query = $dbh -> prepare($sql);
                                    $query->bindParam(':eid',$epid,PDO::PARAM_STR);
                                    $query->bindParam(':month',date("m"),PDO::PARAM_STR);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    $retardos=0;
                                    if($query->rowCount() > 0){
                                        foreach($results as $result){?>  
                                            <tr>
                                                <td> <?php echo htmlentities($cnt);?></td>
                                                <td><?php echo htmlentities($result->DIA_NUMERO);?></td>
                                                <?php $dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&aacute;bado");?>
                                                <td><?php echo $dias[($result->DIA_LETRA)];?></td>
                                                <td><?php echo strftime('%I:%M %p',strtotime($result->HORA));?></td>
                                                <td><?php echo htmlentities($result->reg_type);?></td>
                                                <td><?php echo htmlentities($result->Description);?></td>
                                                <td><?php 
                                                    if($result->valor==0){?>
                                                        <font style="color:green">OK</font><?php 
                                                    }
                                                    else{   
                                                        if($result->valor==1){?>          
                                                            <font style="color:red">RETARDO</font>
                                                            <?php       
                                                        }else{
                                                            if($result->valor==9){?>
                                                                <font style="color:orange">NO_PERMITIDO</font>
                                                                <?php  
                                                            }
                                                        }
                                                    } ?>
                                                </td>
                                            </tr>
                                            <?php 
                                            $cnt++;
                                        } 
                                    }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </main>
        <div class="left-sidebar-hover"></div>
        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/alpha.min.js"></script>
        <script src="assets/js/pages/table-data.js"></script>
    </body>
</html>
<?php 
} ?>