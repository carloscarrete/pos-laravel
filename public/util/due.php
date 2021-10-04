<?php
error_reporting(0);
include('conect.php');
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");

$code=$_POST["code"];
$empid=$_POST["empid"];

$BAR = "SELECT * from transactions WHERE invoice_no=:invoice";
$QyBar = $dbP -> prepare($BAR);
$QyBar->bindParam(':invoice',$code,PDO::PARAM_STR);
$QyBar->execute();
$RsBar=$QyBar->fetchAll(PDO::FETCH_OBJ);
if($QyBar->rowCount() > 0){  
    foreach($RsBar as $RB){
        $cod_inv = $RB->invoice_no;
        $t_id = $RB->id;
        $data_sell = $RB->created_at;
        $bsns=$RB->business_id;
        $lctn=$RB->location_id;
        $cntct=$RB->contact_id;
    }
}
else{
    $cod_inv = "No encontrado";
}
$bussines=$bsns;
$location=$lctn;
$contacto=$cntct;

$Transaction = $t_id;
$DataSTR = substr($data_sell,0,10);
$DataNMB = strtotime($DataSTR);
$Data = date('d/m/Y',$DataNMB);
$TodayIS=date('Y-m-d h:i:s');
$vence = strtotime ( '+30 day' , $DataNMB ); 
$vence= date ( 'd-m-Y' , $vence );

//Ubicación comercial.
$locatn = "SELECT * from business_locations WHERE id=:location AND business_id=:business";
$qyLoc = $dbP -> prepare($locatn);
$qyLoc->bindParam(':location',$location,PDO::PARAM_STR);
$qyLoc->bindParam(':business',$bussines,PDO::PARAM_STR);
$qyLoc->execute();
$resLoc=$qyLoc->fetchAll(PDO::FETCH_OBJ);
if($qyLoc->rowCount() > 0){  
    foreach($resLoc as $RL){
        $nameLoc = $RL->name;
    }
}
$bussines_location = $nameLoc;

$empid = base64_decode($empid);
//Caja.
$loc_User = "SELECT * from cash_registers WHERE user_id=:usuario AND status='open' AND business_id=:buss_id";
$qyUser = $dbP -> prepare($loc_User);
$qyUser->bindParam(':usuario',$empid,PDO::PARAM_STR);
$qyUser->bindParam(':buss_id',$bussines,PDO::PARAM_STR);
$qyUser->execute();
$resUser=$qyUser->fetchAll(PDO::FETCH_OBJ);
if($qyUser->rowCount() > 0){  
    foreach($resUser as $RU){
        $CashId = $RU->id;
    }
}
$register_cash = $CashId;

//Contacto.
$locateCnt = "SELECT * from contacts WHERE id=:contacto";
$qyCnt = $dbP -> prepare($locateCnt);
$qyCnt->bindParam(':contacto',$contacto,PDO::PARAM_STR);
$qyCnt->execute();
$resCnt=$qyCnt->fetchAll(PDO::FETCH_OBJ);
if($qyCnt->rowCount() > 0){  
    foreach($resCnt as $RC){
        $nombreCnt = $RC->name;
    }
}
$contact_name = $nombreCnt;

