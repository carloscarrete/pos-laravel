<!-- USER -->
<?php
include('admin/includes/config.php');
require_once('admin/Classes/PHPMail/config.php');

if(isset($_POST['recovery']))
{
$dominio=DOMINIO_SMTP;
$correo=$_POST['email'];
$sql ="SELECT Password, EmailId FROM tblemployees WHERE EmailId=:correo";
$query= $dbh -> prepare($sql);
$query-> bindParam(':correo', $correo, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() > 0)
{foreach($results as $result)
{  
$pass = base64_decode($result->Password);
$usuario = $result->EmailId;
$destino = $usuario.$dominio;

$mail->ClearAllRecipients();
$mail->AddAddress("$destino");
$mail->IsHTML(true);  //podemos activar o desactivar HTML en mensaje
$mail->Subject = 'CONTRASEÑA DEL PANEL';

$msg = "<h2>Solicitaste que te enviaramos tu contraseña:</h2>
<p>Recuerda que la puedes cambiar dentro del panel de administrador</p>
<p>Tu usuario:<b style=color:red> $usuario </b></p>
<p>Tu contraseña:<b style=color:red> $pass </b></p>
";

$mail->Body    = $msg;
$mail->Send();
}
    $msg="Tu contraseña se envió a tu correo";
}
else{
    $error="No hay ninguna cuenta con ese usuario";
}
}


?>

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
                <nav class="<?php echo THEME_HEAD; ?> darken-1">
                    <div class="nav-wrapper row">
                        <section class="material-design-hamburger navigation-toggle">
                            <a href="#" data-activates="slide-out" class="button-collapse show-on-large material-design-hamburger__icon">
                                <span class="material-design-hamburger__layer"></span>
                            </a>
                        </section>
                        <div class="header-title col s3">
                            <span class="chapter-title">Recuperar contraseña </span>
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
            <main class="mn-inner container"><br><br><br>
            
                <div class="valign">
                      <div class="row">
                          <div class="col s12 m6 l4 offset-l4 offset-m3">
                              <div class="card white darken-1">
                                  <div class="card-content ">
                                             
                                      <span class="card-title">Recuperar contraseña <b class="copyright" align=right><a href="index">< Regresar </a></b> </span>
                                      
                                       
                                       <div class="row">
                                           <form class="col s12" name="recovery" method="post">
                                               <div class="input-field col s12">
                                                   <input id="email" type="text" name="email" class="validate" autocomplete="off" required >
                                                   <label for="email">Tu usuario</label>
                                               </div>
                                               <?php if($error){?><div style="color:red"><strong>Error</strong>: <?php echo htmlentities($error); ?> </div><?php } 
                                                        else if($msg){?><div style="color:green"><strong>Ok</strong>: <?php echo htmlentities($msg); ?> </div><?php }?>
                                               <div class="col s12 right-align m-t-sm">
                                                <input type="submit" name="recovery" value="Enviar" class="waves-effect waves-light btn <?php echo THEME_HEAD; ?>">
                                                   
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