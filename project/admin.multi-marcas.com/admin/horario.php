<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
echo "<script type=''>alert('Sesion caducada, inicia nuevamente.');</script>";
    echo "<script lenguaje=\"JavaScript\">window.close();</script>";
}

else{
$eid=intval($_GET['empid']);


if(isset($_POST['hup']))
{
$lu_e =$_POST['lu_e'].":59";
$lu_s =$_POST['lu_s'].":00";
$ma_e =$_POST['ma_e'].":59";
$ma_s =$_POST['ma_s'].":00";
$mi_e =$_POST['mi_e'].":59";
$mi_s =$_POST['mi_s'].":00";
$ju_e =$_POST['ju_e'].":59";
$ju_s =$_POST['ju_s'].":00";
$vi_e =$_POST['vi_e'].":59";
$vi_s =$_POST['vi_s'].":00";
$sa_e =$_POST['sa_e'].":59";
$sa_s =$_POST['sa_s'].":00";
$do_e =$_POST['do_e'].":59";
$do_s =$_POST['do_s'].":00";
$codemp =$_POST['empcode'];

if($lu_e<0 or $lu_s<0 or ($lu_e<0 and $lu_s<0)){$Lu_ath=0;}
if($lu_e>0 and $lu_s>0){$Lu_ath=1;}

if($ma_e<0 or $ma_s<0 or ($ma_e<0 and $ma_s<0)){$Ma_ath=0;}
if($ma_e>0 and $ma_s>0){$Ma_ath=1;}

if($mi_e<0 or $mi_s<0 or ($mi_e<0 and $mi_s<0)){$Mi_ath=0;}
if($mi_e>0 and $mi_s>0){$Mi_ath=1;}

if($ju_e<0 or $ju_s<0 or ($ju_e<0 and $ju_s<0)){$Ju_ath=0;}
if($ju_e>0 and $ju_s>0){$Ju_ath=1;}

if($vi_e<0 or $vi_s<0 or ($vi_e<0 and $vi_s<0)){$Vi_ath=0;}
if($vi_e>0 and $vi_s>0){$Vi_ath=1;}

if($sa_e<0 or $sa_s<0 or ($sa_e<0 and $sa_s<0)){$Sa_ath=0;}
if($sa_e>0 and $sa_s>0){$Sa_ath=1;}

if($do_e<0 or $do_s<0 or ($do_e<0 and $do_s<0)){$Do_ath=0;}
if($do_e>0 and $do_s>0){$Do_ath=1;}



$sql="update tblemployees
         set lunes_e=:lu_e, lunes_s=:lu_s,
             martes_e=:ma_e, martes_s=:ma_s,
             miercoles_e=:mi_e, miercoles_s=:mi_s,
             jueves_e=:ju_e, jueves_s=:ju_s,
             viernes_e=:vi_e, viernes_s=:vi_s,
             sabado_e=:sa_e, sabado_s=:sa_s,
             domingo_e=:do_e, domingo_s=:do_s,
             LUNES=:lu_ath, MARTES=:ma_ath, MIERCOLES=:mi_ath,
             JUEVES=:ju_ath, VIERNES=:vi_ath,
             SABADO=:sa_ath, DOMINGO=:do_ath
            
        where EmpId=:codemp";
        
$query = $dbh->prepare($sql);
$query->bindParam(':lu_ath',$Lu_ath,PDO::PARAM_STR);
$query->bindParam(':ma_ath',$Ma_ath,PDO::PARAM_STR);
$query->bindParam(':mi_ath',$Mi_ath,PDO::PARAM_STR);
$query->bindParam(':ju_ath',$Ju_ath,PDO::PARAM_STR);
$query->bindParam(':vi_ath',$Vi_ath,PDO::PARAM_STR);
$query->bindParam(':sa_ath',$Sa_ath,PDO::PARAM_STR);
$query->bindParam(':do_ath',$Do_ath,PDO::PARAM_STR);

$query->bindParam(':lu_e',$lu_e,PDO::PARAM_STR);
$query->bindParam(':lu_s',$lu_s,PDO::PARAM_STR);
$query->bindParam(':ma_e',$ma_e,PDO::PARAM_STR);
$query->bindParam(':ma_s',$ma_s,PDO::PARAM_STR);
$query->bindParam(':mi_e',$mi_e,PDO::PARAM_STR);
$query->bindParam(':mi_s',$mi_s,PDO::PARAM_STR);
$query->bindParam(':ju_e',$ju_e,PDO::PARAM_STR);
$query->bindParam(':ju_s',$ju_s,PDO::PARAM_STR);
$query->bindParam(':vi_e',$vi_e,PDO::PARAM_STR);
$query->bindParam(':vi_s',$vi_s,PDO::PARAM_STR);
$query->bindParam(':sa_e',$sa_e,PDO::PARAM_STR);
$query->bindParam(':sa_s',$sa_s,PDO::PARAM_STR);
$query->bindParam(':do_e',$do_e,PDO::PARAM_STR);
$query->bindParam(':do_s',$do_s,PDO::PARAM_STR);
$query->bindParam(':codemp',$codemp,PDO::PARAM_STR);
$query->execute();

//SET table1.value=table2.value 
//WHERE table2.id=table1.id


$msg="Horario modificado con Exito";
}


    ?>

<!DOCTYPE html>
<html lang="es">
    <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
        
        <!-- Title -->
        <title><?php echo APP_TITLE;?></title>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Misael Garcia" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
        
            <!-- Theme Styles -->
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
  <style>
  
        .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
        </style>





    </head>
    <body class="body">
  <?php /*include('includes/header.php');?>
  
  
            
       <?php include('includes/sidebar.php');*/?>
            <main class="mn-inner">
                <div class="row">
                    
                    <div class="col s12">
                        
                    </div>
                                
                   
                    <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <?php 
$eid=intval($_GET['empid']);
$sql = "SELECT * from  tblemployees where id=:eid";
$query = $dbh -> prepare($sql);
$query -> bindParam(':eid',$eid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;

if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?> 
<?php $ruta_imagen=$result->foto;?>
<font size=5><td><?php echo htmlentities($result->FirstName);?>&nbsp;<?php echo htmlentities($result->LastName);
?> 


</td></font><br>



<br>
    <a href="h_asist?empid=<?php echo htmlentities($eid);?>" onclick=""> <i class="btn btn-warning <?php echo THEME_HEAD; ?>">Regresar</i></a>


<td><img src="../admin/upload/Fotos/<?php echo htmlentities($ruta_imagen);?>" class="box right" alt="" width="150" height="150"></td><br><br>
	
<?php }}
 echo htmlentities($id_search);?><br><br>


                                
                                <span class="card-title"> Revision de horario del empleado </span>
                                

