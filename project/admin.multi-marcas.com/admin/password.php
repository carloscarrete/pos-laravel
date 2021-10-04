<!-- ADMIN -->
<?php
include('includes/config.php');
require_once('Classes/PHPMail/config.php');

if(isset($_POST['recovery'])){
    $correo=$_POST['email'];
    $sql ="SELECT * FROM admin WHERE correo=:correo";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':correo', $correo, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    $pass=$results->Password;
    if($query->rowCount() > 0){
        foreach($results as $result){  
            $pass = base64_decode($result->Password);
            $usuario = $result->UserName;
            $rn = $result->Real_name;
            $destino = EMAIL_RECOVERY;
            $mail->ClearAllRecipients();
            $mail->AddAddress("$destino");
            $mail->IsHTML(true);  //podemos activar o desactivar HTML en mensaje
            $mail->Subject = 'CONTRASEÑA DE ADMINISTRADOR';

            $msg = "<h2>Hola $rn, solicitaste que te enviaramos tu contraseña:</h2>
            <p>Recuerda que la puedes cambiar dentro del panel de administrador</p>
            <p>Tu usuario:<b style=color:blue> $usuario  </b></p>
            <p>Tu contraseña:<b style=color:blue> $pass </b></p>
            ";

            $mail->Body    = $msg;
            $mail->Send();
        }
        $msg="Tu contraseña se envió a tu correo";
    }
    else{
        $error="No hay ninguna cuenta con ese correo";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
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
    <body class="body" class="signin-page">

        <div class="mn-content valign-wrapper">

                <main class="mn-inner container"><br><br><br>
                <div class="valign">
                      <div class="row">

                          <div class="col s12 m6 l4 offset-l4 offset-m3">
                              <div class="card white darken-1">
                                  <div class="card-content ">
                                             
                                      <span class="card-title">Inicio <b class="copyright" align=right><a href="/admin">< Regresar </a></b> </span>
                                      
                                       
                                       <div class="row">
                                           <form class="col s12" name="recovery" method="post">
                                               <div class="input-field col s12">
                                                   <input id="email" type="text" name="email" class="validate" autocomplete="off" required >
                                                   <label for="email">Correo del administrador</label>
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

        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
        
    </body>
</html>