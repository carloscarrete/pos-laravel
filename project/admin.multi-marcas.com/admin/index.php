<!-- ADMIN -->
<?php
session_start();
include('includes/config.php');

if(strlen($_SESSION['emplogin'])!=0)
    {   
header("location:../asistencia"); 
}

if(strlen($_SESSION['alogin'])!=0)
    {   
header("location:h_asist_all"); 
}

if(isset($_GET['help']))
{
header('location:password');
}  

if(isset($_POST['keys']))
{
$root=ADMIN_ROOT;
$pass=base64_encode(ADMIN_PASS);
$UPDATE ="update admin set Password=:pass, UserName=:root, status=1 where id=1";
$UPD = $dbh->prepare($UPDATE);
$UPD-> bindParam(':root', $root, PDO::PARAM_STR);
$UPD-> bindParam(':pass', $pass, PDO::PARAM_STR);
$UPD->execute();
$msg="Keys Cargadas";
}



if(isset($_POST['signin']))
{
$uname=$_POST['username'];
$password=base64_encode($_POST['password']);
$sql ="SELECT UserName,Password, Real_name, foto FROM admin WHERE UserName=:uname and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$fus=$results->foto;
if($query->rowCount() > 0)
{
$_SESSION['alogin']=$_POST['username'];

echo "<script type='text/javascript'> document.location = 'h_asist_all'; </script>";
} else{
  
  echo "<script>alert('USUARIO O CONTRASEÑA INCORRECTA');</script>";
}
}


?>

<!DOCTYPE html>
<html lang="es">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
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
    </head>
    <body class="body">

        <div class="mn-content valign-wrapper">
            

                <main class="mn-inner container"><br><br><br>
                <h4 align="center"><font color="black" class="FUSHIA">Panel de Administrador <?php echo APP_HEAD; ?></font></h4>
                <div class="valign">
                      <div class="row">
                         
                         
                         <?php
                         
                         $BOTON="SELECT status FROM admin WHERE id=1";
                         $queryb = $dbh -> prepare($BOTON);
                         $queryb->execute();
                         $resultsb=$queryb->fetchAll(PDO::FETCH_OBJ);
                         if($queryb->rowCount() > 0)
                            {   
                            foreach($resultsb as $resultb)
                            { $DEC=$resultb->status;   
                            }
                            
                            }
                         
                         if($DEC==0){ ?>
                        <form class="" name="keys" method="post">  
                        <input type="submit" name="keys" value="Cargar KEYS" class="waves-effect waves-light btn <?php echo THEME_HEAD; ?>">
                        </form>
                        <?php 
                        
                        } ?>
                        <?php if($error){?><div class="errorWrap" style="color:yellow"><?php echo htmlentities($error); ?> </div><?php } 
                        else if($msg){?><div class="succWrap" style="color:green"><strong>Ok</strong>: <?php echo htmlentities($msg); ?> </div><?php }?>
                        
                         
                          <div class="col s12 m6 l4 offset-l4 offset-m3">
                              <div class="card white darken-1">
                                  <div class="card-content ">
                                             
                                      <span class="card-title">Inicio <b class="copyright" align=right><a href="/">< Regresar </a></b> </span>
                                      
                                       
                                       <div class="row">
                                           <form class="col s12" name="signin" method="post">
                                               <div class="input-field col s12">
                                                   <input id="username" type="text" name="username" class="validate" autocomplete="off" required >
                                                   <label for="email">Usuario</label>
                                               </div>
                                               <div class="input-field col s12">
                                                   <input id="password" type="password" class="validate" name="password" autocomplete="off" required>
                                                   <label for="password">Password</label>
                                               </div>
                                               
                                               
                                               <div class="col s12 right-align m-t-sm">
                                                
                                                   <p class="copyright"><a href="index?help">Olvido la contraseña </a></p> 
                                                   <input type="submit" name="signin" value="Iniciar" class="waves-effect waves-light btn <?php echo THEME_HEAD; ?>">
                                               </div>
                                           </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
        
    </body>
</html>