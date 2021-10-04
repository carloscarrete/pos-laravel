<?php
session_start();
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
error_reporting(0);
include('admin/includes/config.php');

$usuario =  intval($_GET['empid']);
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
            <main class="mn-inner">
                <!-- Mostrar -->
                            <div class="card-content">
                                <div align="right">
                                    <a href="client_ctl?empid=<?php echo htmlentities($usuario);?>"> <i class="btn btn-warning cyan">CATALOGOS</i></a>
                                </div>
                                <a href="client_art_h?empid=<?php echo htmlentities($usuario);?>"> <i class="btn btn-warning red">HISTORIAL</i></a>
                                <a href="client_art_rec?empid=<?php echo htmlentities($usuario);?>"> <i class="btn btn-warning red">EN TIENDA</i></a>
                                <a href="client_art?empid=<?php echo htmlentities($usuario);?>"> <i class="btn btn-warning red">PEDIDOS</i></a>
                                <a href="client_art_conf?empid=<?php echo htmlentities($usuario);?>"> <i class="btn btn-warning red">EN PROCESO</i></a>
                                <a href="client_art_ent?empid=<?php echo htmlentities($usuario);?>"> <i class="btn btn-warning red">ENTREGADOS</i></a>
                                <a href="client_art_den?empid=<?php echo htmlentities($usuario);?>"> <i class="btn btn-warning red">RECHAZADOS</i></a>
                            </div>
<div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Afiliaciones del cliente: </span>
                                <form name="delete" method="post">
                                <table id="example" class="display responsive-table ">
                                    <thead>
                                        <tr>
                                            <td><img title="CKLASS" src="logos/cklass.png" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="CASTALIA" src="logos/castalia.jpg" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="TERRA" src="logos/terra.png" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="ONENA" src="logos/onena.jpg" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="RINNA BRUNNI" src="logos/rinnabruni.png" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="PRICE SHOES" src="logos/price_shoes.png" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="FARELLI" src="logos/farelli.jpg" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="ANDREA" src="logos/andrea.jpg" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="CICLON" src="logos/ciclon.jpg" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="JENNIFER" src="logos/jennifer_lo.png" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="LIS" src="logos/lis.jpg" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="WEST" src="logos/wwear.jpg" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="MODA CLUB" src="logos/modaclub.png" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="VEROCHI" src="logos/verochi.jpg" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="INCOGNITA" src="logos/incognita.jpg" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="ILUSION" src="logos/ilusion.png" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="STOP" src="logos/stop.png" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="DEVENDI" src="logos/devendi.jpg" class="box" alt="" width="30" height="30"></td>
                                            <td><img title="IMPULSS" src="logos/impuls.png" class="box" alt="" width="30" height="30"></td>
                                        </tr>
                                    </thead>
                                 
                                    <tbody>
<?php 
$sql = "SELECT * from contacts WHERE id=:clientno";
$query = $dbh -> prepare($sql);
$query->bindParam(':clientno',$idc,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{                               
                                ?>
                                        <tr>
                                            <td>
                                                <?php if(($result->Cklass)==1) {?>
                                                    <a href="mod_ctl?dck=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?ack=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->Castalia)==1) {?>
                                                    <a href="mod_ctl?dc=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?ac=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->Terra)==1) {?>
                                                    <a href="mod_ctl?dt=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?at=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->Onena)==1) {?>
                                                    <a href="mod_ctl?do=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?ao=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->RinnaB)==1) {?>
                                                    <a href="mod_ctl?dr=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?ar=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->PSh)==1) {?>
                                                    <a href="mod_ctl?dp=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?ap=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->Fareli)==1) {?>
                                                    <a href="mod_ctl?df=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?af=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->Andrea)==1) {?>
                                                    <a href="mod_ctl?da=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?aa=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->Ciclon)==1) {?>
                                                    <a href="mod_ctl?dcl=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?acl=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->Jenifer)==1) {?>
                                                    <a href="mod_ctl?dj=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?aj=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->Lis)==1) {?>
                                                    <a href="mod_ctl?dl=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?al=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->West)==1) {?>
                                                    <a href="mod_ctl?dw=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?aw=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->ModC)==1) {?>
                                                    <a href="mod_ctl?dm=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?am=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->Verochi)==1) {?>
                                                    <a href="mod_ctl?dv=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?av=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->Incognita)==1) {?>
                                                    <a href="mod_ctl?din=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?ain=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->Ilusion)==1) {?>
                                                    <a href="mod_ctl?dil=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?ail=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->Stop)==1) {?>
                                                    <a href="mod_ctl?ds=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?as=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->Devendi)==1) {?>
                                                    <a href="mod_ctl?dd=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?ad=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if(($result->Impulss)==1) {?>
                                                    <a href="mod_ctl?dim=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="DESACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box</i>
                                                <?php } else {?>
                                                    <a href="mod_ctl?aim=<?php echo htmlentities($result->id);?>"> <i class="material-icons" title="ACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i>
                                                <?php }?>
                                            </td>
                                            
                                        </tr>
                                            <?php                                        
                                            
                                            $cnt++;} }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
<!-- FIN Mostrar --> 
            </main>

        </div>
        <div class="left-sidebar-hover"></div>
        
        
                   
        
        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/js/alpha.min.js"></script>
        <script src="assets/js/pages/form_elements.js"></script>
        
    </body>
</html>
<?php } ?> 