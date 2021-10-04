<?php
include('../conect.php');
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");

$pin = base64_decode($_GET["ath"]);
$idadm = base64_decode($_GET["id"]);
$id = base64_decode($_GET["code"]);
$idcash = base64_decode($_GET["cash"]);
$idcash = base64_decode($idcash);
echo "<title>Gastos</title>";
$Hoy = date("Y-m-d");

$sql = "SELECT * from transactions WHERE id=:id";
$query = $dbP -> prepare($sql);
$query->bindParam(':id',$id,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0){
    foreach($results as $res){ 
        $Gasto = $res->ref_no;
        $Fecha = date('Y-m-d',strtotime($res->transaction_date));
        $Monto = $res->final_total;
        $Stts = $res->auth;
        $Coment = $res->additional_notes;
        $Location = location_id;
        $CreatedBy =created_by;
    }
}

$Caja = "SELECT * from cash_registers WHERE id=:id_c";
$cash_reg = $dbP -> prepare($Caja);
$cash_reg->bindParam(':id_c',$idcash,PDO::PARAM_STR);
$cash_reg->execute();
$resCash=$cash_reg->fetchAll(PDO::FETCH_OBJ);
if($cash_reg->rowCount() > 0){
    foreach($resCash as $RC){ 
        $STATE = $RC -> status;
    }
}

$ADMIN = "SELECT * from pin WHERE id=:id";
$QyAdm = $dbP -> prepare($ADMIN);
$QyAdm->bindParam(':id',$idadm,PDO::PARAM_STR);
$QyAdm->execute();
$ResAdm=$QyAdm->fetchAll(PDO::FETCH_OBJ);
if($QyAdm->rowCount() > 0){
    foreach($ResAdm as $RA){ 
        $NameAdm = $RA->name;
    }
}


/*
if($Hoy!=$Fecha && $Stts!=2 && $Stts!=3 && $Stts!=1){
        $InsertCash = "UPDATE transactions SET auth = '3' WHERE id=:id";
        $QyCsh = $dbP -> prepare($InsertCash);
        $QyCsh->bindParam(':id',$id,PDO::PARAM_STR);
        $QyCsh->execute();
        $sql = "SELECT * from transactions WHERE id=:id";
        $query = $dbP -> prepare($sql);
        $query->bindParam(':id',$id,PDO::PARAM_STR);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() > 0){
            foreach($results as $res){ 
                $Gasto = $res->ref_no;
                $Fecha = date('Y-m-d',strtotime($res->transaction_date));
                $Monto = $res->final_total;
                $Stts = $res->auth;
                $Coment = $res->additional_notes;
            }
        }
    } */

if($Stts == 0){
    if($STATE=='close'){echo "<script type=''>alert('ERROR: La caja ya realizo el corte');</script>";
        $InsertCash = "UPDATE transactions SET auth = '3' WHERE id=:id";
        $QyCsh = $dbP -> prepare($InsertCash);
        $QyCsh->bindParam(':id',$id,PDO::PARAM_STR);
        $QyCsh->execute();
    }
    else{
        $Coment = "(Autoriza: $NameAdm) " . $Coment;
        $Today = date("Y-m-d h:i:s");
        $InsertCash = "INSERT INTO cash_register_transactions(auth, cash_register_id, amount, pay_method, type, transaction_type, transaction_id, created_at, updated_at) 
        values(:admid, :cashid, :monto, 'cash', 'debit', 'gasto', :trsid , :fecha, :fecha)";
        $QyCsh = $dbP -> prepare($InsertCash);
        $QyCsh->bindParam(':admid',$idadm,PDO::PARAM_STR);
        $QyCsh->bindParam(':cashid',$idcash,PDO::PARAM_STR);
        $QyCsh->bindParam(':monto',$Monto,PDO::PARAM_STR);
        $QyCsh->bindParam(':trsid',$id,PDO::PARAM_STR);
        $QyCsh->bindParam(':fecha',$Today,PDO::PARAM_STR);
        $QyCsh->execute();
        $lastInsertId = $dbP->lastInsertId();
        if($lastInsertId){echo "<script type=''>alert('Autorizado correctamente');</script>";
            $InsertCash = "UPDATE transactions SET auth = '1', additional_notes = :coment, updated_at=:fecha WHERE id=:id";
            $QyCsh = $dbP -> prepare($InsertCash);
            $QyCsh->bindParam(':id',$id,PDO::PARAM_STR);
            $QyCsh->bindParam(':coment',$Coment,PDO::PARAM_STR);
            $QyCsh->bindParam(':fecha',$Today,PDO::PARAM_STR);
            $QyCsh->execute();
        
        }
    else {echo "<script type=''>alert('ERROR: CONEXION RECHAZADA MYSQL');</script>";}
    }
}
if($Stts == 1) {echo "<script type=''>alert('Movimiento autorizado previamente');</script>";}
if($Stts == 2){echo "<script type=''>alert('Solicitud rechazada previamente');</script>";}
if($Stts == 3){echo "<script type=''>alert('Caja cerrada');</script>";}
echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";

?>