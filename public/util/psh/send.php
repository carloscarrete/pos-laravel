<?php
    include('../conect.php');
    require_once('../Mail/config.php');
    date_default_timezone_set('UTC');
    date_default_timezone_set("America/Mexico_City");
        $IDTRA=$_GET["idre"];
        
    
            $Auth = "SELECT * from pin WHERE mail IS NOT NULL";
            $qyAPss = $dbP -> prepare($Auth);
            $qyAPss->execute();
            $rsAPss=$qyAPss->fetchAll(PDO::FETCH_OBJ);
            if($qyAPss->rowCount() > 0){  
                foreach($rsAPss as $RAP){
                    $userMail=$RAP->mail;
                    $nip=$RAP->pin;
                    $idadm=$RAP->id;
            
            $cashreg = "SELECT * from transactions WHERE id=:id";
            $QyCasReg = $dbP -> prepare($cashreg);
            $QyCasReg->bindParam(':id',$IDTRA,PDO::PARAM_STR);
            $QyCasReg->execute();
            $resCashReg=$QyCasReg->fetchAll(PDO::FETCH_OBJ);
            if($QyCasReg->rowCount() > 0){  
                foreach($resCashReg as $RCR){
                    $ID_REGISTER=$RCR->cash_reg_id;
                    $FOLIO=$RCR->ref_no;
                    $FECHA = $RCR->transaction_date;
                    $Count = $RCR->rec +1;
                    $InsertCash = "UPDATE transactions SET rec=:count WHERE id=:id";
                    $QyCsh = $dbP -> prepare($InsertCash);
                    $QyCsh->bindParam(':id',$IDTRA,PDO::PARAM_STR);
                    $QyCsh->bindParam(':count',$Count,PDO::PARAM_STR);
                    $QyCsh->execute();
                    
                    
                }
            }
            
            
            $mail->ClearAllRecipients();
            $mail->AddAddress("$userMail");
            $mail->IsHTML(true);  //podemos activar o desactivar HTML en mensaje
            $mail->Subject = 'RECORDATORIO';

            $msg = "
            <h2>Hola SALUDABLE.MX te recuerda que tienes una nueva solicitud de gasto pendiente</h2>
            <p>Referencia:<b style=color:blue> $FOLIO </b></p>
            <p>Fecha:<b style=color:black> $FECHA </b></p>
            <p>Busca el <b style=color:blue>correo de autorizacion</b> en tu bandeja de entrada o de spam.</p>
            
            ";
            
            $mail->Body    = $msg;
            $mail->Send();
                }
            }
            
            echo "<script type=''>alert('Recordatorio enviado');</script>";
            
      
?>