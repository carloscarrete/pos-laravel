<?php
error_reporting(0);
include('../../conect.php');
require_once('../../Mail/config.php');

date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
$Data=date("d-m-Y");
$empid=$_POST["empid"];
$b_id=$_POST["buss_id"];

$BAR = "SELECT * from users WHERE id=:empid";
$QyBar = $dbP -> prepare($BAR);
$QyBar->bindParam(':empid',$empid,PDO::PARAM_STR);
$QyBar->execute();
$RsEmp=$QyBar->fetchAll(PDO::FETCH_OBJ);
if($QyBar->rowCount() > 0){  
    foreach($RsEmp as $RE){
        $emp_name = $RE->first_name . " " . $RE->last_name;
    }
}
$emp_name=$emp_name;

$BAR = "SELECT * from cash_registers WHERE user_id=:empid AND status='open' ";
$QyBar = $dbP -> prepare($BAR);
$QyBar->bindParam(':empid',$empid,PDO::PARAM_STR);
$QyBar->execute();
$RsCash=$QyBar->fetchAll(PDO::FETCH_OBJ);
if($QyBar->rowCount() > 0){  
    foreach($RsCash as $RC){
        $caja = $RC->id;
        $location_id = $RC->location_id;
    }
}
else {
$caja = "No hay caja para registrar";   
}
$caja = $caja;
?>


<!DOCTYPE html>
<html lang="es">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
        
		
    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />    
        <!-- Title -->
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Misael Garcia" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../../assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
        <link href="../../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/css/custom.css" rel="stylesheet" type="text/css"/>
        
    </head>
    <body >
            <main class="mn-inner">
                    <div class="col s12">
                    </div>
                                <div class="card-content">
                                
                    <div class="col s12 m12 l6">
                        <div class="card">
                            <div class="card-content">                  
                                <div class="row">
                                    <form class="col s12" name="chngpwd" method="post" action="retiro_control.php" enctype="multipart/form-data" target="hide">
                                        <div class="row">
                                            <style>
                                                .hidden{
                                                    visibility: hidden;
                                                    height: 0px;
                                                    width: 0px;
                                                }
                                            </style>
                                            
                                            <div class="input-field hidden">
                                                <input readonly  name="cashreg" class="materialize-textarea" type="text" value="<?php echo $caja;?>" required />
                                            </div>
                                            <div class="input-field hidden">
                                                <input readonly  name="bussid" class="materialize-textarea" type="text" value="<?php echo $b_id;?>" required />
                                            </div>
                                            <div class="input-field hidden">
                                                <input readonly  name="id" class="materialize-textarea" type="text" value="<?php echo $empid;?>" required />
                                            </div>
                                            <div class="input-field col s1" ></div>
                                            <div class="input-field col s2">FECHA:
                                                <input readonly name="fecha" class="materialize-textarea"  type="text" value="<?php echo $Data;?>" required />
                                            </div>
                                            <div class="input-field col s2">Empleado:
                                                <input readonly name="empid" class="materialize-textarea"  type="text" value="<?php echo $emp_name;?>" required />
                                            </div>
                                            
                                            <div class="input-field col s2">Ubicación:
                                            <select  name="location" autocomplete="off" required>
                                                <option value="0">Selecciona...</option>
                                                <?php  $sql = "SELECT  * from business_locations where id=:idl";
                                                        $query = $dbP -> prepare($sql);
                                                        $query->bindParam(':idl',$location_id,PDO::PARAM_STR);
                                                        $query->execute();
                                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                        if($query->rowCount() > 0)
                                                        {
                                                        foreach($results as $result)
                                                        {   ?>                                            
                                                        <option value="<?php echo htmlentities($result->name);?>"><?php echo htmlentities($result->name);?></option>
                                                        <?php }} ?>
                                            </select>
                                            </div>
                                            
                                            <div class="input-field col s2">Monto a retirar:
                                                <input  name="cash" class="materialize-textarea"  type="number"  placeholder="$0" required />
                                            </div>
                                            <div class="input-field col s1" ></div>
                                                <div class="input-field col s1" >
                                                    <button class="waves-effect waves-light btn black">RETIRAR</button>
                                                </div>
                                        
                                    </form>
                                   
                                    <div class="input-field col s1">
                                        <iframe name="hide" style="width:0px;height:0px;border:none; "></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        
                     
             
                   
                    </div>
                
            </main>

        </div>
        <div class="left-sidebar-hover"></div>
        
        
    </body>
</html>

<!-- Javascripts -->
        <script src="../../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../../assets/js/alpha.min.js"></script>
        <script src="../../assets/js/pages/form_elements.js"></script>
          <script src="../../assets/js/pages/form-input-mask.js"></script>
                <script src="../../assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>