<form id="example-form" method="post" name="updatemp">
    
    <div class="input-field col  s12">
<label for="empcode">Código de empleado:</label>
<input  name="empcode" id="empcode" value="<?php echo htmlentities($result->EmpId);?>" type="text" autocomplete="off" readonly required>
<span id="empid-availability" style="font-size:12px;"></span> 
</div>
                                
                                <?php if($msg){?><div class="succWrap"><strong>Ok</strong>: <?php echo htmlentities($msg); ?> </div><?php }?>
                                
                           
                                
                                <table id="example" class="display responsive-table ">
                                    
                                    <thead>
                                                                                                    

                                        <tr>
                                            <th width="10"></th>
                                            <th width="100">Lunes</th>
                                             <th width="100">Martes</th>
                                            <th width="100">Miercoles</th>
                                            <th width="100">Jueves</th>
                                            <th width="100">Viernes</th>
                                            <th width="100">Sabado</th>
                                            <th width="100">Domingo</th>
                                            
                                        </tr>
                                       
                                    </thead>
                                
                                        <tbody>
<?php 
$sql = "SELECT * from tblemployees where id=:eid";
$query = $dbh -> prepare($sql);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
                                        <tr>
                                            <td>Entrada</td>
                                            <td><div class="input-field col m8 s12">
                                            <input id="lu_e" name="lu_e" value="<?php echo substr($result->lunes_e,0,5);?>"  type="time" required></div></td>
                                            <td><div class="input-field col m8 s12">
                                            <input id="ma_e" name="ma_e" value="<?php echo substr($result->martes_e,0,5);?>"  type="time" required></div></td>
                                            <td><div class="input-field col m8 s12">
                                            <input id="mi_e" name="mi_e" value="<?php echo substr($result->miercoles_e,0,5);?>"  type="time" required></div></td>
                                            <td><div class="input-field col m8 s12">
                                            <input id="ju_e" name="ju_e" value="<?php echo substr($result->jueves_e,0,5);?>"  type="time" required></div></td>
                                            <td><div class="input-field col m8 s12">
                                            <input id="vi_e" name="vi_e" value="<?php echo substr($result->viernes_e,0,5);?>"  type="time" required></div></td>
                                            <td><div class="input-field col m8 s12">
                                            <input id="sa_e" name="sa_e" value="<?php echo substr($result->sabado_e,0,5);?>"  type="time" required></div></td>
                                            <td><div class="input-field col m8 s12">
                                            <input id="do_e" name="do_e" value="<?php echo substr($result->domingo_e,0,5);?>"  type="time" required></div></td>
                                        </tr>
                                        
                                         
                                        <tr>
                                            <td>Salida</td>
                                            <td><div class="input-field col m8 s12">
                                            <input id="lu_s" name="lu_s" value="<?php echo substr($result->lunes_s,0,5);?>"  type="time" required></div></td>
                                            <td><div class="input-field col m8 s12">
                                            <input id="ma_s" name="ma_s" value="<?php echo substr($result->martes_s,0,5);?>"  type="time" required></div></td>
                                            <td><div class="input-field col m8 s12">
                                            <input id="mi_s" name="mi_s" value="<?php echo substr($result->miercoles_s,0,5);?>"  type="time" required></div></td>
                                            <td><div class="input-field col m8 s12">
                                            <input id="ju_s" name="ju_s" value="<?php echo substr($result->jueves_s,0,5);?>"  type="time" required></div></td>
                                            <td><div class="input-field col m8 s12">
                                            <input id="vi_s" name="vi_s" value="<?php echo substr($result->viernes_s,0,5);?>"  type="time" required></div></td>
                                            <td><div class="input-field col m8 s12">
                                            <input id="sa_s" name="sa_s" value="<?php echo substr($result->sabado_s,0,5);?>"  type="time" required></div></td>
                                            <td><div class="input-field col m8 s12">
                                            <input id="do_s" name="do_s" value="<?php echo substr($result->domingo_s,0,5);?>"  type="time" required></div></td>
                                        </tr>
                                        
                                         <?php $cnt++;?>
                                         <?php } }?>
                                    </tbody>
                                    
                                    
<?php 
$eid=intval($_GET['empid']);
$sql = "SELECT * from  tblemployees where id=:eid";
$query = $dbh -> prepare($sql);
$query -> bindParam(':eid',$eid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{             ?>

                                                        

<?php }}?>


                                </table>
                                <div align="right">
                                <button type="submit" name="hup"  id="hup" class="waves-effect waves-light btn <?php echo THEME_HEAD; ?> m-b-xs">ACTUALIZAR</button>
                                </div>
                                </form>
                             
     
                            </div>
                        </div>
                    </div>
                </div>
                </main>

 
        <div class="left-sidebar-hover"></div>
        
        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
        <script src="../assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
        
        
       
        
    </body>
</html>
<?php } ?> 