//Empresa.
$locateCnt = "SELECT * from business WHERE id=:business";
$qyBss = $dbP -> prepare($locateCnt);
$qyBss->bindParam(':business',$bussines,PDO::PARAM_STR);
$qyBss->execute();
$resBss=$qyBss->fetchAll(PDO::FETCH_OBJ);
if($qyBss->rowCount() > 0){  
    foreach($resBss as $RB){
        $empresa = $RB->name;
    }
}
$business_name = $empresa;

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
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>
        
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
                                    <form class="col s12" name="chngpwd" method="post" action="due_control.php" enctype="multipart/form-data" target="hide">
                                        <div class="row">
                                            
                                            <div class="input-field hidden">
                                                <input readonly  name="referencia" class="materialize-textarea" type="text" value="<?php echo $code;?>" required />
                                            </div>
                                            <div class="input-field hidden">
                                                <input readonly  name="cashreg" class="materialize-textarea" type="text" value="<?php echo $register_cash;?>" required />
                                            </div>
                                            <div class="input-field hidden">
                                                <input readonly  name="datasell" class="materialize-textarea" type="text" value="<?php echo $data_sell;?>" required />
                                            </div>
                                            <div class="input-field hidden">
                                                <input readonly name="trnid" class="materialize-textarea" type="text" value="<?php echo $Transaction;?>" required />
                                            </div>
                                            <div class="input-field col s2">SKU:
                                                <input readonly id="res" name="sku" class="materialize-textarea" type="text" value="<?php echo $cod_inv;?>" required />
                                            </div>
                                            <div class="input-field col s2">FECHA:
                                                <input readonly name="fecha" class="materialize-textarea"  type="text" value="<?php echo $Data;?>" required />
                                            </div>
                                            <div class="input-field col s2">Vence:
                                                <input readonly name="vence" class="materialize-textarea"  type="text" value="<?php echo $vence;?>" required />
                                            </div>
                                            <div class="input-field col s2">Ubicación:
                                                <input readonly name="location" class="materialize-textarea"  type="text" value="<?php echo $bussines_location;?>" required />
                                            </div>
                                            <div class="input-field col s4">Cliente:
                                                <input readonly name="contact" class="materialize-textarea"  type="text" value="<?php echo $contact_name;?>" required />
                                            </div>
                                            
                                            <div class="input-field col s12"></div>
                                            <p style="height: 0%; width:0%"> <input class="texto" name="locate" value="<?php echo $idArt;?>" readonly required></input></p>
                                            <div class="input-field col s12">
                                                <hr/>
                                                <table id="example" class="display responsive-table ">
                                                    <thead>
                                                        <tr>
                                                            <th width="50">#</th>
                                                            <th width="200">SKU</th>
                                                            <th width="400">PRODUCTO</th>
                                                            <th>PRECIO</th>
                                                            <th>CANTIDAD</th>
                                                            <th>DEVUELTOS</th>
                                                            <th width="100">DEVOLVER</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                    
                                            
                                            <?php
                                            $i=1;
                                            $BAR = "SELECT * from transaction_sell_lines WHERE transaction_id=:tr_id";
                                            $QyBar = $dbP -> prepare($BAR);
                                            $QyBar->bindParam(':tr_id',$Transaction,PDO::PARAM_STR);
                                            $QyBar->execute();
                                            $RsBar=$QyBar->fetchAll(PDO::FETCH_OBJ);
                                            $total_row = $QyBar->rowCount();
                                            if($QyBar->rowCount() > 0){  
                                                foreach($RsBar as $RB){
                                                    
                                                    echo "<td> $i</td>"  ;
                                                    $id_prd=$RB ->variation_id; ?>
                                                    <div class="input-field hidden">
                                                        <input name="idv<?php echo $i; ?>" class="materialize-textarea"  type="text" value="<?php echo $id_prd; ?>" readonly required />
                                                    </div>
                                                    
                                                    <?php
                                                    $BAR_2 = "SELECT * from variations WHERE id=:pr_id";
                                                    $QyBar_2 = $dbP -> prepare($BAR_2);
                                                    $QyBar_2->bindParam(':pr_id',$id_prd,PDO::PARAM_STR);
                                                    $QyBar_2->execute();
                                                    $RsBar_2=$QyBar_2->fetchAll(PDO::FETCH_OBJ);
                                                    if($QyBar_2->rowCount() > 0){  
                                                        foreach($RsBar_2 as $RB_2){
                                                            echo "<td>" . $RB_2 ->sub_sku . "</td>"  ;
                                                            echo "<td>";
                                                            $P_ID=$RB_2 ->product_id; ?>
                                                                <div class="input-field hidden">
                                                                    <input name="idp<?php echo $i; ?>" class="materialize-textarea"  type="text" value="<?php echo $P_ID; ?>" readonly required />
                                                                </div>
                                                            
                                                            <?php    
                                                            $BAR_3 = "SELECT * from products WHERE id=:P_id";
                                                            $QyBar_3 = $dbP -> prepare($BAR_3);
                                                            $QyBar_3->bindParam(':P_id',$P_ID,PDO::PARAM_STR);
                                                            $QyBar_3->execute();
                                                            $RsBar_3=$QyBar_3->fetchAll(PDO::FETCH_OBJ);
                                                            if($QyBar_3->rowCount() > 0){  
                                                                foreach($RsBar_3 as $RB_3){
                                                                    $Mstock = $RB_3 ->enable_stock;
                                                                    echo $RB_3 ->name;  
                                                                    $names =$RB_3 ->name; 
                                                                }
                                                            }
                                                            echo "</td>";
                                                            $en_dc[$i] = $Mstock;
                                                            $name[$i] = $names;?>
                                                            <div class="input-field hidden">
                                                                    <input name="MST<?php echo $i; ?>" class="materialize-textarea"  type="text" value="<?php echo $name[$i]; ?>" readonly required />
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    $fix="fixed";
                                                    $type_d=$RB ->line_discount_type;
                                                    if ($type_d==$fix){$sell_price=$RB ->unit_price_inc_tax;}
                                                    else{$sell_price=$RB ->unit_price;}?>
                                                    <td>
                                                        <div class="input-field col s6">
                                                            <input name="mxn<?php echo $i; ?>" class="materialize-textarea"  type="text" value="<?php echo $sell_price; ?>" readonly required />
                                                        </div>
                                                    </td>
                                                    <?php
                                                    $PriceRow[$i]=$sell_price;
                                                    
                                                    $cant = number_format($RB ->quantity);
                                                    echo "<td><div align='center'>$cant</div></td>";
                                                    $cantDue = number_format($RB ->quantity_returned);
                                                    echo "<td><div align='center'>$cantDue</div></td>";
                                                    $rest=$cant-$cantDue; ?>
                                                    
                                                        <div class="input-field hidden">
                                                                <input name="dcsn<?php echo $i; ?>" class="materialize-textarea"  type="text" value="<?php echo $en_dc[$i]; ?>" readonly required />
                                                        </div>
                                                        
                                                    <td>
                                                        <?php if($rest>0){?>
                                                        <div class="input-field">Cantidad:
                                                            <input max="<?php echo $rest; ?>" min="0" name="dqty<?php echo $i; ?>" class="materialize-textarea"  type="number" value="0" required />
                                                        </div>
                                                        <?php } 
                                                        else {?>
                                                            <h6><font color="orange"><b>DEVUELTO</b></font></h6>
                                                        <?php } ?>
                                                        
                                                    </td>
                                                    <?php 
                                                    echo "</tr>";
                                                    $i++;
                                                }
                                            }
                                            ?>          
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
                                            
                                            <div class="input-field hidden">
                                                <input readonly name="emp_id" class="materialize-textarea" length="30" type="text" value="<?php echo $empid;?>" required />
                                            </div>
                                            <div class="input-field hidden">
                                                <input readonly name="contID" class="materialize-textarea" length="30" type="text" value="<?php echo $contacto;?>" required />
                                            </div>
                                            <div class="input-field hidden">
                                                <input readonly name="loction" class="materialize-textarea" length="30" type="text" value="<?php echo $location;?>" required />
                                            </div>
                                            <div class="input-field hidden">
                                                <input readonly name="bussines" class="materialize-textarea" length="30" type="text" value="<?php echo $bussines;?>" required />
                                            </div>
                                            <div class="input-field hidden">
                                                <input readonly name="rows" class="materialize-textarea" length="30" type="text" value="<?php echo $total_row;?>" required />
                                            </div>
                                            
                                            
                                            <div class="input-field col s8"></div>
                                            <div class="input-field col s2 hidden">
                                                    <input name="pass" class="materialize-textarea" type="password" placeholder="NIP" value="000000"  maxlength="10"/>
                                            </div>
                                            <div class="input-field col s1">
                                                <button type="submit" name="add" class="waves-effect waves-light btn <?php echo THEME_HEAD; ?> m-b-xs">AÑADIR</button>
                                            </div>
                                            
                                        </div>
                                            

                                            
                                       
                                    </form>
                                     <div class="input-field col s1">
                                        <iframe name="hide" style="width:0px;height:0px;border:none; "></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                     
             
                   
                    </div>
                
            </main>

        </div>
        <div class="left-sidebar-hover"></div>
        
        
    </body>
</html>