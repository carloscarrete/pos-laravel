<?php
$msg="";
error_reporting(0);
include('../conect.php');
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");

$location=$_POST["loc_p"];
$SKU=$_POST["sku"];
$TODAY=date("d-m-Y");



$ready = "SELECT * from auditorias WHERE sku=:sku_rdy and fecha=:today and id_location=:locate and type='ct'";
$qyRead = $dbP -> prepare($ready);
$qyRead->bindParam(':sku_rdy',$SKU,PDO::PARAM_STR);
$qyRead->bindParam(':today',$TODAY,PDO::PARAM_STR);
$qyRead->bindParam(':locate',$location,PDO::PARAM_STR);
$qyRead->execute();
$READL=$qyRead->fetchAll(PDO::FETCH_OBJ);
if($qyRead->rowCount() > 0){  
    foreach($READL as $Rdy){
        $ID = $Rdy->id;
        $FECHA = $Rdy->fecha;
        $dif=$Rdy->diferencia;
    }
}
if($ID){echo "<script type=''>alert('Vas a editar un producto auditado $FECHA');</script>";}


$locatn = "SELECT * from business_locations WHERE id=:location";
$qyLoc = $dbP -> prepare($locatn);
$qyLoc->bindParam(':location',$location,PDO::PARAM_STR);
$qyLoc->execute();
$resLoc=$qyLoc->fetchAll(PDO::FETCH_OBJ);
if($qyLoc->rowCount() > 0){  
    foreach($resLoc as $RL){
        $nameLoc = $RL->name;
    }
}
$bussines_location = $nameLoc;

