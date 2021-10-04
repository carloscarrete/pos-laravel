<?php
session_start();
error_reporting(0);
include('../includes/config.php');

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

if(strlen($_SESSION['alogin'])==0)
    {   
    echo "<script type=''>alert('Sesion caducada, inicia nuevamente.');</script>";
    echo "<script lenguaje=\"JavaScript\">window.close();</script>";
}
else{
    


    ?>

<!DOCTYPE html>
<html lang="es">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />    
        <!-- Title -->
        <title><?php echo APP_TITLE;?></title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Misael Garcia" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../../assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
        <link href="../../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/css/custom.css" rel="stylesheet" type="text/css"/>
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
                            <div class="card-content">
                                <div align="right">
                                    <a href="client_ctl?empid=<?php echo htmlentities($usuario);?>"> <i class="btn btn-warning blue">CATALOGOS</i></a>
                                </div>
                                <a href="client_art_h?empid=<?php echo htmlentities($usuario);?>"> <i class="btn btn-warning orange">HISTORIAL</i></a>
                                <a href="client_art_rec?empid=<?php echo htmlentities($usuario);?>"> <i class="btn btn-warning red">EN TIENDA</i></a>
                                <a href="client_art?empid=<?php echo htmlentities($usuario);?>"> <i class="btn btn-warning red">PEDIDOS</i></a>
                                <a href="client_art_conf?empid=<?php echo htmlentities($usuario);?>"> <i class="btn btn-warning red">EN PROCESO</i></a>
                                <a href="client_art_ent?empid=<?php echo htmlentities($usuario);?>"> <i class="btn btn-warning red">ENTREGADOS</i></a>
                                <a href="client_art_den?empid=<?php echo htmlentities($usuario);?>"> <i class="btn btn-warning red">RECHAZADOS</i></a>
                            </div>
                <!-- Mostrar -->


<div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">TODOS LOS PEDIDOS: </span>
                                <form name="delete" method="post">
                                <table id="example" class="display responsive-table ">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha</th>
                                            <th>Marca</th>
                                            <th>Modelo</th>
                                            <th>Talla</th>
                                            <th>Color</th>
                                            <th>Historia</th>
                                            <th>Comentarios</th>
                                        </tr>
                                    </thead>
                                 
                                    <tbody>
<?php 
$Meses = array(null,"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$sql = "SELECT * from tblpedido WHERE cliente=:clientno AND conf<>'0' ORDER BY Mes,Fecha";
$query = $dbh -> prepare($sql);
$query->bindParam(':clientno',$idc,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{                               
                                $apnt=substr($result->Fecha,0,2);
                                ?>
                                        <tr>
                                            <td> <?php echo htmlentities($cnt);?></td>
                                            <td><?php echo $apnt . " " . "de" . " " .  $Meses[$result->Mes]; ?></td>
                                            <td><?php echo htmlentities($result->Marca);?></td>
                                            <td><?php echo htmlentities($result->Modelo);?></td>
                                            <td><?php echo htmlentities($result->Talla);?></td>
                                            <td><?php echo htmlentities($result->Color);?></td>
                                            <td><?php
                                                
                                                if(($result->conf)==1){ ?>
                                                    <font color="GREEN">RECIVIDO</font>-> 
                                                <?php }
                                                if(($result->pross)==1){ ?>
                                                    <font color="BLUE">CONFIRMADO</font>-> 
                                                <?php }
                                                if(($result->pross)==2){ ?>
                                                    <font color="RED">RECHAZADO</font> 
                                                <?php }  
                                                if(($result->reciv)==1){ ?>
                                                    <font color="ORANGE">EN TIENDA</font>-> 
                                                <?php }
                                                if(($result->entrg)==1){ ?>
                                                    <font color="GRAY">ENTREGADO</font>
                                                <?php }?>
                                                
                                            </td>
                                            <td><?php echo htmlentities($result->cmts);?></td>
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
        <script src="../../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../../assets/js/alpha.min.js"></script>
        <script src="../../assets/js/pages/form_elements.js"></script>
        <script src="../../assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../../assets/js/pages/table-data.js"></script>
        
    </body>
</html>
<?php } ?> 