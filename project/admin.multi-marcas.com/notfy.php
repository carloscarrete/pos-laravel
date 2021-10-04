<?php
session_start();
error_reporting(0);
include('admin/includes/config.php');


$usuario = intval($_GET['empid']);
$sqlU = "SELECT * from contacts WHERE id=:usuario";
$quU = $dbh -> prepare($sqlU);
$quU->bindParam(':usuario',$usuario,PDO::PARAM_STR);
$quU->execute();
$resUs=$quU->fetchAll(PDO::FETCH_OBJ);
    if($quU->rowCount() > 0){  
        foreach($resUs as $resU){
            $NoCliente=$resU -> id;
        }
    }
$idc=$NoCliente;


if(strlen($_SESSION['emplogin'])==0)
    {   
    echo "<script type=''>alert('Sesion caducada, inicia nuevamente.');</script>";
    echo "<script lenguaje=\"JavaScript\">window.close();</script>";
}
else{
    

    ?>

<!DOCTYPE html>
<html lang="es">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
    <script>
			    $(document).ready(function(){
			        var refreshId =  setInterval( function(){ 
			            $("#notfy").load("notfy_v.php");
			        }, 2000 );
	    		    
				});

	</script>
    <link rel="shortcut icon" type="image/x-icon" href="admin/favicon.ico" />    
        <!-- Title -->
        <title><?php echo APP_TITLE;?></title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Misael Garcia" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>
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
                            <div id="notfy"></div>
                          
           

        </div>
        <div class="left-sidebar-hover"></div>
        
        
                   
        
        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/js/alpha.min.js"></script>
        <script src="assets/js/pages/form_elements.js"></script>
        <script src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/pages/table-data.js"></script>
        
    </body>
</html>
<?php } ?> 