<!-- EMPLEADO -->
<?php
session_start();
error_reporting(0);
include('admin/includes/config.php');

if(strlen($_SESSION['emplogin'])!=0)
    {   
header("location:asistencia"); 
}

if(strlen($_SESSION['alogin'])!=0)
    {   
header("location:admin/h_asist_all"); 
}


if(isset($_GET['help']))
{
header('location:password');
} 

if(isset($_POST['signin']))
{
$uname=$_POST['username'];
$password=base64_encode($_POST['password']);
$cmp=PASS_PRED;

$sql ="SELECT EmailId,Password,Status,id,foto,count FROM tblemployees WHERE EmailId=:uname and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);


if($query->rowCount() > 0)
{
 foreach ($results as $result) {
    $pcmu= base64_decode($result->Password);
    $count=$result->count;
        
    if($count>2){
    $sucon="update tblemployees set Status=0 WHERE EmailId=:uname";
    $suconu = $dbh->prepare($sucon);
    $suconu-> bindParam(':uname', $uname, PDO::PARAM_STR);
    $suconu->execute();
    echo "<script>alert('Tu cuenta fue suspendida por razones de seguridad, contacta a un administrador');</script>";
    echo "<script type='text/javascript'> document.location = 'https://admin.multi-marcas.com/'; </script>";
    }
    
    if($pcmu==$cmp){
    $log=$count+1;
    $con="update tblemployees set count=:log WHERE EmailId=:uname";
    $conupdate = $dbh->prepare($con);
    $conupdate-> bindParam(':log', $log, PDO::PARAM_STR);
    $conupdate-> bindParam(':uname', $uname, PDO::PARAM_STR);
    $conupdate->execute();
    echo "<script>alert('Recuerda que solo tienes 3 inicios de sesion, si no cambias tu contraseña, la cuenta sera suspendida. Llevas: $log');</script>";
    } 
     
    $status=$result->Status;
    $_SESSION['eid']=$result->id;
    $_SNV=$result->FirstName;
    $fus=$result->foto;
    
                    
     
 }
if($status==0){echo "<script>alert('Tu cuenta esta suspendida, contacta a un administrador');</script>";}
    else{ if($status==2){echo "<script>alert('Lo sentimos, fuiste dado de baja en nuestro sistema');</script>";}
        else{   
                            $_SESSION['emplogin']=$_POST['username'];
                            echo "<script type='text/javascript'> document.location = 'asistencia'; </script>";
                    
            }
} }

else{

  echo "<script>alert('Datos incorrectos');</script>";

}

}

?><!DOCTYPE html>
<html lang="es">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

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


        <!-- Theme Styles -->
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="http://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="http://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body class="body">
        
        <div class="loader-bg"></div>
        <div class="loader">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-spinner-teal lighten-1">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mn-content fixed-sidebar">
            <header class="mn-header navbar-fixed">
                <nav class="<?php echo THEME_HEAD;?> darken-1">
                    <div class="nav-wrapper row">
                        <section class="material-design-hamburger navigation-toggle">
                            <a href="#" data-activates="slide-out" class="button-collapse show-on-large material-design-hamburger__icon">
                                <span class="material-design-hamburger__layer"></span>
                            </a>
                        </section>
                        <div class="header-title col s3">
                            <span class="chapter-title">INICIO: <?php echo APP_HEAD; ?></span>
                        </div>


                        </form>


                    </div>
                </nav>
            </header>


            <aside id="slide-out" class="side-nav nav fixed">
                <div class="side-nav-wrapper">


                <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion" style="">
                    <li>&nbsp;</li>
                    <li class="no-padding"><a class="waves-effect waves-grey" href="/"><i class="material-icons">account_box</i>Iniciar como Empleado</a></li>

                       <li class="no-padding"><a class="waves-effect waves-grey" href="admin/"><i class="material-icons">account_box</i>Administracion</a></li>

                </ul>
          <div class="footer">
                    <p class="copyright"><a href="https://www.facebook.com/serv.tec.la">FACEBOOK </a></p>

                </div>
                </div>
            </aside>
            <main class="mn-inner">
                <div class="row">
                    <div class="col s12">
                        <h4 align="center"><font color="black" class="FUSHIA"><?php echo APP_HEAD; ?></font></h4>

                          <div class="col s12 m6 l8 offset-l2 offset-m3">
                              <div class="card white darken-1">

                                  <div class="card-content ">
                                      <span class="card-title" style="font-size:20px;">Iniciar como empleado</span>
                                         <?php if($msg){?><div class="errorWrap"><strong>Error</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                                       <div class="row">
                                           <form class="col s12" name="signin" method="post">
                                               <div class="input-field col s12">
                                                   <input id="username" type="text" name="username" class="validate" autocomplete="off" required >
                                                   <label for="email">Usuario </label>
                                               </div>
                                               <div class="input-field col s12">
                                                   <input id="password" type="password" class="validate" name="password" autocomplete="off" required>
                                                   <label for="password">Contraseña</label>
                                               </div>
                                                <div class="col s12 right-align m-t-sm">
                                                    <p class="copyright"><a href="index?help">Olvido la contraseña </a></p> 
                                                   <input type="submit" name="signin" value="Iniciar" class="waves-effect waves-light btn <?php echo THEME_HEAD;?>">
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
        <div class="left-sidebar-hover"></div>

        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/js/alpha.min.js"></script>

    </body>
</html>
