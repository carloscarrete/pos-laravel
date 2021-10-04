<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header("location:/admin");
}
else{
if(isset($_POST['add']))
{
$leavetype=$_POST['dia'];
$f=strftime('%d/%m',strtotime($leavetype));
$mes=substr($f,3,5);
$description=$_POST['description'];
$sql="INSERT INTO feriados(Fecha,Mes,Description) VALUES(:f,:mes,:description)";
$query = $dbh->prepare($sql);
$query->bindParam(':f',$f,PDO::PARAM_STR);
$query->bindParam(':mes',$mes,PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Fecha añadida con éxito";
}
else 
{
$error="Ocurrio un error, intentalo de nuevo";
}
}

if(isset($_GET['delete']))
{
$sql = "TRUNCATE  feriados";
$query = $dbh->prepare($sql);
$query -> execute();
header("Location:feriados");
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
                    <div class="col s12 m12 l6">
                        <div class="card">
                            <div class="card-content">
                              
                                <div class="row">
                                    <form class="col s12" name="chngpwd" method="post">
                                          <?php if($error){?><div class="errorWrap"><strong>ERROR</strong> : <?php echo htmlentities($error); ?> </div><?php } 
                else if($msg){?><div class="succWrap"><strong>Hecho</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                                        <div class="row">
                                            
<div class="input-field col s4">Fecha
<input type="date" name="dia" class="materialize-textarea" name="dia" required></input></div>
                                            

<div class="input-field col s12">
<textarea id="textarea1" name="description" class="materialize-textarea" name="description" length="100" required></textarea>
                                                <label for="deptshortname">Celebracion</label>
                                            </div>




<div class="input-field col s12">
<button type="submit" name="add" class="waves-effect waves-light btn <?php echo THEME_HEAD; ?> m-b-xs">AÑADIR</button>
</div>





                                        </div>
                                       
                                    </form>
                                </div
                            </div>
                        </div>
                        
                     
             
                   
                    </div>
                
                </div>
                <!-- Mostrar -->
<?php
if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from  feriados  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$msg="Cambio Guardado";
}
?>
<div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Dias Feriados</span>
                                <form name="delete" method="post">
                                <a href="feriados?delete" onclick="return confirm('Deseas eliminar todo el registro?');"> <i class="btn btn-warning red">RESETEAR</i></a>
                                <?php if($msg){?><div class="succWrap"><strong>Hecho</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                                <table id="example" class="display responsive-table ">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha</th>
                                            <th>Descripcion</th>
                                            <th> Fecha de creado</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                 
                                    <tbody>
<?php 
$Meses = array(null,"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$sql = "SELECT * from feriados ORDER BY Mes,Fecha ";
$query = $dbh -> prepare($sql);
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
                                            <td><?php echo htmlentities($result->Description);?></td>
                                            <td><?php echo htmlentities($result->Creado);?></td>
                                            <td><a href="feriados?del=<?php echo htmlentities($result->id);?>" onclick="return confirm('Deseas eliminarlo?');"> <i class="material-icons" style="color: <?php echo THEME_RGB; ?>">delete_forever</i></a> </td>
                                        </tr>
<?php                                        
$fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
$fecha_entrada = $result->CreationDate;
?>

                                         <?php $cnt++;} }?>
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
        <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
        <script src="../assets/js/pages/form_elements.js"></script>
        
    </body>
</html>
<?php } ?> 