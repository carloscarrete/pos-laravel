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
        
        
        $AtoC="SELECT * from products";
        $qryAtoc = $dbP -> prepare($AtoC);
        $qryAtoc->execute();
        $resultsatoc=$qryAtoc->fetchAll(PDO::FETCH_OBJ);
        if($qryAtoc->rowCount() > 0){  
            foreach($resultsatoc as $ratoc){
                $SKU_P = $ratoc->sku;
                $NAME_P = $ratoc->name;
                $In_Ath="SELECT * FROM auditorias WHERE fecha=:today and id_location=:locate and sku=:sku_p";
                $qyiath = $dbP -> prepare($In_Ath);
                $qyiath->bindParam(':today',$fecha,PDO::PARAM_STR);
                $qyiath->bindParam(':locate',$location,PDO::PARAM_STR);
                $qyiath->bindParam(':sku_p',$SKU_P,PDO::PARAM_STR);
                $qyiath->execute();
                $ready_p=$qyiath->fetchAll(PDO::FETCH_OBJ);
                if($qyiath->rowCount() > 0){  
                    foreach($ready_p as $res_p){
                        $Ver_p= $res_p->id;
                    }
                }
                $all_car="SELECT * FROM variations WHERE sub_sku=:sku_p";
                $qyCar = $dbP -> prepare($all_car);
                $qyCar->bindParam(':sku_p',$SKU_P,PDO::PARAM_STR);
                $qyCar->execute();
                $categorys=$qyCar->fetchAll(PDO::FETCH_OBJ);
                if($qyCar->rowCount() > 0){  
                    foreach($categorys as $cat){
                        $var_id = $cat->product_variation_id;
                        $real_qty=0;
                        $ac="SELECT * FROM variation_location_details WHERE product_variation_id=:varid";
                        $qC = $dbP -> prepare($ac);
                        $qC->bindParam(':varid',$var_id,PDO::PARAM_STR);
                        $qC->execute();
                        $ctgry=$qC->fetchAll(PDO::FETCH_OBJ);
                        if($qC->rowCount() > 0){  
                            foreach($ctgry as $cry){
                                $real_qty=$cry->qty_available;
                            }
                        }
                    }
                }
                    $tdyin=date("d-m-Y");
                    $all_to_0="INSERT INTO
                    auditorias(auditor, id_location, producto, id_variation, diferencia, sku, type, rly, fecha)
                    values(:ua, :locate, :name, :varid, :dif, :sku, 'c', '0', :date)";
                    $ALLT0 = $dbP -> prepare($all_to_0);
                    $ALLT0->bindParam(':ua',$UA,PDO::PARAM_STR);
                    $ALLT0->bindParam(':locate',$location,PDO::PARAM_STR);
                    $ALLT0->bindParam(':name',$NAME_P,PDO::PARAM_STR);
                    $ALLT0->bindParam(':varid',$var_id,PDO::PARAM_STR);
                    $ALLT0->bindParam(':dif',$real_qty,PDO::PARAM_STR);
                    $ALLT0->bindParam(':sku',$SKU_P,PDO::PARAM_STR);
                    $ALLT0->bindParam(':date',$tdyin,PDO::PARAM_STR);
                    $ALLT0->execute();
                
            }
        }
        /*
        $UPDATE = "UPDATE variation_location_details  SET qty_available='0'
                    WHERE location_id=:loc";
        $QyUpd = $dbP -> prepare($UPDATE);
        $QyUpd->bindParam(':loc',$location,PDO::PARAM_STR);
        $QyUpd->execute();*/
        
        //Limpieza de DB
        echo "<h1 align='center'>VACIANDO RESULTADOS</h1>
        <h4 align='center'>(Por favor espere...)</h4></br>";
        $DEL = "delete from variation_location_details where location_id=:loc";
        $DEL_ALL = $dbP -> prepare($DEL);
        $DEL_ALL->bindParam(':loc',$location,PDO::PARAM_STR);
        $DEL_ALL->execute();
        
        //Select a todas las auditorias
        $selectx = "SELECT * from auditorias WHERE fecha=:today and id_location=:locate and type='c'";
        $laborx = $dbP -> prepare($selectx);
        $laborx->bindParam(':today',$fecha,PDO::PARAM_STR);
        $laborx->bindParam(':locate',$location,PDO::PARAM_STR);
        $laborx->execute();
        $respuestax=$laborx->fetchAll(PDO::FETCH_OBJ);
        $STOK=0;
        if($laborx->rowCount() > 0){  
            foreach($respuestax as $resx){
                $xid=$resx->sku;
                $A=$resx->id;
                $STOK=$resx->diferencia;
                
                //Select a todas las auditorias temporales
                $selecty = "SELECT * from auditorias WHERE fecha=:today and id_location=:locate and type='ct' and sku=:sku";
                $labory = $dbP -> prepare($selecty);
                $labory->bindParam(':today',$fecha,PDO::PARAM_STR);
                $labory->bindParam(':locate',$location,PDO::PARAM_STR);
                $labory->bindParam(':sku',$xid,PDO::PARAM_STR);
                $labory->execute();
                $respuestay=$labory->fetchAll(PDO::FETCH_OBJ);
                $rlyx=0;
                $difred=0;
                if($labory->rowCount() > 0){  
                    foreach($respuestay as $resy){
                         $sky=$resy->sku;
                         $rlyx=$resy->rly;
                         $difred=$rlyx-$STOK;
                    }
                }
                $S_K_Y=$sky;
                
                $ty=date("d-m-Y");
                $UPDATEx = "UPDATE auditorias  SET rly=:rly, diferencia=:dif, temp=:temp  WHERE id=:A";
                $QyUpdx = $dbP -> prepare($UPDATEx);
                $QyUpdx->bindParam(':A',$A,PDO::PARAM_STR);
                $QyUpdx->bindParam(':rly',$rlyx,PDO::PARAM_STR);
                $QyUpdx->bindParam(':dif',$difred,PDO::PARAM_STR);
                $QyUpdx->bindParam(':temp',$STOK,PDO::PARAM_STR);
                $QyUpdx->execute();
                
                $selectw = "SELECT * from auditorias WHERE id=:A";
                $laborw = $dbP -> prepare($selectw);
                $laborw->bindParam(':A',$A,PDO::PARAM_STR);
                $laborw->execute();
                $respuestaw=$laborw->fetchAll(PDO::FETCH_OBJ);
                $ND=0;
                if($laborw->rowCount() > 0){  
                    foreach($respuestaw as $resw){
                        $NewSt=$resw->temp;
                        $NewRly=$resw->rly;
                        $ND=$NewRly-$NewSt;
                    }
                }
                
                $UPDATEk = "UPDATE auditorias  SET diferencia=:nd WHERE id=:A";
                $QyUpdk = $dbP -> prepare($UPDATEk);
                $QyUpdk->bindParam(':A',$A,PDO::PARAM_STR);
                $QyUpdk->bindParam(':nd',$ND,PDO::PARAM_STR);
                $QyUpdk->execute();
                
                //Buscar variation id
                $srh = "SELECT * from variations WHERE sub_sku=:sku";
                $qyqy = $dbP -> prepare($srh);
                $qyqy->bindParam(':sku',$xid,PDO::PARAM_STR);
                $qyqy->execute();
                $RSSa=$qyqy->fetchAll(PDO::FETCH_OBJ);
                if($qyqy->rowCount() > 0){  
                    foreach($RSSa as $DB){
                        $S2 = $DB->product_variation_id;
                    }
                }
                        
                /*      
                //Detectar ID
                $BAR = "SELECT * from variation_location_details WHERE product_id=:id_d and location_id=:loc";
                $QyBar = $dbP -> prepare($BAR);
                $QyBar->bindParam(':id_d',$S2,PDO::PARAM_STR);
                $QyBar->bindParam(':loc',$location,PDO::PARAM_STR);
                $QyBar->execute();
                $RsBar=$QyBar->fetchAll(PDO::FETCH_OBJ);
                if($QyBar->rowCount() > 0){  
                    foreach($RsBar as $RB){
                        $EXIST = $RB->id;
                    }
                }
                        
                //Evaluar si existe
                if($EXIST){
                    $UPDATE2 = "UPDATE variation_location_details  SET qty_available=:qty
                    WHERE variation_id=:P_id  AND location_id=:loc";
                    $QyUpd2 = $dbP -> prepare($UPDATE2);
                    $QyUpd2->bindParam(':P_id',$S2,PDO::PARAM_STR);
                    $QyUpd2->bindParam(':loc',$location,PDO::PARAM_STR);
                    $QyUpd2->bindParam(':qty',$rlyx,PDO::PARAM_STR);
                    $QyUpd2->execute();
                }
                        
                else{}*/
                    $inDay = date("Y-m-d H:i:s");
                    $stock="INSERT INTO 
                            variation_location_details(product_id, product_variation_id, variation_id, location_id, qty_available, created_at, updated_at)
                            values(:var_id, :var_id, :var_id, :locate, :qty, :date, :date )";
                    $qyVar = $dbP -> prepare($stock);
                    $qyVar->bindParam(':var_id',$S2,PDO::PARAM_STR);
                    $qyVar->bindParam(':locate',$location,PDO::PARAM_STR);
                    $qyVar->bindParam(':qty',$rlyx,PDO::PARAM_STR);
                    $qyVar->bindParam(':date',$inDay,PDO::PARAM_STR);
                    $qyVar->execute();
                
                        
                        
            }
        }
        
        
        
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
            $consult = "SELECT * from auditorias WHERE fecha=:today and id_location=:locate and type='c' and diferencia<>0";
            $difered = $dbP -> prepare($consult);
            $difered->bindParam(':today',$fecha,PDO::PARAM_STR);
            $difered->bindParam(':locate',$location,PDO::PARAM_STR);
            $difered->execute();
            $resourse=$difered->fetchAll(PDO::FETCH_OBJ);
            $y=0;
            if($difered->rowCount() > 0){  
                foreach($resourse as$rsS){
                    
                    $cl2 =$rsS->diferencia;
                    $cl1 =$rsS->sku;
                    $cl3 =$rsS->rly;
                    $cl4 =$rsS->temp;
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
            $mail->Subject = "AUDITORIA COMPLETA $fecha | $UA | $NameL";




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