?>
<!DOCTYPE html>
<html lang="es">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />    
        <!-- Title -->
        
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
        
    </head>
    <body >
            <main class="mn-inner"
                    <div class="col s12">
                    </div>
                                <div class="card-content">
                                
                    <div class="col s12 m12 l6">
                        <div class="card">
                            <div class="card-content">                  
                                <div class="row">
                                
                                    <form class="col s12" name="chngpwd" method="post" action="locate_c_control.php" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="input-field col s2">SKU:
                                                <input readonly id="sku" name="sku" class="materialize-textarea" type="text" value="<?php echo $_POST["sku"];?>" required />
                                            </div>
                                            <div class="input-field col s2">FECHA:
                                                <input readonly name="fecha" class="materialize-textarea"  type="text" value="<?php echo date("d-m-Y");?>" required />
                                            </div>
                                            <div class="input-field col s2">Ubicacion:
                                                <input readonly name="location" class="materialize-textarea"  type="text" value="<?php echo $bussines_location;?>" required />
                                                <input readonly name="number" hidden="true" class="materialize-textarea"  type="text" value="<?php echo $location;?>" required />
                                            </div>
                                            <div class="input-field col s2">AUDITOR:
                                                <input readonly name="admin" class="materialize-textarea"  type="text" value="<?php echo $_POST["admin"];?>" required />
                                            </div>
                                            <div class="input-field col s2"></div>
                                            
                                            
                                            <div class="input-field col s1">
                                                <button type="submit" name="add" class="waves-effect waves-light btn <?php echo THEME_HEAD; ?> m-b-xs">AGREGAR</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <hr/>
                                                <table id="example" class="display responsive-table ">
                                                    <thead>
                                                        <tr>
                                                            <th width="200">SKU</th>
                                                            <th width="400">PRODUCTO</th>
                                                            <th width="200">SISTEMA</th>
                                                            <th width="200">REAL</th>
                                                            <th >.IMG</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                                    <tr>
                                                    
                                                    <?php
                                                    $i=0;
                                                    $BAR_2 = "SELECT * from variations WHERE sub_sku=:sub_sku";
                                                    $QyBar_2 = $dbP -> prepare($BAR_2);
                                                    $QyBar_2->bindParam(':sub_sku',$SKU,PDO::PARAM_STR);
                                                    $QyBar_2->execute();
                                                    $RsBar_2=$QyBar_2->fetchAll(PDO::FETCH_OBJ);
                                                    if($QyBar_2->rowCount()){
                                                    if($QyBar_2->rowCount() > 0){  
                                                        foreach($RsBar_2 as $RB_2){
                                                            echo "<td>" . $RB_2 ->sub_sku;
                                                            $P_ID=$RB_2 ->product_id; ?>
                                                                <div class="input-field hidden">
                                                                    <input name="idp" class="materialize-textarea"  type="text" value="<?php echo $P_ID; ?>" readonly required />
                                                                </div>
                                                            </td>  
                                                            <?php
                                                            echo "<td>";
                                                            $BAR_3 = "SELECT * from products WHERE id=:P_id";
                                                            $QyBar_3 = $dbP -> prepare($BAR_3);
                                                            $QyBar_3->bindParam(':P_id',$P_ID,PDO::PARAM_STR);
                                                            $QyBar_3->execute();
                                                            $RsBar_3=$QyBar_3->fetchAll(PDO::FETCH_OBJ);
                                                            if($QyBar_3->rowCount() > 0){  
                                                                foreach($RsBar_3 as $RB_3){
                                                                    $Mstock = $RB_3 ->enable_stock;
                                                                     $nom = $RB_3 ->name;
                                                                     $imagen = $RB_3 ->image;
                                                                     if(!$imagen){$imagen='default.png';}
                                                                     echo $nom;
                                                                    ?>
                                                                
                                                                    <div class="input-field hidden">
                                                                        <input name="name" class="materialize-textarea" hidden="true" type="text" value="<?php echo $nom; ?>" readonly required />
                                                                    </div>
                                                                <?php
                                                                }
                                                            }
                                                            echo "</td>";
                                                            $i++;
                                                        }
                                                    }   $BAR = "SELECT * from variation_location_details WHERE variation_id=:P_id and location_id=:loc";
                                                        $QyBar = $dbP -> prepare($BAR);
                                                        $QyBar->bindParam(':P_id',$P_ID,PDO::PARAM_STR);
                                                        $QyBar->bindParam(':loc',$location,PDO::PARAM_STR);
                                                        $QyBar->execute();
                                                        $RsBar=$QyBar->fetchAll(PDO::FETCH_OBJ);
                                                        $total_row = $QyBar->rowCount();
                                                        $cant=0;
                                                        echo "<td>";
                                                        if($QyBar->rowCount() > 0){  
                                                            foreach($RsBar as $RB){
                                                                $cant = number_format($RB ->qty_available);
                                                                echo "<div align='center'>$cant</div>";?>
                                                                
                                                                <div class="input-field hidden">
                                                                    <input name="qty" class="materialize-textarea"  type="text" value="<?php echo $cant; ?>" readonly required />
                                                                </div>
                                                                <?php
                                                            }
                                                        } 
                                                        ?> 
                                                        </td>
                                                        <td>
                                                           <?php if($ID){?><lavel><?php $res= $cant-$dif; echo "Anterior Respuesta= ".$res; ?></lavel><?php }?>
                                                        <div class="input-field ">
                                                            <input name="rly" autofocus valign="top"class="materialize-textarea" maxlength='4' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  type="text-area" placeholder="<?php echo $cant; ?>" required />
                                                        </div></td>
                                                    
                                                    
                                                    <td>
                                                        <img src="../../uploads/img/<?php echo $imagen;?>"
                                                            width="150"
                                                            height="150">
                                                            </td>
                                                    </tr>
                                                    <?php }
                                                    else{echo "<td colspan='5'><h1>No se encontro producto</h1></td>";}?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <style>
                                                .hidden{
                                                    visibility: hidden;
                                                    height: 0px;
                                                    width: 0px;
                                                }
                                            </style>
                                            
                                            
                                            
                                        </div>
                                            

                                            
                                       
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                     
             
                   
                    </div>
                
            </main>

        </div>
        <div class="left-sidebar-hover"></div>
        
        
    </body>
</html>