<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strcasecmp(DEMO_STS,"false")==0){$sts=""; }
else {if(strcasecmp(DEMO_STS,"true")==0) {
$sts="DESHABILITADO PARA DEMOSTRACION";    
}else {
$sts="No activaste o desactivaste la demostracion en config.php";    
}}

if(strlen($_SESSION['alogin'])==0)
    {   
header("location:/admin");
}
else{
$eid=intval($_GET['empid']);

if(isset($_POST['update']))
{

$fname=$_POST['firstName'];
$lname=$_POST['lastName'];   
$gender=$_POST['gender']; 
$dob=$_POST['dob']; 
$department=$_POST['department']; 
$address=$_POST['address']; 
$city=$_POST['city']; 
$country=$_POST['country']; 
$mobileno=$_POST['mobileno'];
$fotografia=$_POST['fotografia']; 
$sql="update tblemployees set FirstName=:fname,LastName=:lname,Gender=:gender,Dob=:dob,Department=:department,Address=:address,City=:city,Country=:country,Phonenumber=:mobileno,foto=:fotografia where id=:eid";
$query = $dbh->prepare($sql);
$query->bindParam(':fotografia',$fotografia,PDO::PARAM_STR);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':lname',$lname,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':department',$department,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':city',$city,PDO::PARAM_STR);
$query->bindParam(':country',$country,PDO::PARAM_STR);
$query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();
$msg="Empleado Modificado con Exito";
}


    ?>
    


<!DOCTYPE html>
<html lang="es">
    <head>
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
        <script>
			    $(document).ready(function(){
			        var refreshId =  setInterval( function(){ 
			            $("#directorio").load("upload/ventanadirectorio.php");
			        }, 100 );
	    		    
	    		    $("#borrado").load("upload/ventanaborrar.php");
	    		 
	    		 
				});

		</script>
		

		
        <!-- Title -->
        <title><?php echo APP_TITLE;?></title>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Misael Garcia" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
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
  <?php include('includes/header.php');?>
            
       <?php include('includes/sidebar.php');?>
   <main class="mn-inner">
                <div class="row">
                    <div class="col s12">
                    </div>
                    <div class="col s12 m12 l12">
                        <div class="card ">
                            <div class="card-content">
                                <form id="example-form" method="post" name="updatemp">
                                    <div>
                                        <h3>Actualizar Informacion de Empleado</h3>
                                           <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
                else if($msg){?><div class="succWrap"><strong>Hecho</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                                        <section>
                                            <div class="wizard-content">
                                                <div class="row">
                                                    <div class="col m6">
                                                        <div class="row ">
                                                            
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
 <div class="input-field col  s12">
<label for="empcode">Código de empleado (debe ser único)</label>
<input  name="empcode" id="empcode" value="<?php echo htmlentities($result->EmpId);?>" type="text" autocomplete="off" readonly required>
<span id="empid-availability" style="font-size:12px;"></span> 
</div>


<div class="input-field col m6 s12">
<label for="firstName">Nombre</label>
<input id="firstName" name="firstName" value="<?php echo htmlentities($result->FirstName);?>"  type="text" required>
</div>

<div class="input-field col m6 s12">
<label for="lastName">Apellido </label>
<input id="lastName" name="lastName" value="<?php echo htmlentities($result->LastName);?>" type="text" autocomplete="off" required>
</div>

<div class="input-field col s12">
<label for="email">Usuario</label>
<input  name="email" type="email" id="email" value="<?php echo htmlentities($result->EmailId);?>" readonly autocomplete="off" required>
<span id="emailid-availability" style="font-size:12px;"></span> 
</div>

<div class="input-field col s12">
<label for="passu">Contraseña</label>
<input  name="passu" type="text" id="passu" value="<?php echo base64_decode($result->Password);?>" readonly autocomplete="off" required>
</div>

<div class="input-field col s12">
<label for="phone">Número de teléfono móvil</label>
<input id="phone" name="mobileno" type="tel" value="<?php echo htmlentities($result->Phonenumber);?>" maxlength="10" autocomplete="off" required>
 </div>

</div>
</div>
                                                    
<div class="col m6">
<div class="row">
<div class="input-field col m6 s12">
<select  name="gender" autocomplete="off">
<option value="<?php echo htmlentities($result->Gender);?>"><?php echo htmlentities($result->Gender);?></option>                                          
<option value="Male">Masculino</option>
<option value="Female">Mujer</option>
<option value="Other">Otro</option>
</select>
</div>

<div class="input-field col m6 s12">
<label for="birthdate"> </label>
<input id="birthdate" name="dob"  class="datepicker" value="<?php echo htmlentities($result->Dob);?>" >
</div>

                                                    

<div class="input-field col m6 s12">
<select  name="department" autocomplete="off">
<option value="<?php echo htmlentities($result->Department);?>"><?php echo htmlentities($result->Department);?></option>
<?php $sql = "SELECT DepartmentName from tbldepartments";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $resultt)
{   ?>                                            
<option value="<?php echo htmlentities($resultt->DepartmentName);?>"><?php echo htmlentities($resultt->DepartmentName);?></option>
<?php }} ?>
</select>
</div>

