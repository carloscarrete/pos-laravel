
<!DOCTYPE html>
<style>

.left{
    float: left;

}
.right{
    float: right;

}
.center{

   display:inline-block
}
@media print {
    .btn-print {
      display:none !important;
    size:30px;
    }

}
#abajo{
    height: 3px;
  width: 30%;
  background-color: black;
}
tr{
  font-family:'Helvetica','Verdana','Monaco',sans-serif;
  border:none; font-size: 15px;

}
#terminos{
    border:none; font-size: 8px;
}
</style>
    <html>
        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
echo "
            <title>Ticket</title>
     
        </head>
<script type='text/javascript'>
    function imprimir() {
        if (window.print) {
            window.print();
        } 
        else {
            alert('La función de impresion no esta soportada por su navegador.');
            window.location.href = '/home';
        }
    }
</script>
 <body onload='imprimir();'>";

    include('conect.php');
        $today=date("d-m-Y");
        $IDReg = base64_decode($_GET["id"]);
        $IDUser = base64_decode($_GET["uid"]);
        $VENTA =0;
        $CARD =0;
        $REFOUND =0;
        $GASTO =0;
        $INHAND =0;
        $RETIROS =0;
        $TRANSFER =0;
        $Ship_total =0;
        $SearchTrCshReg = "SELECT  * from cash_register_transactions WHERE cash_register_id=:c_id";
        $QyTransCR = $dbP -> prepare($SearchTrCshReg);
        $QyTransCR->bindParam(':c_id',$IDReg,PDO::PARAM_STR);
        $QyTransCR->execute();
        $ResultTCR=$QyTransCR->fetchAll(PDO::FETCH_OBJ);
        if($QyTransCR->rowCount() > 0){
            foreach($ResultTCR as $RTCR){
                $CajaREG = $RTCR->id;
                $TYPE = $RTCR->transaction_type;
                $AMOUNT = $RTCR->amount;
                $METHOD = $RTCR->pay_method;
                
                if($TYPE == "sell"){ 
                    if($METHOD == "cash"){ $VENTA= $VENTA +  $AMOUNT;}
                    if($METHOD == "card"){ $CARD= $CARD +  $AMOUNT;}
                }
                if($TYPE == "refund"){$REFOUND = $REFOUND + $AMOUNT;}
                if($TYPE == "gasto"){$GASTO = $GASTO + $AMOUNT;}
                if($TYPE == "initial"){$INHAND = $INHAND + $AMOUNT;}
                if($TYPE == "retiro"){$RETIROS = $RETIROS + $AMOUNT;}
                if($TYPE == "transfer"){$TRANSFER = $TRANSFER + $AMOUNT;}
            }
        }
        
        $SearchCashReg = "SELECT  * from cash_registers WHERE id=:cid_X";
            $QyCashReg = $dbP -> prepare($SearchCashReg);
            $QyCashReg->bindParam(':cid_X',$IDReg,PDO::PARAM_STR);
            $QyCashReg->execute();
            $ResultCashReg=$QyCashReg->fetchAll(PDO::FETCH_OBJ);
            if($QyCashReg->rowCount() > 0){
                foreach($ResultCashReg as $RG){
                    $today= $RG->closed_at;
                }
            }
        
        
        $DetectUser= "SELECT * FROM users WHERE id=:user";
        $QyUsr = $dbP -> prepare($DetectUser);
		$QyUsr->bindParam(':user',$IDUser,PDO::PARAM_STR);
        $QyUsr->execute();
        $ResUsr=$QyUsr->fetchAll(PDO::FETCH_OBJ);
        if($QyUsr->rowCount() > 0){  
            foreach($ResUsr as $RU){
                $NAME=$RU->first_name . " " . $RU->last_name;
                $MAIL= $RU->email;
            }
        }?>
        <a class = "btn btn-success btn-print" style="    text-decoration: none;
        padding: 10px;
        font-weight: 600;
        font-size: 20px;
        color: #ffffff;
        background-color: #1883ba;
        border-radius: 6px;
        border: 2px solid #0016b0; " href="/" ><i class ="glyphicon glyphicon-print"></i>Regresar</a>
        
           <a class = "btn btn-success btn-print" style="    text-decoration: none;
    padding: 10px;
    font-weight: 600;
    font-size: 20px;
    color: #ffffff;
    background-color: #1883ba;
    border-radius: 6px;
    border: 2px solid #0016b0; "  onclick = "window.print()"><i class ="glyphicon glyphicon-print"></i> Impresion ticket</a>
        <?php
        echo "
        <title>CORTE</title><div align='center'>
        <h1>CORTE</h1>";
        echo "<h4>
            No. REGISTRO: $IDReg </br> 
            USUARIO: $NAME </br> 
            CORREO: $MAIL </br> 
            FECHA: $today </h4>";
        $TOTAL_all= $VENTA + $CARD;
        echo "<hr/>";
        echo " <h1>Ventas</h1>";
        
        $x=0;
        $ymx = [];
        
        $DU= "SELECT DISTINCT * FROM cash_register_transactions WHERE cash_register_id=:c_id and transaction_type='sell'and amount>'0'";
        $QySell_cs = $dbP -> prepare($DU);
		$QySell_cs->bindParam(':c_id',$IDReg,PDO::PARAM_STR);
        $QySell_cs->execute();
        $RESELLCS=$QySell_cs->fetchAll(PDO::FETCH_OBJ);
        if($QySell_cs->rowCount() > 0){  
            foreach($RESELLCS as $RCSS){
                
                $TSell = $RCSS->transaction_id;
                
                $Sub1DU= "SELECT * FROM transaction_sell_lines WHERE transaction_id=:sub1";
                $Sub1QySell_cs = $dbP -> prepare($Sub1DU);
		        $Sub1QySell_cs->bindParam(':sub1',$TSell,PDO::PARAM_STR);
                $Sub1QySell_cs->execute();
                $Sub1RESELLCS=$Sub1QySell_cs->fetchAll(PDO::FETCH_OBJ);
                if($Sub1QySell_cs->rowCount() > 0){  
                    foreach($Sub1RESELLCS as $Sub1RCSS){
                        $Cantqy= $Sub1RCSS ->quantity;
                        $Cantqy = number_format($Cantqy);
                        $price = $Sub1RCSS ->unit_price_inc_tax;
                        $total  = $price * $Cantqy;
                        $total = number_format($total,2);
                        
                        $sub2 = $Sub1RCSS ->product_id;
                        $Sub2DU= "SELECT * FROM products WHERE id=:sub2";
                        $Sub2QySell_cs = $dbP -> prepare($Sub2DU);
		                $Sub2QySell_cs->bindParam(':sub2',$sub2,PDO::PARAM_STR);
                        $Sub2QySell_cs->execute();
                        $Sub2RESELLCS=$Sub2QySell_cs->fetchAll(PDO::FETCH_OBJ);
                        if($Sub2QySell_cs->rowCount() > 0){  
                            foreach($Sub2RESELLCS as $Sub2RCSS){
                                $cat = $Sub2RCSS ->category_id;
                                $sub_cat= $Sub2RCSS ->sub_category_id;
                                
                                $CAtarray= "SELECT * FROM categories WHERE id=:catry";
                                $QyArrayC = $dbP -> prepare($CAtarray);
		                        $QyArrayC->bindParam(':catry',$cat,PDO::PARAM_STR);
                                $QyArrayC->execute();
                                $resArrayc=$QyArrayC->fetchAll(PDO::FETCH_OBJ);
                                $r1=0;
                                if($QyArrayC->rowCount() > 0){  
                                    foreach($resArrayc as $RArr){
                                        $mostrar=$RArr ->name;
                                        $id_name_cat = $RArr ->id;
                                        $Total_products = 0;
                                        $Total_money_pp=0;
                                        if(!in_array($id_name_cat,$ymx)){
                                            echo  "<h3>$mostrar</h3>";
                                            $Sub2_DU= "SELECT * FROM products WHERE category_id=:sub2_2";
                                            $Sub2_QySell_cs = $dbP -> prepare($Sub2_DU);
		                                    $Sub2_QySell_cs->bindParam(':sub2_2',$id_name_cat,PDO::PARAM_STR);
                                            $Sub2_QySell_cs->execute();
                                            $Sub2_RESELLCS=$Sub2_QySell_cs->fetchAll(PDO::FETCH_OBJ);
                                            if($Sub2_QySell_cs->rowCount() > 0){  
                                                foreach($Sub2_RESELLCS as $Sub2_RCSS){
                                                    $cat_id_2 = $Sub2_RCSS ->id;
                                                    $Sub1_2DU= "SELECT * FROM transaction_sell_lines WHERE product_id=:sub1_2";
                                                    $Sub1_2QySell_cs = $dbP -> prepare($Sub1_2DU);
		                                            $Sub1_2QySell_cs->bindParam(':sub1_2',$cat_id_2,PDO::PARAM_STR);
                                                    $Sub1_2QySell_cs->execute();
                                                    $Sub1_2RESELLCS=$Sub1_2QySell_cs->fetchAll(PDO::FETCH_OBJ);
                                                    
                                                    if($Sub1_2QySell_cs->rowCount() > 0){  
                                                        foreach($Sub1_2RESELLCS as $Sub1_2RCSS){
                                                            $tid_2 = $Sub1_2RCSS->transaction_id;
                                                            $DU_2= "SELECT DISTINCT * FROM cash_register_transactions WHERE cash_register_id=:c_id_2 and transaction_type='sell' and transaction_id=:tid_2 and amount>'0'";
                                                            $QySell_cs2 = $dbP -> prepare($DU_2);
		                                                    $QySell_cs2->bindParam(':c_id_2',$IDReg,PDO::PARAM_STR);
		                                                    $QySell_cs2->bindParam(':tid_2',$tid_2,PDO::PARAM_STR);
                                                            $QySell_cs2->execute();
                                                            $RESELLCS2=$QySell_cs2->fetchAll(PDO::FETCH_OBJ);
                                                            
                                                            
                                                            if($QySell_cs2->rowCount() > 0){  
                                                                foreach($RESELLCS2 as $RCSS2){
                                                                    $defIdTr = $RCSS2->transaction_id;
                                                                    $definitive= "SELECT * FROM transaction_sell_lines WHERE product_id=:sub1_2_3 and transaction_id=:defIdTr";
                                                                    $qyD = $dbP -> prepare($definitive);
		                                                            $qyD->bindParam(':sub1_2_3',$cat_id_2,PDO::PARAM_STR);
		                                                            $qyD->bindParam(':defIdTr',$defIdTr,PDO::PARAM_STR);
                                                                    $qyD->execute();
                                                                    $resD=$qyD->fetchAll(PDO::FETCH_OBJ);
                                                                    
                                                                    if($qyD->rowCount() > 0){  
                                                                        foreach($resD as $rD){
                                                                              $Total_products = $Total_products+  $rD -> quantity;
                                                                              $money = $rD -> quantity * $rD -> unit_price_inc_tax;
                                                                              $Total_money_pp= $Total_money_pp + $money;
                                                                              $id_trs_csh_ship= $rD -> transaction_id;
                                                                              
                                                                                $shipp= "SELECT * FROM transactions WHERE id=:id_ship";
                                                                                $qyShip = $dbP -> prepare($shipp);
		                                                                        $qyShip->bindParam(':id_ship',$id_trs_csh_ship,PDO::PARAM_STR);
                                                                                $qyShip->execute();
                                                                                $resShip=$qyShip->fetchAll(PDO::FETCH_OBJ);
                                                                                
                                                                                if($qyShip->rowCount() > 0){  
                                                                                    foreach($resShip as $ShipR){
                                                                                        $Ship_total = $Ship_total + $ShipR -> shipping_charges;
                                                                                    }
                                                                                }
                                                                                
                                                                        }
                                                                    }  
                                                                }
                                                            }
                                                             
                                                        }
                                                    }
                                                }   echo "  Vendidos: ". number_format($Total_products) . " </br>";
                                                echo "$".number_format($Total_money_pp,2) . " </br></br>";   
                                            }
                                            $ymx[$x]=$id_name_cat;
                                        }
                                        
                                    }
                                }    
                                
                                
                            }
                        }
                        
                        
                        
                        $x++;
                    }
                }
                
            }
            
        } 
        echo "</br><h4>Total en ventas: $".number_format($TOTAL_all,2) ."</h4>"; 
        echo "<h5>(Cargos de envío: $". number_format($Ship_total,2).")</h5>";
        echo "<hr/>";
        echo " <h1>Retiros</h1>";
        $RetSCH = "SELECT * FROM cash_register_transactions WHERE transaction_type='retiro' and cash_register_id=:c_id_reg";
        $QyRetCh = $dbP -> prepare($RetSCH);
        $QyRetCh->bindParam(':c_id_reg',$IDReg,PDO::PARAM_STR);
        $QyRetCh->execute();
        $RETSCH=$QyRetCh->fetchAll(PDO::FETCH_OBJ);
        if($QyRetCh->rowCount() > 0){  
                foreach($RETSCH as $RHS){
                    $monto = $RHS->amount;
                    $date_ret = $RHS->created_at;
                    echo "$date_ret</br>
                        Total: $$monto
                        </br></br>";
                }
        }
        echo "<h4>Total en retiros: -$".number_format($RETIROS,2) ."</h4>";
        
            echo "<hr/>";
            echo " <h1>Devoluciones</h1>";
        $SEARCH= "SELECT DISTINCT transaction_id, amount, name_auth, id FROM cash_register_transactions WHERE cash_register_id=:idcash and amount>'0' and transaction_type='refund'";
        $QyBar = $dbP -> prepare($SEARCH);
		$QyBar->bindParam(':idcash',$IDReg,PDO::PARAM_STR);
        $QyBar->execute();
        $AswR=$QyBar->fetchAll(PDO::FETCH_OBJ);
        if($QyBar->rowCount() > 0){  
                foreach($AswR as $AR){
                    $IDtr = $AR->transaction_id;
                    $Tdue = $AR->amount;
                    $AUTH_NAME = $AR->name_auth;
                    echo "</br>Autorizado por:  </br>$AUTH_NAME";
                    
                    
                    $transSrch= "SELECT * FROM transaction_sell_lines WHERE transaction_id=:trid ";
                    $QyTrs = $dbP -> prepare($transSrch);
		            $QyTrs->bindParam(':trid',$IDtr,PDO::PARAM_STR);
                    $QyTrs->execute();
                    $ResTrs=$QyTrs->fetchAll(PDO::FETCH_OBJ);
                    if($QyTrs->rowCount() > 0){  
                        foreach($ResTrs as $RT){
                            $IDpr = $RT->product_id;
                            $qtyy = $RT->quantity;
                            
                            $locatePrd= "SELECT * FROM products WHERE id=:idprd ";
                            $QyPrd = $dbP -> prepare($locatePrd);
		                    $QyPrd->bindParam(':idprd',$IDpr,PDO::PARAM_STR);
                            $QyPrd->execute();
                            $ResPrd=$QyPrd->fetchAll(PDO::FETCH_OBJ);
                            if($QyPrd->rowCount() > 0){  
                                foreach($ResPrd as $RP){
                                    $IDbr = $RP->brand_id;
                                    
                                    $locBrand= "SELECT * FROM brands WHERE id=:idbrd ";
                                    $QyBrd = $dbP -> prepare($locBrand);
		                            $QyBrd->bindParam(':idbrd',$IDbr,PDO::PARAM_STR);
                                    $QyBrd->execute();
                                    $ResBrd=$QyBrd->fetchAll(PDO::FETCH_OBJ);
                                    if($QyBrd->rowCount() > 0){  
                                        foreach($ResBrd as $RB){
                                            $nameBrd = $RB->name;
                                            $sIdBr = $RB->id;
                                            echo "Marca: $nameBrd";
                                        }
                                    }
                                    $invoice= "SELECT * FROM transactions WHERE return_parent_id=:fact ";
                                    $QyInvc = $dbP -> prepare($invoice);
		                            $QyInvc->bindParam(':fact',$IDtr,PDO::PARAM_STR);
                                    $QyInvc->execute();
                                    $ResInvc=$QyInvc->fetchAll(PDO::FETCH_OBJ);
                                    if($QyInvc->rowCount() > 0){  
                                        foreach($ResInvc as $Riv){
                                            $fact = $Riv->invoice_no;
                                            $ftotal = $Riv->final_total;
                                        }
                                    }
                                    
                                }
                            }
                        }
                    }
                    echo "</br>Ticket: $fact </br>Total: $$Tdue </br></br>";
                }
            }
            else{
                echo " <h4>No hay devoluciones</h4>";
            }
            echo "<h4>Total en devoluciones: -$".number_format($REFOUND,2)." </h4>";
            
            echo "<hr/>";
            $FTotal = $Total + $Tarjeta;
            echo " <h1>Gastos</h1>";
            echo " Gastos por $NAME </br>";
            $invoice= "SELECT * FROM cash_register_transactions WHERE cash_register_id=:cash_id AND transaction_type='gasto'";
            $QyInvc = $dbP -> prepare($invoice);
		    $QyInvc->bindParam(':cash_id',$IDReg,PDO::PARAM_STR);
            $QyInvc->execute();
            $ResInvc=$QyInvc->fetchAll(PDO::FETCH_OBJ);
            if($QyInvc->rowCount() > 0){  
                foreach($ResInvc as $Riv){
                    $id_tr_csh = $Riv->transaction_id;
                    
                    $trans_chs= "SELECT * FROM transactions WHERE id=:id_t";
                    $QyTrCsh = $dbP -> prepare($trans_chs);
		            $QyTrCsh->bindParam(':id_t',$id_tr_csh,PDO::PARAM_STR);
                    $QyTrCsh->execute();
                    $ResQYTR=$QyTrCsh->fetchAll(PDO::FETCH_OBJ);
                    if($QyTrCsh->rowCount() > 0){  
                        foreach($ResQYTR as $RQY){
                            $fact = $RQY->ref_no;
                            $ftotal = $RQY->final_total;
                            $trdate = $RQY->transaction_date;
                            $AUTH = $RQY->auth;
                            $DESCTP = $RQY->additional_notes;
                                    if($AUTH==1){
                                        echo "</br> $fact </br>Total: $$ftotal </br>
                                        Descripcion:</br>
                                        <textarea readonly style='border: none; resize: none;' rows=2 cols=30>  $DESCTP</textarea>
                                       </br>";
                                        $GASTOS = $GASTOS + $ftotal;
                                    }
                                    else{
                                        echo " <h4>No hay gastos</h4>";
                                    }
                             }
                    }
                    else{
                        echo " <h4>No hay gastos</h4>";
                    }
                        
                }
            }
            echo "<h4>Total en gastos: -$".number_format($GASTO,2) ."</h4>";
            
            echo "</br>";
            echo "<hr/>";
            $EFECTIVO_D=0;
            $CARD_D=0;
            $FONDO=0;
            $ENTREGADO=0;
            $SearchCashReg = "SELECT  * from cash_registers WHERE id=:c_id_s";
            $QyCashReg = $dbP -> prepare($SearchCashReg);
            $QyCashReg->bindParam(':c_id_s',$IDReg,PDO::PARAM_STR);
            $QyCashReg->execute();
            $ResultCashReg=$QyCashReg->fetchAll(PDO::FETCH_OBJ);
            if($QyCashReg->rowCount() > 0){
                foreach($ResultCashReg as $RG){
                    $EFECTIVO_D= $RG->closing_amount;
                    $CARD_D=$RG->total_card_slips;
                    $FONDO=$RG->total_cheques;
                }
            }
            $MSG_STS="";
            $TOTAL_IN_CASH= $VENTA + $INHAND - $REFOUND - $GASTO - $TRANSFER - $RETIROS;
            $DIFERED = $EFECTIVO_D-$TOTAL_IN_CASH;
            $DIFERTD = $CARD_D-$CARD;
            $ENTREGADO=$EFECTIVO_D-$FONDO;
            if($DIFERED==0){$MSG_STS="<b>(CORTE CORRECTO)</b>";}
            if($DIFERED<0){$MSG_STS="<b>FALTANTE: $".number_format(($DIFERED*-1),2)."</b>";}
            if($DIFERED>0){$MSG_STS="<b>SOBRANTE: $".number_format($DIFERED,2)."</b>";}
            echo "
            CAJA INICIAL: $".number_format($INHAND,2) ." </br> --- </br>
            EFECTIVO: $".number_format($TOTAL_IN_CASH,2)." </br> DECLARADO: $".number_format($EFECTIVO_D,2)."</br> <b>DIFERENCIA: $".number_format($DIFERED,2)."</b></br> --- </br>
            TARJETA: $".number_format($CARD,2)." </br> DECLARADO: $".number_format($CARD_D,2)."</br> <b>DIFERENCIA: $".number_format($DIFERTD,2)."</br> --- </br>";
            echo "FONDO APARTADO: $".number_format($FONDO,2)." </br> <b>EFECTIVO ENTREGADO: $".number_format($ENTREGADO,2)."</b></br>$MSG_STS";
            $today = date("d-m-Y");
                                                        
            require_once('Mail/config.php');
            $Auth = "SELECT * from pin WHERE mail IS NOT NULL";
            $qyAPss = $dbP -> prepare($Auth);
            $qyAPss->execute();
            $rsAPss=$qyAPss->fetchAll(PDO::FETCH_OBJ);
            if($qyAPss->rowCount() > 0){  
                foreach($rsAPss as $RAP){
                    $userMail=$RAP->mail;
                    $nip=$RAP->pin;
                    $idadm=$RAP->id;
                    
                    
                    
            $mail->ClearAllRecipients();
            $mail->AddAddress("$userMail");
            $mail->IsHTML(true);  //podemos activar o desactivar HTML en mensaje
            $mail->Subject = 'CORTE';

            $msg = "
            <h2>Hola MULTI MARCAS te presenta el corte del dia $today por $NAME</h2>
            <p>Ahora te incluimos todos los detalles:</p>
            <h4>
            No. REGISTRO: $IDReg </br> 
            USUARIO: $NAME </br> 
            <hr/>
            <h4>Link con los  <a href='https://sys.multi-marcas.com/public/util/consult.php?id=". $_GET["id"]."&uid=" .$_GET["uid"] ."' target='popup'
            onClick='window.open(this.href, this.target, 'toolbar=1 , location=1 , 
            status=0 , menubar=0 , scrollbars=1 , resizable=0 ,left=200pt,top=150pt,width=1100px,height=550'); 
            return true;'>
            <i class='btn btn-warning' title='AUTORIZA EL GASTO'>
            DETALLES</i></a>
            
            </h4>";
            $foot = "
           <p> CAJA INICIAL: $".number_format($INHAND,2) ."</p>
            <p>EFECTIVO: $".number_format($TOTAL_IN_CASH,2)."  DECLARADO: $".number_format($EFECTIVO_D)."</p> 
            <p><b>DIFERENCIA: $".number_format($DIFERED,2)."</p>
            <p>TARJETA: $".number_format($CARD,2)." DECLARADO: ".number_format($CARD_D)."</p> 
            <p><b>DIFERENCIA: $".number_format($DIFERTD,2)."</b></p>";
            $mail->Body    = $msg;
            $mail->Send();}}
                                                        
            
            echo "</b></div></body>
    </html>";                                           
           // echo "<script>window.location.href = '/home'</script>";
?>            