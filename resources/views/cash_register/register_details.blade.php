<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">

    <div class="modal-header">
      <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h3 class="modal-title">@lang( 'cash_register.register_details' ) ( {{ \Carbon::createFromFormat('Y-m-d H:i:s', $register_details->open_time)->format('jS M, Y h:i A') }} - {{ \Carbon::now()->format('jS M, Y h:i A') }})</h3>
    </div>
    
    

    <div class="modal-footer">
      <button type="button" class="btn btn-primary no-print" 
        aria-label="Print" 
          onclick="$(this).closest('div.modal').printThis();">
        <i class="fa fa-print"></i> @lang( 'messages.print' )
      </button>

      <button type="button" class="btn btn-default no-print" 
        data-dismiss="modal">@lang( 'messages.cancel' )
      </button>
    </div>
    <div class="modal-body">
        <div class="row">
        <div class="col-sm-12">
          <b>@lang('report.user'):</b> {{ $register_details->user_name}}<br>
          <b>Email:</b> {{ $register_details->email}}
        </div>
      </div>
    </div>
      <div class="row">
        <div class="col-sm-12">
          <table class="table hidden">
            <tr>
              <td>
                @lang('cash_register.cash_in_hand'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->cash_in_hand }}</span>
              </td>
            </tr>
            <tr>
              <td>
                @lang('cash_register.cash_payment'):
              </th>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_cash }}</span>
              </td>
            </tr>
            <tr>
              <td>
                @lang('cash_register.checque_payment'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_cheque }}</span>
              </td>
            </tr>
            <tr>
              <td>
                @lang('cash_register.card_payment'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_card }}</span>
              </td>
            </tr>
            <tr>
              <td>
                @lang('cash_register.bank_transfer'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_bank_transfer }}</span>
              </td>
            </tr>
            @if(config('constants.enable_custom_payment_1'))
              <tr>
                <td>
                  @lang('lang_v1.custom_payment_1'):
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_1 }}</span>
                </td>
              </tr>
            @endif
            @if(config('constants.enable_custom_payment_2'))
              <tr>
                <td>
                  @lang('lang_v1.custom_payment_2'):
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_2 }}</span>
                </td>
              </tr>
            @endif
            @if(config('constants.enable_custom_payment_3'))
              <tr>
                <td>
                  @lang('lang_v1.custom_payment_3'):
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_3 }}</span>
                </td>
              </tr>
            @endif
            <tr>
              <td>
                @lang('cash_register.other_payments'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_other }}</span>
              </td>
            </tr>
            <tr>
              <td>
                @lang('cash_register.total_sales'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_sale }}</span>
              </td>
            </tr>
            <tr class="success">
              <th>
                @lang('cash_register.total_refund')
              </th>
              <td>
                <b><span class="display_currency" data-currency_symbol="true">{{ $register_details->total_refund }}</span></b><br>
                <small>
                @if($register_details->total_cash_refund != 0)
                  Cash: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_cash_refund }}</span><br>
                @endif
                @if($register_details->total_cheque_refund != 0) 
                  Cheque: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_cheque_refund }}</span><br>
                @endif
                @if($register_details->total_card_refund != 0) 
                  Card: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_card_refund }}</span><br> 
                @endif
                @if($register_details->total_bank_transfer_refund != 0)
                  Bank Transfer: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_bank_transfer_refund }}</span><br>
                @endif
                @if(config('constants.enable_custom_payment_1') && $register_details->total_custom_pay_1_refund != 0)
                    @lang('lang_v1.custom_payment_1'): <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_1_refund }}</span>
                @endif
                @if(config('constants.enable_custom_payment_2') && $register_details->total_custom_pay_2_refund != 0)
                    @lang('lang_v1.custom_payment_2'): <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_2_refund }}</span>
                @endif
                @if(config('constants.enable_custom_payment_3') && $register_details->total_custom_pay_3_refund != 0)
                    @lang('lang_v1.custom_payment_3'): <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_3_refund }}</span>
                @endif
                @if($register_details->total_other_refund != 0)
                  Other: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_other_refund }}</span>
                @endif
                </small>
              </td>
            </tr>
            <tr class="success">
              <th>
                @lang('cash_register.total_cash')
              </th>
              <td>
                <b><span class="display_currency" data-currency_symbol="true">{{ $register_details->cash_in_hand + $register_details->total_cash - $register_details->total_cash_refund }}</span></b>
              </td>
            </tr>
          </table> 
          
        <table class="table">
            
            <?php 
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");

$localhost = env('DB_HOST');
$user = env('DB_USERNAME');
$database = env('DB_DATABASE');
$dbpassword = env('DB_PASSWORD');

// Datos de la base de datos
define('DB_HOSTp4',"$localhost");
define('DB_USERp4',"$user");
define('DB_PASSp4',"$dbpassword");
define('DB_NAMEp4',"$database");


