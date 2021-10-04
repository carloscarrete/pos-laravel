<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header("location:/admin");
}
else{
// Code for change password 
if(isset($_POST['change']))
    {
        
if(strcasecmp(DEMO_STS,"false")==0){          
if(base64_encode($_POST['newpassword'])==base64_encode($_POST['confirmpassword'])){
$password=base64_encode($_POST['password']);
$newpassword=base64_encode($_POST['newpassword']);
$username=$_SESSION['alogin'];
    $sql ="SELECT Password FROM admin WHERE UserName=:username and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':username', $username, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
$con="update admin set Password=:newpassword where UserName=:username";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':username', $username, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
$msg="Contraseña cambiada";
}
else {
$error="Contraseña actual incorrecta";    
}
}
else {
$error="Error, las contraseñas no son iguales";    
}}else {if(strcasecmp(DEMO_STS,"true")==0) {
$error="Inhabilitado para demostracion";    
}else {
$error="No activaste o desactivaste la demostracion en config.php";    
}}
}

// Code for change password users
if(isset($_POST['uchange']))
    {
if(strcasecmp(DEMO_STS,"false")==0){  
if(base64_encode($_POST['nupss'])==base64_encode($_POST['cnupss'])){
$newpassword=base64_encode($_POST['nupss']);
$username=$_POST['usuarios'];
$sql ="SELECT Password,count,Status FROM tblemployees WHERE id=:username";
$query= $dbh -> prepare($sql);
$query-> bindParam(':username', $username, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{    
$con="update tblemployees set Password=:newpassword, count=0, Status=1 where id=:username";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':username', $username, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
$msg2="Contraseña cambiada";

}
else {
$error2="Intenta de nuevo";    
}
}
else {
$error2="Error, las contraseñas no son iguales";    
}}else {if(strcasecmp(DEMO_STS,"true")==0) {
$error2="Inhabilitado para demostracion";    
}else {
$error2="No activaste o desactivaste la demostracion en config.php";    
}}
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        
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
    </head>
    <body class="body">
  <?php include('includes/header.php');?>
            
       <?php include('includes/sidebar.php');?>
            <main class="mn-inner">
                <div class="row">
                    <div class="col s12">
                    </div>
                    
                    <div class="col s12 m12 l6">
                        <div class="card">
                            <div class="card-content">
                                <div class="col s12 <?php echo THEME_HEAD; ?>">
                                <h4 style="color:white">Contraseña del Admin</h4>
                                
                                </div>
                                <div class="row">
                                    <form class="col s12" name="chngpwd" method="post">
                                          <?php if($error){?><div class="errorWrap" style="color:red"><?php echo htmlentities($error); ?> </div><?php } 
                                                else if($msg){?><div class="succWrap" style="color:green"><?php echo htmlentities($msg); ?> </div><?php }?>
                                        <div class="row">
                                            
                                            
                                            <div class="input-field col s12">
                                                <input id="password" type="password"  class="validate" autocomplete="off" name="password"  required>
                                                <label for="password">contraseña actual</label>
                                            </div>

                                            <div class="input-field col s12">
                                                 <input id="password" type="password" name="newpassword" class="validate" autocomplete="off" required>
                                                <label for="password">Nueva contraseña</label>
                                            </div>

                                            <div class="input-field col s12">
                                                <input id="password" type="password" name="confirmpassword" class="validate" autocomplete="off" required>
                                                 <label for="password">Confirmar contraseña</label>
                                            </div>


                                            <div class="input-field col s12">
                                                <button type="submit" name="change" class="waves-effect waves-light btn <?php echo THEME_HEAD; ?> m-b-xs" onclick="return valid();">Cambio</button>
                                            </div>




                                        </div>
                                       
                                    </form>
                                </div>
                            </div>
                        </div>
                     
             
                   
                    </div>
                    
                    <div class="col s12 m12 l6">
                        <div class="card">
                            <div class="card-content">
                                <div class="col s12 <?php echo THEME_HEAD; ?>">
                                <h4 style="color:white">Contraseña de Usuarios</h4>
                                </div>
                              
                                <div class="row">
                                    <form class="col s12" name="chngpwd" method="post">
                                          <?php if($error2){?><div class="errorWrap" style="color:red"><strong>ERROR</strong>:<?php echo htmlentities($error2); ?> </div><?php } 
                else if($msg2){?><div class="succWrap" style="color:green"><strong>Hecho</strong>:<?php echo htmlentities($msg2); ?> </div><?php }?>
                                        <div class="row">
                                            <div class="input-field col s12">

<div class="input-field col  s12">
<select  name="usuarios" autocomplete="off" required>
<option value="">Elige el Usuario</option>

<?php $sql = "SELECT  FirstName, LastName, id, foto, Status, EmpId from tblemployees ORDER by FirstName";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
<?php
if($result->id!=6){
    if($result->Status!=2){
?>

<option data-icon="upload/Fotos/<?php echo htmlentities($result->foto);?>" value="<?php echo htmlentities($result->id);?>"> <?php echo htmlentities($result->FirstName);  echo " "; echo htmlentities($result->LastName); echo " ("; echo htmlentities($result->EmpId); echo ")"; ?></option>

<?php }}}} ?>
</select>
</div>

  <div class="input-field col s12">
 <input id="password" type="password" name="nupss" class="validate" autocomplete="on" value="<?php echo PASS_PRED; ?>" required>
                                                <label for="password">Nueva contraseña</label>
                                            </div>

<div class="input-field col s12">
<input id="password" type="password" name="cnupss" class="validate" autocomplete="on" value="<?php echo PASS_PRED; ?>" required>
 <label for="password">Confirmar contraseña</label>
</div>

<b>Si no pones una contraseña, se pondra por defecto: </b><b style="color:green"> <?php echo PASS_PRED; ?></b>
<h6>La contraseña por defecto da <b style="color:red"> 3 </b> oportunidades de iniciar sesion y quita la suspension de la cuenta, si el usuario no cambia la contraseña su cuenta se suspendera de nuevo.</h6>
<h6>Si deseas otra, borra las contraseñas e ingresa la deseada.</h6>

<div class="input-field col s12">
<button type="submit" name="uchange" class="waves-effect waves-light btn <?php echo THEME_HEAD; ?> m-b-xs" onclick="return valid();">Cambio</button>

</div>




                                        </div>
                                       
                                    </form>
                                    
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