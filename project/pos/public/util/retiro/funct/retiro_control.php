<?php

    date_default_timezone_set('UTC');
    date_default_timezone_set("America/Mexico_City");
    include('../../conect.php');
    require_once('../../Mail/config.php');
    $CAJA = $_POST['cashreg'];
    $FECHA = date("Y-m-d H:i:s");
    $RETIRO = $_POST['cash'];
    $REFERENCIA = "RETIRO.".date('dmYHis').$CAJA;
    $LOCATION = $_POST['location'];
    
    $counter = "SELECT  * from cash_register_transactions WHERE transaction_type='retiro'";
        $qyCount = $dbP -> prepare($counter);
        $qyCount->execute();
        $qyCount->fetchAll(PDO::FETCH_OBJ);
        $TTl = $qyCount->rowCount();
    
    
    
        $SearchTrCshReg = "SELECT  * from cash_register_transactions WHERE cash_register_id=:c_id";
        $QyTransCR = $dbP -> prepare($SearchTrCshReg);
        $QyTransCR->bindParam(':c_id',$CAJA,PDO::PARAM_STR);
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
                if($TYPE == "initial"){$INHAND = $INHAND + $AMOUNT;}
                if($TYPE == "retiro"){$RETIROS = $RETIROS + $AMOUNT;}
                if($TYPE == "transfer"){$TRANSFER = $TRANSFER + $AMOUNT;}
            }
        }
            $TOTAL_IN_CASH= $VENTA + $INHAND - $REFOUND - $GASTO - $TRANSFER - $RETIROS;
            $VALUE= $TOTAL_IN_CASH + 500;
    
    if($RETIRO <= $VALUE){
    $InsertCash = "INSERT INTO 
    cash_register_transactions( cash_register_id, amount,pay_method,type,transaction_type,created_at,updated_at,retiro_ref) 
                        values( :cashid,:monto,'cash','debit','retiro',:fecha,:fecha, :ref)";
        $QyCsh = $dbP -> prepare($InsertCash);
        $QyCsh->bindParam(':cashid',$CAJA,PDO::PARAM_STR);
        $QyCsh->bindParam(':monto',$RETIRO,PDO::PARAM_STR);
        $QyCsh->bindParam(':fecha',$FECHA,PDO::PARAM_STR);
        $QyCsh->bindParam(':ref',$REFERENCIA,PDO::PARAM_STR);
        $QyCsh->execute();
        
        
        $lastInsertId = $dbP->lastInsertId();
        
        if($lastInsertId){
            echo "<script type=''>alert('Agregado correctamente');</script>
                    <script type='text/javascript'>
                        function imprimirX() {
                            if (window.print) {
                                window.print();
                            } else {
                                alert('La función de impresion no esta soportada por su navegador.');
                            }
                        }
                    </script>
                    <body onload='imprimirX();'>
                    <div align='center'>
                    <h3>Retiro. ".($TTl+1)."</h3>
                        </br>$LOCATION
                        <h3>$REFERENCIA</h3>
                        <h4>Cantidad:</h4>$".number_format($RETIRO,2)."</br>
                        </br>Fecha: ".date('H:i d-m-Y')."</br>
                        <h4>Retirado por: </h4></br></br>
                        <hr/>Nombre y Firma
                    </div>
                    </body>
                    
            ";  
        }
    else {echo "<script type=''>alert('ERROR: CONEXION RECHAZADA MYSQL');</script>";}
    }
     else {echo "<script type=''>alert('LA CANTIDAD DEL RETIRO NO PUEDE SER MUCHO MAYOR QUE LA DEL SISTEMA');</script>";}
    
    

?>