// Comando de conexion establesida m1
try
{
$dbP4 = new PDO("mysql:host=".DB_HOSTp4.";dbname=".DB_NAMEp4,DB_USERp4, DB_PASSp4,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $eP4)
{
exit("Error: " . $eP4->getMessage());
}


        $CAJA=0;
        $CARD = 0;
        $VENTA=0;
        $RETIRO=0;
        $REFOUND=0;
        $GASTO=0;
        $TRANSFER=0;
        $OH = $register_details->open_time;
        $id_user = $register_details->user_id;
       
        
       
        $SearchCashReg = "SELECT  * from cash_registers WHERE created_at=:oh AND user_id=:u_id";
        $QyCashReg = $dbP4 -> prepare($SearchCashReg);
        $QyCashReg->bindParam(':oh',$OH,PDO::PARAM_STR);
        $QyCashReg->bindParam(':u_id',$id_user,PDO::PARAM_STR);
        $QyCashReg->execute();
        $ResultCashReg=$QyCashReg->fetchAll(PDO::FETCH_OBJ);
        if($QyCashReg->rowCount() > 0){
            foreach($ResultCashReg as $RG){
                $CajaREG = $RG->id;
                $Efectivo_D= $RG->closing_amount;
                $Card_D=$RG->total_card_slips;
            }
        }
        
        $SearchTrCshReg = "SELECT  * from cash_register_transactions WHERE cash_register_id=:c_id";
        $QyTransCR = $dbP4 -> prepare($SearchTrCshReg);
        $QyTransCR->bindParam(':c_id',$CajaREG,PDO::PARAM_STR);
        $QyTransCR->execute();
        $ResultTCR=$QyTransCR->fetchAll(PDO::FETCH_OBJ);
        if($QyTransCR->rowCount() > 0){
            foreach($ResultTCR as $RTCR){
                $CASHREG = $RTCR->id;
                $TYPE = $RTCR->transaction_type;
                $AMOUNT = $RTCR->amount;
                $METHOD = $RTCR->pay_method;
                
                if($TYPE == "sell"){ 
                    if($METHOD == "cash"){ $VENTA= $VENTA +  $AMOUNT;}
                    if($METHOD == "card"){ $CARD= $CARD +  $AMOUNT;}
                }
                if($TYPE == "refund"){$REFOUND = $REFOUND + $AMOUNT;}
                if($TYPE == "gasto"){ 
                    $TID = $RTCR->transaction_id;
                    $SATH = "SELECT  * from transactions WHERE id=:id_trsi";
                    $qySATH = $dbP4 -> prepare($SATH);
                    $qySATH->bindParam(':id_trsi',$TID,PDO::PARAM_STR);
                    $qySATH->execute();
                    $RQYSTH=$qySATH->fetchAll(PDO::FETCH_OBJ);
                    if($qySATH->rowCount() > 0){
                        foreach($RQYSTH as $RHT){
                            $AUTH = $RHT->auth;
                        }
                    }
                    if($AUTH == 1){$GASTO = $GASTO + $AMOUNT;}
                }
                if($TYPE == "initial"){$CAJA = $CAJA + $AMOUNT;}
                if($TYPE == "retiro"){$RETIRO = $RETIRO + $AMOUNT;}
                if($TYPE == "transfer"){$TRANSFER = $TRANSFER + $AMOUNT;}
            }
        }
         $TOTAL_IN_CASH= $VENTA + $CAJA - $REFOUND - $GASTO - $TRANSFER - $RETIRO;
         
?>
        <tr class="">
            <td>
               Efectivo de ventas: 
            </td>
            <td>
                <?php echo "$". number_format($VENTA,2)?>
            </td>
        </tr>
        <tr class="">
            <td>
               Transferencias de ventas: 
            </td>
            <td>
                <?php echo "$". number_format($CARD,2)?>
            </td>
        </tr>
        <tr class="">
            <td>
               Dinero de caja: 
            </td>
            <td>
                <?php echo "$". number_format($CAJA,2)?>
            </td>
        </tr>
        <tr class="">
            <td>
               Reembolsado: 
            </td>
            <td>
                <?php echo "$". number_format($REFOUND,2)?>
            </td>
        </tr>
        <tr class="">
            <td>
               Retiros: 
            </td>
            <td>
                <?php echo "$". number_format($RETIRO,2)?>
            </td>
        </tr>
        <tr class="">
            <td>
               Gastos: 
            </td>
            <td>
                <?php echo "$". number_format($GASTO,2)?>
            </td>
        </tr>
        <tr class="success">
            <td>
              <b> TOTAL EN CAJA: </b>
            </td>
            <td>
              <b>  <?php echo "$". number_format($TOTAL_IN_CASH,2)?></b>
            </td>
        </tr>
        <tr class="">
            <td>
               Efectivo declarado: 
            </td>
            <td>
                <?php echo "$". number_format($Efectivo_D,2)?>
            </td>
        </tr>
        <tr class="">
            <td>
               Transacciones declarado: 
            </td>
            <td>
                <?php echo "$". number_format($Card_D,2)?>
            </td>
        </tr>
        <tr class="success">
            <td>
               <b>Diferencia en Efectivo: </b>
            </td>
            <td>
                <b>
                <?php 
                    $DIFERED = $Efectivo_D-$TOTAL_IN_CASH;
                    if($DIFERED>=0){echo "<font color='blue'>";}
                    else {echo "<font color='red'>";}
                    echo "$". number_format(($DIFERED),2). "</font>";
                ?>
                </b>
            </td>
        </tr>
        <tr class="success">
            <td>
               <b>Diferencia en Transacciones: </b>
            </td>
            <td>
                <b>
                <?php 
                    $DIFERTD = $Card_D-$CARD;
                    if($DIFERTD>=0){echo "<font color='blue'>";}
                    else {echo "<font color='red'>";}
                    echo "$". number_format(($DIFERTD),2). "</font>";
                ?>
                </b>
            </td>
        </tr>
    </table>
        </div>
      </div>
      
   

      @include('cash_register.register_product_details')
      
      
    
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->