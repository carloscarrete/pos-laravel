<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header("location:/admin");
}
else{
    
// code for Inactive  employee    
if(isset($_GET['inid']))
{
$id=$_GET['inid'];
$status=0;
$sql = "update tblemployees set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:emp_adm');
}



//code for active employee
if(isset($_GET['id']))
{
$id=$_GET['id'];
$status=1;
$sql = "update tblemployees set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:emp_adm');
}


//despedidos
if(isset($_GET['ido']))
{
$id=$_GET['ido'];
$status=2;
$sql = "update tblemployees set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:emp_adm');
}

 ?>
<!DOCTYPE html>
<html lang="es">
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
        <link href="../assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

            
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
    <body class="body">
       <?php include('includes/header.php');?>
            
       <?php include('includes/sidebar.php');?>
            <main class="mn-inner">
                <div class="row">
                    <div class="col s12">
                    </div>
                   
                    <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Informacion</span>
                                <?php if($msg){?><div class="succWrap"><strong>Hecho</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                                <table id="example" class="display responsive-table ">
                                    <thead>
                                        <tr>
                                            <th width="10"># </th>
                                            <th>Foto</th>
                                            <th>Id </th>
                                            <th width="100">Nombre completo</th>
                                            <th>Telefono</th>
                                            <th>Departamento</th>
                                             <th>Estado</th>
                                             <th>Fecha de registro</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                 
                                    <tbody>
<?php $sql = "SELECT EmpId,FirstName,LastName,Department,Status,RegDate,id,foto,Phonenumber from  tblemployees ORDER by Empid";
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
                                            <td><?php echo htmlentities($result->Phonenumber);?></td>
                                            <td><?php echo htmlentities($result->Department);?></td>
                                             <td><?php $stats=$result->Status;
if($stats==1){
                                             ?>
                                                 <a class="waves-effect waves-green btn-flat m-b-xs">Activo</a>
                                                 <?php } 
                                                 else { if($stats==0){ ?>
                                                 <a class="waves-effect waves-orange btn-flat m-b-xs">Suspendido</a>
                                                 <?php }
                                                 else {  ?>  <a class="waves-effect waves-red btn-flat m-b-xs">Despedido</a> <?php }
                                                 } ?>


                                             </td>
                                              <td><?php echo htmlentities($result->RegDate);?></td>
                                          
                                            <td>
                                            <a href="emp_edt?empid=<?php echo htmlentities($result->id);?>"><i class="material-icons" style="color: <?php echo THEME_RGB; ?>">mode_edit</i></a>
                                            
                                            <?php if($result->Status==1){?>
                                            <a href="emp_adm?inid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Suspender al usuario?');" > <i class="material-icons" title="SUSPENDER" style="color: <?php echo THEME_RGB; ?>">check_box</i><?php }
                                            else { ?><?php if($result->Status != 2){?><a href="emp_adm?id=<?php echo htmlentities($result->id);?>" onclick="return confirm('Reactivar al usuario?');"><i class="material-icons" title="REACTIVAR" style="color: <?php echo THEME_RGB; ?>">check_box_outline_blank</i> <?php }} ?> 
                                            <?php if($result->Status==1 or $result->Status==0){
                                            if($result->id != 13){if($result->id != 14){if($result->id != 15){
                                            ?>
                                            <a href="emp_adm?ido=<?php echo htmlentities($result->id);?>" onclick="return confirm('Desea despedir al usuario?\n(ACCION NO REVERSIBLE)');"> <i class="material-icons" title="DESPEDIR" style="color: <?php echo THEME_RGB; ?>">work_off</i><?php }}}}?> 
                                            
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