<?php
  error_reporting(0);
include('../conect.php');
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
    $auditor=$_POST["admin"];
    $location=$_POST["number"];
    $producto=$_POST["name"];
    $sku=$_POST["sku"];
    $psh=$_POST["pshp"];
    $id_var=$_POST["idp"];
    $cantidad=$_POST["qty"];
    $auditado=$_POST["rly"];
    $diferencia=$auditado-$cantidad;
    $fecha=date("d-m-Y");
    
    $athInsert="INSERT INTO 
        auditorias(fecha, auditor, id_location, producto, diferencia, sku, id_variation, type, rly, temp)
        values(:fecha, :auditor, :number, :prd, :dif, :sku, :idp, 'p',  :auth, :temp)";
    $QyCsh = $dbP -> prepare($athInsert);
    $QyCsh->bindParam(':fecha',$fecha,PDO::PARAM_STR);
    $QyCsh->bindParam(':auditor',$auditor,PDO::PARAM_STR);
    $QyCsh->bindParam(':number',$location,PDO::PARAM_STR);
    $QyCsh->bindParam(':prd',$producto,PDO::PARAM_STR);
    $QyCsh->bindParam(':dif',$diferencia,PDO::PARAM_STR);
    $QyCsh->bindParam(':sku',$sku,PDO::PARAM_STR);
    $QyCsh->bindParam(':idp',$id_var,PDO::PARAM_STR);
    $QyCsh->bindParam(':auth',$auditado,PDO::PARAM_STR);
    $QyCsh->bindParam(':temp',$cantidad,PDO::PARAM_STR);
    $QyCsh->execute();
    $lastInsertId = $dbP->lastInsertId();
    if($lastInsertId){
        $BAR = "SELECT * from variation_location_details WHERE variation_id=:P_id and location_id=:loc";
        $QyBar = $dbP -> prepare($BAR);
        $QyBar->bindParam(':P_id',$id_var,PDO::PARAM_STR);
        $QyBar->bindParam(':loc',$location,PDO::PARAM_STR);
        $QyBar->execute();
        $RsBar=$QyBar->fetchAll(PDO::FETCH_OBJ);
        if($QyBar->rowCount() > 0){  
            foreach($RsBar as $RB){
                $EXIST = $RB->id;
            }
        }
        if($EXIST){
        $UPDATE = "UPDATE variation_location_details  SET qty_available=:qty
                    WHERE variation_id=:P_id 
                    AND location_id=:loc";
        $QyUpd = $dbP -> prepare($UPDATE);
        $QyUpd->bindParam(':qty',$auditado,PDO::PARAM_STR);
        $QyUpd->bindParam(':P_id',$id_var,PDO::PARAM_STR);
        $QyUpd->bindParam(':loc',$location,PDO::PARAM_STR);
        $QyUpd->execute();
        }
        else{
            $inDay = date("Y-m-d H:i:s");
            $stock="INSERT INTO 
                    variation_location_details(product_id, product_variation_id, variation_id, location_id, qty_available, created_at, updated_at)
                    values(:var_id, :var_id, :var_id, :locate, :qty, :date, :date )";
                    $qyVar = $dbP -> prepare($stock);
                    $qyVar->bindParam(':var_id',$id_var,PDO::PARAM_STR);
                    $qyVar->bindParam(':locate',$location,PDO::PARAM_STR);
                    $qyVar->bindParam(':qty',$auditado,PDO::PARAM_STR);
                    $qyVar->bindParam(':date',$inDay,PDO::PARAM_STR);
                    $qyVar->execute();
                    
        }
        
        
        echo "<h1 align='center'>(GUARDADO) Selecciona otro producto<h1>";
    }
                                            
                                           
                                           
                                    ?>