<div class="input-field col m6 s12">
<label for="address">Dirección</label>
<input id="address" name="address" type="text"  value="<?php echo htmlentities($result->Address);?>" autocomplete="off" required>
</div>

<div class="input-field col m6 s12">
<label for="city">Ciudad / Pueblo</label>
<input id="city" name="city" type="text"  value="<?php echo htmlentities($result->City);?>" autocomplete="off" required>
 </div>
   
<div class="input-field col m6 s12">
<label for="country">País</label>
<input id="country" name="country" type="text"  value="<?php echo htmlentities($result->Country);?>" autocomplete="off" required>
</div>

<div class="input-field col m6 s12">
<label for="fotografia">Foto de empleado</label><br><br>
<input id="fotografia" name="fotografia" value="<?php echo htmlentities($result->foto);?>"  type="text-area" required>
<br><br><font size=1>Introduce el nombre de la fotografia (imagen.img, foto.png, captura.png)</font>
</div>

<div class="col m6 s12">
<h6>Vista previa:</h6>
<?php $fus=$result->foto;?>
<img src="../admin/upload/Fotos/<?php echo htmlentities($fus);?>" class="col m6 s12">   
    
</div>

	
<?php }}?>


 
<div class="input-field col s12">
<button type="submit" name="update"  id="update" class="waves-effect waves-light btn <?php echo THEME_HEAD; ?> m-b-xs">ACTUALIZAR</button>
</div>

                                                        </div>
                                                    </div>
                                                <a href="emp_adm" onclick=""> <i class="btn btn-warning <?php echo THEME_HEAD; ?>">Regresar</i></a>
                                                <font class="right" size=3>&nbsp;&nbsp;&nbsp;&nbsp;↓↓↓Baja para ver el directorio fotos↓↓↓</font>
                                                </div>
                                                
                                            </div>
                                        </section>
                                    </section>
                                    </div>     
                                </form>
                                
                                   
                                 
                                
                                
                                </div>
                                 
                            </div> <?php /*card*/?>
                            
                            
                                    <div class="col s12 m12 l12 <?php echo THEME_HEAD; ?>">
                                        <div class="col m4 l4 white">
                                            <h3>Directorio:</h3>
                                            <div id="directorio"></div>
                                            </div>
                                    
                                            <div class="col m4">
                                            <h3>Borrar archivo:</h3>
                                            <div id="borrado"></div>
                                            <h5><?php echo $sts; ?></h5>
                                            </div>
                                            
                                            
                                            <div class="col m4">
                                            <h3>Subir Archivo:</h3>
                                            <?php include('upload/ventanasube.php');?>
                                            <h5><?php echo $sts; ?></h5>
                                            </div>
                                             
                                    </div>
                        </div>
                    </div>
                </div>
               
                
            </main>
        </div>
         
        <div class="left-sidebar-hover"></div>
        
        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
        <script src="../assets/js/pages/form_elements.js"></script>
        
    </body>
</html>


<?php } ?> 