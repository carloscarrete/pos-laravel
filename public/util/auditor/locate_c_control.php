<?php
  error_reporting(0);
include('../conect.php');
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
    $auditor=$_POST["admin"];
    $location=$_POST["number"];
    $producto=$_POST["name"];
    $sku=$_POST["sku"];
    $id_var=$_POST["idp"];
    $cantidad=$_POST["qty"];
    $auditado=$_POST["rly"];
    $diferencia=$cantidad-$auditado;
    $fecha=date("d-m-Y");
    
    $ready = "SELECT * from auditorias WHERE sku=:sku_rdy and fecha=:today and id_location=:locate and type='ct'";
    $qyRead = $dbP -> prepare($ready);
    $qyRead->bindParam(':sku_rdy',$sku,PDO::PARAM_STR);
    $qyRead->bindParam(':today',$fecha,PDO::PARAM_STR);
    $qyRead->bindParam(':locate',$location,PDO::PARAM_STR);
    $qyRead->execute();
    $READL=$qyRead->fetchAll(PDO::FETCH_OBJ);
    if($qyRead->rowCount() > 0){  
        foreach($READL as $Rdy){
            $ID = $Rdy->id;
        }
    }
    if($ID==null){
    $athInsert="INSERT INTO 
        auditorias(fecha, auditor, id_location, producto, diferencia, sku, id_variation, type, rly)
        values(:fecha, :auditor, :number, :prd, :dif, :sku, :idp ,'ct', :auth)";
    $QyCsh = $dbP -> prepare($athInsert);
    $QyCsh->bindParam(':fecha',$fecha,PDO::PARAM_STR);
    $QyCsh->bindParam(':auditor',$auditor,PDO::PARAM_STR);
    $QyCsh->bindParam(':number',$location,PDO::PARAM_STR);
    $QyCsh->bindParam(':prd',$producto,PDO::PARAM_STR);
    $QyCsh->bindParam(':dif',$diferencia,PDO::PARAM_STR);
    $QyCsh->bindParam(':sku',$sku,PDO::PARAM_STR);
    $QyCsh->bindParam(':idp',$id_var,PDO::PARAM_STR);
    $QyCsh->bindParam(':auth',$auditado,PDO::PARAM_STR);
    
    $QyCsh->execute();
    $lastInsertId = $dbP->lastInsertId();
    }
    else{
    $athInsert="UPDATE auditorias SET
        fecha=:fecha, auditor=:auditor, id_location=:number, producto=:prd, rly=:auth,
        diferencia=:dif, sku=:sku, id_variation=:idp WHERE id=:ID";
    $QyCsh = $dbP -> prepare($athInsert);
    $QyCsh->bindParam(':fecha',$fecha,PDO::PARAM_STR);
    $QyCsh->bindParam(':auditor',$auditor,PDO::PARAM_STR);
    $QyCsh->bindParam(':number',$location,PDO::PARAM_STR);
    $QyCsh->bindParam(':prd',$producto,PDO::PARAM_STR);
    $QyCsh->bindParam(':dif',$diferencia,PDO::PARAM_STR);
    $QyCsh->bindParam(':sku',$sku,PDO::PARAM_STR);
    $QyCsh->bindParam(':idp',$id_var,PDO::PARAM_STR);
    $QyCsh->bindParam(':ID',$ID,PDO::PARAM_STR);
    $QyCsh->bindParam(':auth',$auditado,PDO::PARAM_STR);
    $QyCsh->execute();
    $lastInsertId = 1;
    }
    if($lastInsertId){
        
        
        echo "<h1 align='center'>(GUARDADO) Selecciona otro producto</h1>";
    }
                                            
                                           
                                           
                                    ?>