<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header("location:/admin");
}
else{

 ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
        
        <!-- Title -->
        <title><?php echo APP_TITLE;?></title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Misael Garcia" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
        <link href="../assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
        
        

            
        <!-- Theme Styles -->
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
        
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
        <script>
			    $(document).ready(function(){
	    		    $("#contenido").load("h_asist_all.php");
	    		 
	    		 
				});

		</script>

    </head>
    
       <?php include('includes/header.php');?>
            
       <aside id="slide-out" class="side-nav nav fixed">
                <div class="side-nav-wrapper">
                    <div class="sidebar-profile">
                        <div class="sidebar-profile-image">
                            <img src="../assets/images/profile-image.png" class="circle" alt="">
                        </div>
                        <div class="sidebar-profile-info">
                       
                                <p>Administrador</p>

                         
                        </div>
                    </div>

            
                <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
                                        
                    <li class="no-padding">
                    <a class="waves-effect waves-grey" href="h_asist_all"><i class="material-icons">assignment_ind</i>Ver Asistencias</a></li>
                    
                    <li class="no-padding">
                    <a class="waves-effect waves-grey" href="mensaje"><i class="material-icons">rate_review</i>Mensaje Global</a></li>
                    
                    <li class="no-padding">
                    <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">apartment</i>Departamentos<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                    <div class="collapsible-body"><ul>
                    <li><a href="dep_agr"><i class="material-icons">add_circle</i>Agregar</a></li>
                    <li><a href="dep_adm"><i class="material-icons">create</i>Administrar</a></li></ul></div></li>
          
                    <li class="no-padding">
                    <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">assignment</i>Tipo de Solicitud<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                    <div class="collapsible-body"><ul>
                    <li><a href="prm_agr"><i class="material-icons">add_circle</i>Agregar</a></li>
                    <li><a href="prm_adm"><i class="material-icons">create</i>Administrar</a></li></ul></div></li>
                   
                    <li class="no-padding">
                    <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">people_alt</i>Empleados<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                    <div class="collapsible-body"><ul>
                    <li><a href="emp_agr"><i class="material-icons">person_add</i>Agregar</a></li>
                    <li><a href="emp_adm"><i class="material-icons">create</i>Administrar</a></li></ul></div></li>

                    <li class="no-padding">
                    <a class="waves-effect waves-grey" href="sls_h_all"><i class="material-icons">desktop_windows</i>Solicitudes</a></li>
                    
                    <li class="no-padding">
                    <a class="waves-effect waves-grey" href="https://help.multi-marcas.com" target="_blank"><i class="material-icons">sms</i>Chat</a></li>
                    
                    <li class="no-padding">
                    <a class="waves-effect waves-grey" href="https://email.multi-marcas.com" target="_blank"><i class="material-icons">mail</i>Correo</a></li>
                    
                    <li class="no-padding">
                    <a class="waves-effect waves-grey" href="feriados"><i class="material-icons">tag_faces</i>Feriados</a></li>
                
                    <li class="no-padding">
                    <a class="waves-effect waves-grey" href="password_adm"><i class="material-icons">https</i>Contraseñas Panel</a></li>
                    
                    <li class="no-padding">
                    <a class="waves-effect waves-grey" href="cerrar"><i class="material-icons">exit_to_app</i>Desconectar</a></li>  
                 

                 
              
                </ul>
                   <div class="footer">
                    <p class="copyright">2019<a href="http://www.multi-marcas.com/">Multi Marcas </a></p>
                    <p class="copyright"><a href="https://www.facebook.com/serv.tec.la">FACEBOOK </a></p>
                
                </div>
                </div>
            </aside>
       
       <body class="body">
            <main id="contenido">
                <div >
                    
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
        
    </body>
</html>
<?php } ?>