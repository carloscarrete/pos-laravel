<?php
  error_reporting(0);
include('conect.php');
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");


                                          if(isset($_POST['add'])){
                                                
                                            
                                            
                                            
                                            //Grabar Devolucion
                                                $no=1;
                                                $TDY_i=date("Y-m-d")." 00:00:00";
                                                $TDY_f=date("Y-m-d")." 23:59:59";
                                                $CshRefund="SELECT * FROM cash_register_transactions WHERE created_at BETWEEN :TDI_i AND :TDI_f";
                                                $SelReund = $dbP -> prepare($CshRefund);
                                                $SelReund->bindParam(':TDI_i',$TDY_i,PDO::PARAM_STR);
                                                $SelReund->bindParam(':TDI_f',$TDY_f,PDO::PARAM_STR);
                                                $SelReund->execute();
                                                $R_SR=$SelReund->fetchAll(PDO::FETCH_OBJ);
                                                if($SelReund->rowCount() > 0){  
                                                    foreach($R_SR as $RSR){
                                                        $Type=$RSR->transaction_type;
                                                        if($Type=='refund'){ $no++;}
                                                       
                                                    }
                                                }
                                                
                                                
                                                
                                                $name_client=$_POST["contact"];
                                                $TodayIS=date("Y-m-d h:i:s");
                                                $vence = strtotime ( '+30 day' , strtotime ( $TodayIS ) ); $vence= date ( 'd-m-Y' , $vence );
                                                $referencia =$_POST["referencia"];
                                                $limit=$_POST["rows"];
                                                $total_due =0;
                                                $eps=$_POST["bussines"];
                                                $leps=$_POST["loction"];
                                                $sucs=$_POST["location"];
                                                $typeT="sell_return";
                                                $StST="final";
                                                $iq=0;
                                                $paySts="paid";
                                                $contID=$_POST["contID"];
                                                $today=date("d/m/Y");
                                                $hour=date("his");
                                                $transID=$_POST["trnid"];
                                                $invNo="VALE.$today-$no";
                                                $tranDate = $_POST["datasell"];
                                                
                                                for($x=1; $x<=$limit; $x++){
                                                    $mnger[$x]=$_POST["MST$x"];
                                                    $qty[$x]=$_POST["dqty$x"];
                                                    $pcs[$x]=$_POST["mxn$x"];
                                                    $stm[$x]=$_POST["dcsn$x"];
                                                    $prod_id[$x] = $_POST["idp$x"];
                                                    $var_id[$x] = $_POST["idv$x"];
                                                    $sub_total[$x] = $pcs[$x]*$qty[$x];
                                                    $total_due = $total_due + $sub_total[$x];
                                                    
                                                    $UPdateTab="UPDATE transaction_sell_lines SET quantity_returned = quantity_returned + :qty_rtrn 
                                                                WHERE transaction_id = :trns_id 
                                                                AND product_id = :prod_id
                                                                AND variation_id =:vrnt_id";
                                                    $UpQry = $dbP -> prepare($UPdateTab);
                                                    $UpQry->bindParam(':trns_id',$transID,PDO::PARAM_STR);
                                                    $UpQry->bindParam(':prod_id',$prod_id[$x],PDO::PARAM_STR);
                                                    $UpQry->bindParam(':vrnt_id',$var_id[$x],PDO::PARAM_STR);
                                                    $UpQry->bindParam(':qty_rtrn',$qty[$x],PDO::PARAM_STR);
                                                    $UpQry->execute();
                                                    
                                                    if($mnger[$x]==1){
                                                        $UPdateTab2="UPDATE variation_location_details SET qty_available = qty_available + :return
                                                        WHERE product_id=:p_id
                                                        AND variation_id=:v_id
                                                        AND location_id=:loc_id";
                                                        $UpQry2 = $dbP -> prepare($UPdateTab2);
                                                        $UpQry2->bindParam(':return',$qty[$x],PDO::PARAM_STR);
                                                        $UpQry2->bindParam(':p_id',$prod_id[$x],PDO::PARAM_STR);
                                                        $UpQry2->bindParam(':v_id',$var_id[$x],PDO::PARAM_STR);
                                                        $UpQry2->bindParam(':loc_id',$leps,PDO::PARAM_STR);
                                                        $UpQry2->execute();
                                                    }
                                                }
                                                $tbtx=$total_due;
                                                $txmn=0;
                                                $shpSh=0;
                                                $total=$total_due+$txmn+$shpSh;
                                                
                                                $ID_Cash=$_POST["cashreg"];
                                                $Cash_Insert="INSERT INTO 
                                                    cash_register_transactions(cash_register_id, amount, pay_method, type, transaction_type, transaction_id, created_at, updated_at)
                                                    values(:cash_reg, :cash_reg_total, 'cash', 'debit', 'refund', :cash_reg_trns, :date, :date)";
                                                $QyCsh = $dbP -> prepare($Cash_Insert);
                                                $QyCsh->bindParam(':cash_reg',$ID_Cash,PDO::PARAM_STR);      $QyCsh->bindParam(':cash_reg_total',$total,PDO::PARAM_STR);
                                                $QyCsh->bindParam(':cash_reg_trns',$transID,PDO::PARAM_STR); $QyCsh->bindParam(':date',$TodayIS,PDO::PARAM_STR);
                                                $QyCsh->execute();
                                                
                                                
                                                $IsDS=0;
                                                $IsS=0;
                                                $ExRt=1;
                                                $ParentID=$transID;
                                                $CreatedBy=$_POST["emp_id"];
                                                $Createdat = date("Y-m-d h:i:s");
                                                $Trns_Insert="INSERT INTO transactions(business_id, location_id, type, status, is_quotation, payment_status,
                                                contact_id, invoice_no, transaction_date, total_before_tax, tax_amount,shipping_charges, final_total, is_direct_sale, is_suspend, 
                                                exchange_rate, return_parent_id, created_by, created_at, updated_at) 
                                                                                values(:bid, :lbid, :type, :sts, :iq, :paysts,
                                                :cnid, :inid, :trdte, :tbtx, :txmnt, :shS, :total, :isdS, :isSP, 
                                                :exrte, :parent, :createby, :date, :date)";
                                                $Qry = $dbP -> prepare($Trns_Insert);
                                                $Qry->bindParam(':bid',$eps,PDO::PARAM_STR);    $Qry->bindParam(':lbid',$leps,PDO::PARAM_STR);
                                                $Qry->bindParam(':type',$typeT,PDO::PARAM_STR);    $Qry->bindParam(':sts',$StST,PDO::PARAM_STR);
                                                $Qry->bindParam(':iq',$iq,PDO::PARAM_STR);    $Qry->bindParam(':paysts',$paySts,PDO::PARAM_STR);
                                                $Qry->bindParam(':cnid',$contID,PDO::PARAM_STR);    $Qry->bindParam(':inid',$invNo,PDO::PARAM_STR);
                                                $Qry->bindParam(':trdte',$tranDate,PDO::PARAM_STR);    $Qry->bindParam(':tbtx',$tbtx,PDO::PARAM_STR);
                                                $Qry->bindParam(':txmnt',$txmn,PDO::PARAM_STR);    $Qry->bindParam(':shS',$shpSh,PDO::PARAM_STR);
                                                $Qry->bindParam(':total',$total,PDO::PARAM_STR);
                                                $Qry->bindParam(':isdS',$IsDS,PDO::PARAM_STR);    $Qry->bindParam(':isSP',$IsS,PDO::PARAM_STR);
                                                $Qry->bindParam(':exrte',$ExRt,PDO::PARAM_STR);    $Qry->bindParam(':parent',$ParentID,PDO::PARAM_STR);
                                                $Qry->bindParam(':createby',$CreatedBy,PDO::PARAM_STR); $Qry->bindParam(':date',$TodayIS,PDO::PARAM_STR);
                                                $Qry->execute();
                                                $lastInsertId = $dbP->lastInsertId();
                                                if($lastInsertId){
                                                    echo "<script type=''>alert('Total a regresar: $$total');</script>";
                                                    echo "<script type=''>alert('Agregado correctamente');</script>
                                                            <script type='text/javascript'>
                                                                function imprimir() {
                                                                    if (window.print) {
                                                                        window.print();
                                                                    } else {
                                                                        alert('La función de impresion no esta soportada por su navegador.');
                                                                    }
                                                                }
                                                            </script>
                                                            <body onload='imprimir();'>
                                                            <div align='center'>
                                                            
                                                            
                                                                <img align='center' src='/img/logo.png'  width='300' height='170'>
                                                                Fecha: ".date('H:i d-m-Y')."</br>
                                                                
                                                                Tienda: $sucs</br>
                                                                Cliente: $name_cliente
                                                                <h4>$invNo</h4>
                                                                    <table>
                                                                    <tr>
                                                                        <th style='border: hidden'>Producto</th>
                                                                        <th style='border: hidden'>Cantidad</th>
                                                                        <th style='border: hidden'>SubT</th>
                                                                        <th style='border: hidden'>Total</th>
                                                                    </tr>
                                                                    
                                                                ";
                                                                for($x=1; $x<=$limit; $x++){
                                                                    
                                                                    if($qty[$x]!=0){
                                                                    echo "<tr>";
                                                                    $iDp=$prod_id[$x];
                                                                        $BAR_sub = "SELECT * from products WHERE id=:iDp";
                                                                        $QyBar_sub = $dbP -> prepare($BAR_sub);
                                                                        $QyBar_sub->bindParam(':iDp',$iDp,PDO::PARAM_STR);
                                                                        $QyBar_sub->execute();
                                                                        $RsBar_sub=$QyBar_sub->fetchAll(PDO::FETCH_OBJ);
                                                                        if($QyBar_sub->rowCount() > 0){  
                                                                            foreach($RsBar_sub as $RB_sub){
                                                                                echo "<td align='right' style='border: hidden'>".$RB_sub ->name ."</td>";  
                                                                            }
                                                                        }
                                                                    echo " <td align='right' style='border: hidden'>".$qty[$x]."</td>";
                                                                    echo " <td align='right' style='border: hidden'>".$pcs[$x]."</td>";
                                                                   $sub_total[$x] = $pcs[$x]*$qty[$x];
                                                                    echo " <td align='right' style='border: hidden'>". number_format($sub_total[$x],2)."</td>";
                                                                    echo "</tr>"; 
                                                                        
                                                                    } 
                                                                              
                                                                }
                                                                   
                                                                echo "</table>
                                                                TOTAL: $".number_format($total,2)."</br>
                                                                
                                                                Devolucion de: $referencia</br>
                                                                
                                                                <h4>Devuelto por: </h4></br></br>
                                                                <hr/>Nombre y Firma
                                                                
                                                                <h5>Vence: $vence</h5>
                                                            </div>
                                                            </body>";
                                                    
                                                }
                                                else {
                                                    echo "<script type=''>alert('Error: Intentalo nuevamente si persiste el error contacta al soporte');</script>";
                                                }
                                            
                                           
                                            }
                                    ?>