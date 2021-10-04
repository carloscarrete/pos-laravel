<?php
session_start();
include('../admin/includes/config.php');
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['emplogin'])==0)
    {   
header("location:/"); 
}
else{?>
    
    

   
    

<!DOCTYPE html>
<html lang="es">
    <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        
        <!-- Title -->
        <title><?php echo APP_TITLE;?></title>
        <link rel="shortcut icon" type="image/x-icon" href="../admin/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Administrador de empresas" />
        <meta name="author" content="Misael Garcia" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>

 


    </head>
    <body class="body">
   <main class="mn-inner">
        <div class="row">
            <div class="col s12">
            </div>
         
               
                    
                        <form id="example-form" method="post" name="addemp">
                            <div>
                                <a href="../tutoriales" onclick=""> <i class="btn btn-warning <?php echo THEME_HEAD;?>">Regresar</i></a>
                                <section>
<div class="FUSHIA">
<h4>Iniciar Sesión / Registrar Asistencia / Revisar historial de movimientos</h4></div>                    
<iframe width="100%" height="580" src="https://www.youtube.com/embed/DPDmAzggkH8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<br><br>
<div class="FUSHIA">
<h4>Editar datos personales / Modificar Contraseña / Permisos / Historial de permisos </h4></div>                      
<iframe width="100%" height="580" src="https://www.youtube.com/embed/aA_pW6rHFz0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br>
<br><br>
<div class="FUSHIA">
<h4>Funciones extras / Desconectar / Notificaciones</h4></div>                     
<iframe width="100%" height="580" src="https://www.youtube.com/embed/-dqst3nUolw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>


                              </section>
                            </div>
                        </form>
                    
                
            
        </div>
    </main>
        
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