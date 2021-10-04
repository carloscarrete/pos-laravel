<?php
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
include('../conect.php');
require_once('../Mail/config.php');
        
        $id_user=$_GET["idu"];
        $id_loc=$_GET["idb"];
        
        $CAJA=0;
        $VENTA=0;
        $RETIRO=0;
        $REFOUND=0;
        $GASTO=0;
        $TRANSFER=0;
        
        $SELL="sell";
        
	    $SearchCashReg = "SELECT  * from cash_registers WHERE business_id=:b_id AND user_id=:u_id AND status='open'";
        $QyCashReg = $dbP -> prepare($SearchCashReg);
        $QyCashReg->bindParam(':b_id',$id_loc,PDO::PARAM_STR);
        $QyCashReg->bindParam(':u_id',$id_user,PDO::PARAM_STR);
        $QyCashReg->execute();
        $ResultCashReg=$QyCashReg->fetchAll(PDO::FETCH_OBJ);
        if($QyCashReg->rowCount() > 0){
            foreach($ResultCashReg as $RG){
                $CajaREG = $RG->id;
            }
        }
        $ID_SEND = $CajaREG;
        
        $lIMIT = "SELECT  * from users WHERE id =:u_id";
        $QyLimit = $dbP -> prepare($lIMIT);
        $QyLimit->bindParam(':u_id',$id_user,PDO::PARAM_STR);
        $QyLimit->execute();
        $ResLimit=$QyLimit->fetchAll(PDO::FETCH_OBJ);
        if($QyLimit->rowCount() > 0){
            foreach($ResLimit as $RL){
                $Cash_Limit = $RL->limit_cash;
            }
        }
        $CA=$Cash_Limit;
        
        $SearchTrCshReg = "SELECT  * from cash_register_transactions WHERE cash_register_id=:c_id";
        $QyTransCR = $dbP -> prepare($SearchTrCshReg);
        $QyTransCR->bindParam(':c_id',$CajaREG,PDO::PARAM_STR);
        $QyTransCR->execute();
        $ResultTCR=$QyTransCR->fetchAll(PDO::FETCH_OBJ);
        if($QyTransCR->rowCount() > 0){
            foreach($ResultTCR as $RTCR){
                $CajaREG = $RTCR->id;
                $TYPE = $RTCR->transaction_type;
                $AMOUNT = $RTCR->amount;
                $METHOD = $RTCR->pay_method;
                
                if($TYPE == "sell"){ if($METHOD == "cash"){ $VENTA= $VENTA +  $AMOUNT;}}
                if($TYPE == "refund"){$REFOUND = $REFOUND + $AMOUNT;}
                if($TYPE == "gasto"){$GASTO = $GASTO + $AMOUNT;}
                if($TYPE == "initial"){$CAJA = $CAJA + $AMOUNT;}
                if($TYPE == "retiro"){$RETIRO = $RETIRO + $AMOUNT;}
                if($TYPE == "transfer"){$TRANSFER = $TRANSFER + $AMOUNT;}
            }
        }
            $TOTAL_IN_CASH= $VENTA + $CAJA - $REFOUND - $GASTO - $TRANSFER - $RETIRO;
         
            $Cash_Limit = $CA;

    if($TOTAL_IN_CASH>=$Cash_Limit){
       echo "<script type=''>alert('REALIZA EL RETIRO')</script>";
    }
?>
