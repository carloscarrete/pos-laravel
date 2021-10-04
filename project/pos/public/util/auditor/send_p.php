<?php
error_reporting(0);
include('../conect.php');
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
$location = $_POST["loc_sub"];

 $LocQ = "SELECT * from business_locations WHERE id=:id_loc";
    $sloc = $dbP -> prepare($LocQ);
    $sloc->bindParam(':id_loc',$location,PDO::PARAM_STR);
    $sloc->execute();
    $sayLoc=$sloc->fetchAll(PDO::FETCH_OBJ);
    if($sloc->rowCount() > 0){  
        foreach($sayLoc as $RL){
            $NameL=$RL->name;
        }
    }



 $fecha=date("d-m-Y");
 $Password=base64_encode($_POST["code"]);
                                            
    $Auth = "SELECT * from pin WHERE pin=:pin";
    $qyAPss = $dbP -> prepare($Auth);
    $qyAPss->bindParam(':pin',$Password,PDO::PARAM_STR);
    $qyAPss->execute();
    $rsAPss=$qyAPss->fetchAll(PDO::FETCH_OBJ);
    if($qyAPss->rowCount() > 0){  
        foreach($rsAPss as $RAP){
            $userAuth=$RAP->name;
        }
    }
    $UA=$userAuth;
    if(!$UA){echo "<script type=''>alert('NIP no registrado (Cierre de seguridad)');</script>
    <h1 align='center'>Por seguridad ingresa nuevamente con tu nip.</h1>";
        
    }
    else{
//Verificar que no este cerrado
    $ready = "SELECT * from auditorias WHERE fecha=:today and id_location=:locate and type='close'";
    $qyRead = $dbP -> prepare($ready);
    $qyRead->bindParam(':today',$fecha,PDO::PARAM_STR);
    $qyRead->bindParam(':locate',$location,PDO::PARAM_STR);
    $qyRead->execute();
    $READL=$qyRead->fetchAll(PDO::FETCH_OBJ);
    if($qyRead->rowCount() > 0){  
        foreach($READL as $Rdy){
            $CLOSE = $Rdy->id;
        }
    }
    if($CLOSE==null){
        
        
        //Cerrar Auditoria
        $auditor=$UA;
        $athInsert="INSERT INTO 
        auditorias(fecha, auditor, id_location,  type)
        values(:fecha, :auditor, :number, 'close')";
        $QyCsh = $dbP -> prepare($athInsert);
        $QyCsh->bindParam(':fecha',$fecha,PDO::PARAM_STR);
        $QyCsh->bindParam(':number',$location,PDO::PARAM_STR);
        $QyCsh->bindParam(':auditor',$auditor,PDO::PARAM_STR);
        $QyCsh->execute();
        
        echo "<h1 align='center'>COMPLETADO</h1>";
        require_once('../Mail/config.php');
        
            $Productos = "";
            $consult = "SELECT * from auditorias WHERE fecha=:today and id_location=:locate and type='p' and diferencia<>0";
            $difered = $dbP -> prepare($consult);
            $difered->bindParam(':today',$fecha,PDO::PARAM_STR);
            $difered->bindParam(':locate',$location,PDO::PARAM_STR);
            $difered->execute();
            $resourse=$difered->fetchAll(PDO::FETCH_OBJ);
            $y=0;
            if($difered->rowCount() > 0){  
                foreach($resourse as$rsS){
                    $cl1 =$rsS->sku;
                    $cl4 =$rsS->temp;
                    $cl3 =$rsS->rly;
                    $cl2 =$rsS->diferencia;
                    
                    $BAR_3 = "SELECT * from products WHERE sku=:P_id";
                    $QyBar_3 = $dbP -> prepare($BAR_3);
                    $QyBar_3->bindParam(':P_id',$cl1,PDO::PARAM_STR);
                    $QyBar_3->execute();
                    $RsBar_3=$QyBar_3->fetchAll(PDO::FETCH_OBJ);
                    if($QyBar_3->rowCount() > 0){  
                        foreach($RsBar_3 as $RB_3){
                             $nom = $RB_3 ->name;
                             $IDPs= $RB_3 ->id;
                                
                             
                                    
                        }
                    }
                    $Productos = $Productos. "<p>$nom | Codigo: $cl1 | Cantidad: $cl4 | Auditado: $cl3 | Diferencia: $cl2</p>";
                    $y++;
                }
            }    
        
            $Auth = "SELECT * from pin WHERE mail IS NOT NULL";
            $qyAPss = $dbP -> prepare($Auth);
            $qyAPss->execute();
            $rsAPss=$qyAPss->fetchAll(PDO::FETCH_OBJ);
            if($qyAPss->rowCount() > 0){  
                foreach($rsAPss as $RAP){
                    $userMail=$RAP->mail;
                    
            $mail->ClearAllRecipients();
            $mail->AddAddress("$userMail");
            $mail->IsHTML(true);  //podemos activar o desactivar HTML en mensaje
            $mail->Subject = "AUDITORIA PARCIAL $fecha | $UA | $NameL";




            $msg = "
            <h2>Hola SALUDABLE.MX te presenta los resultados de la auditoria de $UA</h2>
            <p>Ahora te incluimos todos los detalles: Fecha $inDay</p>
            <p>Sucursal: $NameL</p>
            <h4>
            <p>USUARIO: $UA </br> </p>
            <p>Los siguientes articulos presentan irregularidades:</p>
            <hr/>
            $Productos
            ";
            $mail->Body    = $msg;
            $mail->Send();}}
                                
        
    }
    else {echo "<h1 align='center'>Tu auditoria ya fue cerrada</h1>";}
    }