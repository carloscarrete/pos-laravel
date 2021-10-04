<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header("location:/admin");
}
else{
//Reset all
if(isset($_GET['daus']))
{
$sql = "TRUNCATE  tblogin";
$query = $dbh->prepare($sql);
$query -> execute();
header("Location:h_asist_all");
}


//desactivar a todos  
if(isset($_GET['sall']))
{
$status=0;
$sql = "update tblemployees set Status=:status  WHERE Status!=2 AND id!=13";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:h_asist_all');
}

//reactivar a todos  
if(isset($_GET['rall']))
{
$status=1;
$sql = "update tblemployees set Status=:status  WHERE Status!=2 AND id!=13";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:h_asist_all');
}


//suspender un empleado
if(isset($_GET['inid']))
{
$id=$_GET['inid'];
$status=0;
$sql = "update tblemployees set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:h_asist_all');


}



//reactivar un empleado
if(isset($_GET['idre']))
{
$id=$_GET['idre'];
$status=1;
$sql = "update tblemployees set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:h_asist_all');


}

//reactivar un empleado
if(isset($_GET['idpss']))
{
$id=$_GET['idpss'];

$status=1;
$sql = "update tblemployees set Status=:status, count=2 WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:h_asist_all');


}
 ?>
<!DOCTYPE html>
<html lang="es">
    <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
    
       <?php include('includes/header.php');?>
            
       <?php include('includes/sidebar.php');?>
       
       <body class="body">
            <main class="mn-inner">
                <div class="row">
                    <div class="col s12"><br><br>
                        <a href="h_asist_all?rall" onclick=""> <i class="btn btn-warning green">ACTIVAR A TODOS</i></a>
                        <a href="h_asist_all?sall" onclick="return confirm('Estas suspendiendo a todos');"> <i class="btn btn-warning orange">SUSPENDER A TODOS</i></a>
                        <a href="h_asist_all?daus" onclick="return confirm('Deseas eliminar todo el registro?');"> <i class="btn btn-warning red">RESETEAR A TODOS</i></a>
                                
                                
                    </div>
                   
                    <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Informacion detallada</span>
                                
                               
                                <?php if($msg){?><div class="succWrap"><strong>Hecho</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                                <table id="example" class="display responsive-table ">
                                    <thead>
                                        <tr>
                                            <th># </th>
                                            <th>Foto </th>
                                            <th>Id </th>
                                            <th>Nombre completo</th>
                                            <th>Departamento</th>
                                             <th>Estado</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                 
                                    <tbody>
<?php $sql = "SELECT * from  tblemployees WHERE Status<>2 ORDER BY Empid";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
                                        <tr>
                                            <?php $ruta_imagen=$result->foto;?>
                                            <td> <?php echo htmlentities($cnt);?></td>
                                            <td><img src="../admin/upload/Fotos/<?php echo htmlentities($ruta_imagen);?>" class="box" alt="" width="70" height="70"></td>
                                            <td><?php echo htmlentities($result->EmpId);?></td>
                                            <td><?php echo htmlentities($result->FirstName);?>&nbsp;<?php echo htmlentities($result->LastName);?></td>
                                            <td><?php echo htmlentities($result->Department);?></td>
                                             <td><?php $stats=$result->Status;
                                                
                                                if($stats==1){?>
                                                    <a href="h_asist_all?inid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Suspender al usuario?');" title="SUSPENDER" class="waves-effect waves-green btn-flat m-b-xs">Activo</a><?php
                                                } 
                                                 else { 
                                                    if($result->Status != 2){ 
                                                        if($result->count>=3){?>
                                                            <a href="h_asist_all?idpss=<?php echo htmlentities($result->id);?>" onclick="return confirm('El usuario fue suspendido por razones de seguridad, esta accion solo le dara un inicio de sesion para que actualize su contraseña');" title="QUITAR BLOQUEO" class="waves-effect waves-orange btn-flat m-b-xs">BLOQUEADO</a><?php
                                                        }
                                                        else {?>
                                                            <a href="h_asist_all?idre=<?php echo htmlentities($result->id);?>" onclick="return confirm('Reactivar al usuario?');" class="waves-effect waves-orange btn-flat m-b-xs" title="REACTIVAR">SUSPENDIDO</a> <?php 
                                                        }    
                                                    }
                                                } 
                                                ?>

                                             </td>
                                            
                                            <td>
                                            <a href="h_asist?empid=<?php echo htmlentities($result->id);?>" target="popup"
                                                onClick="window.open(this.href, this.target, 'toolbar=1 , location=1 , status=0 , menubar=0 , scrollbars=1 , resizable=0 ,left=200pt,top=150pt,width=1100px,height=550'); return true;"><i class="btn btn-warning <?php echo THEME_HEAD; ?>" title="REVISAR ENTRADAS Y HORARIOS"><i class="material-icons" style="color:white">timer </i> REVISAR <i class="material-icons" style="color:white"> timer </i></i></a>
                                            </td>
                                           
                                        </tr>
                                         <?php $cnt++;} }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
         
        </div>
        <div class="left-sidebar-hover"></div>
        
        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
        <script src="../assets/js/pages/table-data.js"></script>
        
    </body>
</html>
<?php } ?>