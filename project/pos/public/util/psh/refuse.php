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
    } 
*/
if($Stts == 0){
        $Coment = "(Rechaza: $NameAdm) " . $Coment;
        $Today = date("Y-m-d h:i:s");
        echo "<script type=''>alert('Rechazado correctamente');</script>";
            $InsertCash = "UPDATE transactions SET auth = '2', additional_notes = :coment, updated_at=:fecha WHERE id=:id";
            $QyCsh = $dbP -> prepare($InsertCash);
            $QyCsh->bindParam(':id',$id,PDO::PARAM_STR);
            $QyCsh->bindParam(':coment',$Coment,PDO::PARAM_STR);
            $QyCsh->bindParam(':fecha',$Today,PDO::PARAM_STR);
            $QyCsh->execute();
}
if($Stts == 1) {echo "<script type=''>alert('Movimiento autorizado previamente');</script>";}
if($Stts == 2){echo "<script type=''>alert('Solicitud rechazada previamente');</script>";}
if($Stts == 3){echo "<script type=''>alert('Caja cerró');</script>";}
echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";

?>