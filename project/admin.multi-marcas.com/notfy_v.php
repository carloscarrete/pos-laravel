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
         
            <main class="mn-inner">
                <!-- Mostrar -->
                
                
                
<?php
if(isset($_GET['conf']))
{
$id=$_GET['conf'];
$sql = "UPDATE tblpedido SET pross='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$msg="Elemento CONFIRMADO";
header("Location: notfy");
}

if(isset($_GET['deng']))
{
$id=$_GET['deng'];
$sql = "UPDATE tblpedido SET pross='2' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$msg="Elemento DENEGADO";
header("Location: notfy");
}
?>
                            
<div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">PEDIDOS NUEVOS: </span>
                                <form name="delete" method="post">
                                <table id="example" class="display responsive-table ">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cliente</th>
                                            <th>Fecha</th>
                                            <th>Marca</th>
                                            <th>Modelo</th>
                                            <th>Talla</th>
                                            <th>Color</th>
                                            <th>Estado</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                 
                                    <tbody>
<?php 
$Meses = array(null,"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$sql = "SELECT * from tblpedido WHERE conf='1' AND pross='0' AND reciv<>'1' AND entrg<>'1' ORDER BY Mes,Fecha";
$query = $dbh -> prepare($sql);
$query->bindParam(':clientno',$idc,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() == null){ ?> <div align=center><h4>NO HAY PEDIDOS NUEVOS</h4></div>     <?php }
if($query->rowCount() > 0)
{
foreach($results as $result)
{                               
                                $apnt=substr($result->Fecha,0,2);
                                ?>
                                        <tr>
                                            <td> <?php echo htmlentities($cnt);?></td>
                                            <td>
                                            <?php
                                                $noc=$result->cliente;
                                                $sql = "SELECT * from contacts WHERE id=:noc";
                                                $qcld = $dbh -> prepare($sql);
                                                $qcld->bindParam(':noc',$noc,PDO::PARAM_STR);
                                                $qcld->execute();
                                                $rcld=$qcld->fetchAll(PDO::FETCH_OBJ);
                                                if($qcld->rowCount() > 0){
                                                    foreach($rcld as $rc){
                                                        echo $rc->nombre;   
                                                    }
                                                }
                                            
                                            ?>    
                                            </td>
                                            <td><?php echo $apnt . " " . "de" . " " .  $Meses[$result->Mes]; ?></td>
                                            <td><?php echo htmlentities($result->Marca);?></td>
                                            <td><?php echo htmlentities($result->Modelo);?></td>
                                            <td><?php echo htmlentities($result->Talla);?></td>
                                            <td><?php echo htmlentities($result->Color);?></td>
                                            <td><?php
                                                if(($result->pross)==0){ ?>
                                                    <font color="green">RECIVIDO</font> 
                                                <?php } 
                                                if(($result->pross)==1){ ?>
                                                    <font color="BLUE">CONFIRMADO</font> 
                                                <?php } 
                                                if(($result->pross)==2){ ?>
                                                    <font color="RED">RECHAZADO</font> 
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a href="notfy_v?deng=<?php echo htmlentities($result->id);?>" target="ident"> <i class="material-icons" style="color: <?php echo THEME_RGB; ?>" title="RECHAZAR">block</i></a>
                                                <a href="notfy_v?conf=<?php echo htmlentities($result->id);?>" target="ident"> <i class="material-icons" style="color: <?php echo THEME_RGB; ?>" title="CONFIRMAR">send</i></a>
                                                <iframe name="ident" style="width:0;height:0;border:0; border:none;"></iframe>
                                            </td>
                                        </tr>
                                            <?php                                        
                                            $fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
                                            $fecha_entrada = $result->CreationDate;
                                            
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

    </body>
</html>
<?php } ?> 