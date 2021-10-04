<?php
session_start();
error_reporting(0);
include('admin/includes/config.php');
if(strlen($_SESSION['emplogin'])==0)
    {   
header("location:/"); 
}
else{?>
    
    

   
    

<!DOCTYPE html>
<html lang="es">
    <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        
        <!-- Title -->
        <title><?php echo APP_TITLE; ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="admin/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Administrador de empresas" />
        <meta name="author" content="Misael Garcia" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>

 


    </head>
    <body class="body">
  <?php include('includes/header.php');?>
            
       <?php include('includes/sidebar.php');?>
   <main class="mn-inner">
        <div class="row">
            <div class="col s12">
            </div>
            <div class="col s12 m12 l8">
                <div class="card">
                    <div class="card-content">
                        <form id="example-form" method="post" name="addemp">
                            <div>
                                <td><?php echo "Bienvenido: &nbsp"; echo htmlentities($result->FirstName);?>&nbsp;<?php echo htmlentities($result->LastName);?></td><br>
                                <section>

<h4>Video introductorio</h4>                    
<iframe width="100%" height="435" src="https://www.youtube.com/embed/0MUGfbKpVYQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<br>
<h5>Secciones disponibles: </h5>
<a href="tutorial/pda" title= "Panel de Administracion"><img border="0" alt="W3Schools" src="assets/images/vh_admin.png" width="155" height="155"></a>
<a href="tutoriales" title= "Chat Multi Marcas"><img border="0" alt="W3Schools" src="assets/images/vh_chat.png" width="155" height="155"></a>
<a href="tutoriales" title= "Correo Multi Marcas"><img border="0" alt="W3Schools" src="assets/images/vh_correo.png" width="155" height="155"></a>
<a href="tutoriales" title= "Puntos de Venta"><img border="0" alt="W3Schools" src="assets/images/vh_ventas.png" width="155" height="155"></a>
<h6>Si no sabes a que corresponde cada imagen, solo deja el cursor en sima y aparecera el nombre. </h6>


                              </section>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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