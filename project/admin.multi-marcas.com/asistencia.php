<?php

session_start();
error_reporting(0);
include('admin/includes/config.php');
if(strlen($_SESSION['emplogin'])==0)
    {   
header("location:/"); 
}
else{   
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
$hora_actual = strtotime(date('H:i:s',time()));
$fecha_reg = date("d-m-Y");
$fchrt= date("d/m");

$empid=$_SESSION['eid'];
$hora = date("H:i:s");
$dias = array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
    
if(isset($_POST['apply']))
{
$empid=$_SESSION['eid'];
$Lunes="lunes";
$Martes="martes";
$Miercoles="mi&eacute;rcoles";
$Jueves="jueves";
$Viernes="viernes";
$Sabado="s&aacute;bado";
$Domingo="domingo";


//lunes
if($dias[date("w")]==$Lunes){
    $diario="SELECT * from tblemployees WHERE id=:empid";
    $pdrday = $dbh->prepare($diario);
    $pdrday->bindParam(':empid',$empid,PDO::PARAM_STR);
    $pdrday->execute();
    $pdresults=$pdrday->fetchAll(PDO::FETCH_OBJ);
    $pdrcnt=1;
        if($pdrday->rowCount() > 0){
        foreach($pdresults as $pdresult){
            $pdrcnt++;
            $setdia=$pdresult->lunes_e;
            $setds=$pdresult->lunes_s;
        }}}
//martes
if($dias[date("w")]==$Martes){
    $diario="SELECT * from tblemployees WHERE id=:empid";
    $pdrday = $dbh->prepare($diario);
    $pdrday->bindParam(':empid',$empid,PDO::PARAM_STR);
    $pdrday->execute();
    $pdresults=$pdrday->fetchAll(PDO::FETCH_OBJ);
    $pdrcnt=1;
        if($pdrday->rowCount() > 0){
        foreach($pdresults as $pdresult){
            $pdrcnt++;
            $setdia=$pdresult->martes_e;
            $setds=$pdresult->martes_s;
        }}} 
//miercoles
if($dias[date("w")]==$Miercoles){
    $diario="SELECT * from tblemployees WHERE id=:empid";
    $pdrday = $dbh->prepare($diario);
    $pdrday->bindParam(':empid',$empid,PDO::PARAM_STR);
    $pdrday->execute();
    $pdresults=$pdrday->fetchAll(PDO::FETCH_OBJ);
    $pdrcnt=1;
        if($pdrday->rowCount() > 0){
        foreach($pdresults as $pdresult){
            $pdrcnt++;
            $setdia=$pdresult->miercoles_e;
            $setds=$pdresult->miercoles_s;
        }}}
//jueves
if($dias[date("w")]==$Jueves){
    $diario="SELECT * from tblemployees WHERE id=:empid";
    $pdrday = $dbh->prepare($diario);
    $pdrday->bindParam(':empid',$empid,PDO::PARAM_STR);
    $pdrday->execute();
    $pdresults=$pdrday->fetchAll(PDO::FETCH_OBJ);
    $pdrcnt=1;
        if($pdrday->rowCount() > 0){
        foreach($pdresults as $pdresult){
            $pdrcnt++;
            $setdia=$pdresult->jueves_e;
            $setds=$pdresult->jueves_s;
        }}} 
//viernes
if($dias[date("w")]==$Viernes){
    $diario="SELECT * from tblemployees WHERE id=:empid";
    $pdrday = $dbh->prepare($diario);
    $pdrday->bindParam(':empid',$empid,PDO::PARAM_STR);
    $pdrday->execute();
    $pdresults=$pdrday->fetchAll(PDO::FETCH_OBJ);
    $pdrcnt=1;
        if($pdrday->rowCount() > 0){
        foreach($pdresults as $pdresult){
            $pdrcnt++;
            $setdia=$pdresult->viernes_e;
            $setds=$pdresult->viernes_s;
        }}} 
//sabado
if($dias[date("w")]==$Sabado){
    $diario="SELECT * from tblemployees WHERE id=:empid";
    $pdrday = $dbh->prepare($diario);
    $pdrday->bindParam(':empid',$empid,PDO::PARAM_STR);
    $pdrday->execute();
    $pdresults=$pdrday->fetchAll(PDO::FETCH_OBJ);
    $pdrcnt=1;
        if($pdrday->rowCount() > 0){
        foreach($pdresults as $pdresult){
            $pdrcnt++;
            $setdia=$pdresult->sabado_e;
            $setds=$pdresult->sabado_s;
        }}}
//domingo
if($dias[date("w")]==$Domingo){
    $diario="SELECT * from tblemployees WHERE id=:empid";
    $pdrday = $dbh->prepare($diario);
    $pdrday->bindParam(':empid',$empid,PDO::PARAM_STR);
    $pdrday->execute();
    $pdresults=$pdrday->fetchAll(PDO::FETCH_OBJ);
    $pdrcnt=1;
        if($pdrday->rowCount() > 0){
        foreach($pdresults as $pdresult){
            $pdrcnt++;
            $setdia=$pdresult->domingo_e;
            $setds=$pdresult->domingo_s;
        }}}
$h=$setdia;
$hs=$setds;
$no_auth_e="00:00:00";
$no_auth_s="00:00:59";

$hora_entrada = strtotime("$h");
$hora_salida = strtotime("$hs");  

$valor = 0; 	
$registro=$_POST['movimiento'];
$Entrada= "ENTRADA";
$Salida= "SALIDA";
$auth=0;

if (strcmp($registro, $Entrada) == 0){//valida si es entrada
$dcc=0; 
$dc = "SELECT * FROM tblogin WHERE (DIA_NUMERO=:fecha_reg) AND (reg_type='ENTRADA') AND (empid=:empid)";
$q_dc = $dbh->prepare($dc);
$q_dc->bindParam(':fecha_reg',$fecha_reg,PDO::PARAM_STR);
$q_dc->bindParam(':empid',$empid,PDO::PARAM_STR);
$q_dc->execute();
$q_dc_rlt=$q_dc->fetchAll(PDO::FETCH_OBJ);
if($q_dc->rowCount() > 0){
        foreach($q_dc_rlt as $q_dc_r){
        $hreg=$q_dc_r->HORA;
        $dcc=1;   
        }}  

if($hora_actual <= $hora_entrada){$crt = "0"; //valida si entro a tiempo
    if($h==$no_auth_e or $h==$no_auth_s ){$crt = "9"; //valida si entro a tiempo y es en horario autorizado
        
    }
}

else{$crt = "1";//valida si es retardo
    if($h==$no_auth_e or $h==$no_auth_s ){$crt = "9";} //valida un retardo en horario no autirizado
}}

if (strcmp($registro, $Salida) == 0){
$dcc=0; 
$auth=1;
$dc = "SELECT * FROM tblogin WHERE (DIA_NUMERO=:fecha_reg) AND (reg_type='SALIDA') AND (empid=:empid)";
$q_dc = $dbh->prepare($dc);
$q_dc->bindParam(':fecha_reg',$fecha_reg,PDO::PARAM_STR);
$q_dc->bindParam(':empid',$empid,PDO::PARAM_STR);
$q_dc->execute();
$q_dc_rlt=$q_dc->fetchAll(PDO::FETCH_OBJ);
if($q_dc->rowCount() > 0){
        foreach($q_dc_rlt as $q_dc_r){
        $hreg=$q_dc_r->HORA;
        $dcc=1;
        }}
        
        
    $crt = "2";
	
	if($hs==$no_auth_e or $hs==$no_auth_s ){$crt = "9";}//valida una salida en horario no autorizado 
	}
	
	
if($dcc==0){
$description=$_POST['description']; 
$sql="INSERT INTO tblogin(DIA_y, dia, empid, Description, DIA_LETRA, DIA_NUMERO, HORA, Mes, Semana, Año, reg_type, valor, fechrt) VALUES(:day_year, :day, :empid, :description, :dias, :dian, :hour, :mes, :week, :year, :justificante, :crt, :fechrt)";
$query = $dbh->prepare($sql);
$query->bindParam(':day_year',date("z"),PDO::PARAM_STR);
$query->bindParam(':empid',$empid,PDO::PARAM_STR);
$query->bindParam(':justificante',$registro,PDO::PARAM_STR);
$query->bindParam(':dias',date("w"),PDO::PARAM_STR);
$query->bindParam(':dian',$fecha_reg,PDO::PARAM_STR);
$query->bindParam(':hour',$hora,PDO::PARAM_STR);
$query->bindParam(':mes',date("n"),PDO::PARAM_STR);
$query->bindParam(':week',date("W"),PDO::PARAM_STR);
$query->bindParam(':year',date("Y"),PDO::PARAM_STR);
$query->bindParam(':day',date("d"),PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->bindParam(':crt',$crt,PDO::PARAM_STR);
$query->bindParam(':fechrt',$fchrt,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId){$msg="Movimiento registrado";}
else{$msg="Intentalo de nuevo";}

}
else{$msg="Ya registraste ese movimiento hoy a las: " . strftime('%I:%M %p',strtotime($hreg));}

}

    ?>
    
<!DOCTYPE html>
<html lang="es">
    <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
        
        <!-- Title -->
        <title><?php echo APP_TITLE;?></title>
        <link rel="shortcut icon" type="image/x-icon" href="admin/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        
        <meta name="description" content="Administrador de empresas" />
        <meta name="author" content="Misael Garcia" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>
  <style>

.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid <?php echo THEME_HEAD; ?>;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}

.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid <?php echo THEME_HEAD; ?>;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
        </style>
 


    </head>
    <body class="body">
  <?php include('includes/header.php');?>
            
       <?php include('includes/sidebar.php');?>
       
   <main class="mn-inner">
                <div class="row">
                    
                        <div class="card">
                            <div class="card-content">
                                <form id="example-form" method="post" name="addemp">
                                    <div>
                                        <h3>Registro</h3>
                                        <section>
                                            <div class="wizard-content">
                                                <div class="row">
                                                    <div class="col m12">
                                                        <div class="row">
                    <div class="succWrap"><strong>Estado</strong>:<?php echo htmlentities($msg); ?> </div>
                    
                    <?php
                    $fid=$result->foto;
                    $comp="default.png";
                    if($fid==$comp){echo "<script>alert('Manda tu foto de perfil para deshabilitar esta ventana');</script>";}
                    ?>
             
                    
                    <td><?php echo htmlentities($result->FirstName);?>&nbsp;<?php echo htmlentities($result->LastName);?></td><br>
<?php
$user=$_SESSION['eid'];
$date=date("z");
$RseC=0;
$we=0;
$ws=0;
$wdata = "SELECT * FROM tblogin WHERE empid=:user AND DIA_y=:today";
$wqry = $dbh -> prepare($wdata);
$wqry->bindParam(':user',$user,PDO::PARAM_STR);
$wqry->bindParam(':today',$date,PDO::PARAM_STR);
$wqry->execute();
$wQres=$wqry->fetchAll(PDO::FETCH_OBJ);
    if($wqry->rowCount() > 0){
        foreach($wQres as $wQr){
            $ww=$wQr->reg_type;
            if(strcmp($ww,'ENTRADA')==0){$we=1;}
            if(strcmp($ww,'SALIDA')==0){$ws=1;}

        }
    }
?>



<?php 

    

if($we==0){
?>                                            
<div class="input-field col  s12"><input name="movimiento" type="text" value="ENTRADA" readonly autocomplete="ON" required>
<?php } 
if($we==1 and $ws==0){
?>                                            
<div class="input-field col  s12"><input name="movimiento" type="text" value="SALIDA" readonly autocomplete="ON" required>
<?php }
if($we==1 and $ws==1){
?>
<div class="input-field col  s12"><input name="movimiento" type="text" value="NO MAS REGISTROS POR HOY" readonly autocomplete="ON" required>
<?php }?>


</select>
</div>

<?php 
if(($we==0 and $ws==0) or ($we==1 and $ws==0)){
?> 
<div class="input-field col m12 s12">
<label for="birthdate">Comentarios: (Puede quedar en blanco)</label>    
<textarea id="textarea1" name="description" class="materialize-textarea" length="500"></textarea>
<?php }?>
</div>
</div>

                                                
                                                
<?php    
if(($we==0 and $ws==0) or ($we==1 and $ws==0)){
?>                                            
      <button type="submit" name="apply" id="apply" class="waves-effect waves-light btn <?php echo THEME_HEAD; ?> m-b-xs">Guardar</button> <?php } ?>    
                                                </div>
                                                
                                            </div>
                                            <?php
                                                
                                                echo "Buenos d&iacute;as, hoy es ".$dias[date("w")] . ".";
                                               
                                                ?>

                                        </section>
                                     
                                    
                                        </section>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
            </main>
        </div>
        <div class="left-sidebar-hover"></div>
        
        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/js/alpha.min.js"></script>
        <script src="assets/js/pages/form_elements.js"></script>
          <script src="assets/js/pages/form-input-mask.js"></script>
                <script src="assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
    </body>
</html>
<?php } ?> 