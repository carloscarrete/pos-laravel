<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    {!! Form::open(['url' => action('CashRegisterController@postCloseRegister'), 'method' => 'post' ]) !!}
    <div class="modal-header">
      
      <h3 class="modal-title hidden">@lang( 'cash_register.current_register' ) ( {{ \Carbon::createFromFormat('Y-m-d H:i:s', $register_details->open_time)->format('jS M, Y h:i A') }} - {{ \Carbon::now()->format('jS M, Y h:i A') }})</h3>
    </div>

    <div class="modal-body">
        
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
                @lang('cash_register.total.exp')
              </th> 
              <td>
                  x
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
        </div>
      </div>
        <h3 class="modal-title">DECRALACION DE CIERRE</h3>
      <div class="row">
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('closing_amount', __( 'cash_register.total_cash' ) . ':*') !!} @show_tooltip(__('tooltip.cash'))
              {!! Form::number('closing_amount', @num_format(0), ['class' => 'form-control input_number', 'required', 'placeholder' => __( 'cash_register.total_cash' ), 'min' => 0, 'max' => 9999 ]); !!}
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('total_card_slips', __( 'cash_register.total_card_slips' ) . ':*') !!} @show_tooltip(__('tooltip.card'))
              {!! Form::number('total_card_slips', @num_format(0), ['class' => 'form-control input_number', 'required', 'placeholder' => __( 'cash_register.total_card_slips' ), 'min' => 0, 'max' => 9999 ]); !!}
          </div>
        </div> 
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('total_cheques', __( 'cash_register.total_cheques' ) . ':*') !!} @show_tooltip(__('tooltip.caja'))
              {!! Form::number('total_cheques', @num_format(0), ['class' => 'form-control', 'required', 'placeholder' => __( 'cash_register.total_cheques' ), 'min' => 0, 'max' => 9999 ]); !!}
          </div>
        </div> 
        <div class="col-sm-12">
          <div class="form-group">
            {!! Form::label('closing_note', __( 'cash_register.closing_note' ) . ':') !!}
              {!! Form::textarea('closing_note', null, ['class' => 'form-control', 'placeholder' => __( 'cash_register.closing_note_desc' ), 'rows' => 3, 'required' ]); !!}
          </div>
        </div>
        <div class="col-sm-2 hidden">
          <div class="form-group">
            {!! Form::label('TOTAL_R', __( 'cash_register.TOTAL_R' ) . ':') !!}
              {!! Form::textarea('TOTAL_R', $register_details->cash_in_hand + $register_details->total_cash - $register_details->total_cash_refund, ['class' => 'form-control', 'rows' => 3 ]); !!}
          </div>
        </div>
        <div class="col-sm-2 hidden">
          <div class="form-group">
            {!! Form::label('caja', __( 'cash_register.caja' ) . ':') !!}
              {!! Form::textarea('caja', $register_details->cash_in_hand, ['class' => 'form-control', 'rows' => 3 ]); !!}
          </div>
        </div>
        <div class="col-sm-2 hidden">
          <div class="form-group">
            {!! Form::label('efectivo', __( 'cash_register.efectivo' ) . ':') !!}
              {!! Form::textarea('efectivo', $register_details->total_cash, ['class' => 'form-control', 'rows' => 3 ]); !!}
          </div>
        </div>
        <div class="col-sm-2 hidden">
          <div class="form-group">
            {!! Form::label('tarjeta', __( 'cash_register.tarjeta' ) . ':') !!}
              {!! Form::textarea('tarjeta', $register_details->total_card, ['class' => 'form-control', 'rows' => 3 ]); !!}
          </div>
        </div>
        <div class="col-sm-2 hidden">
          <div class="form-group">
            {!! Form::label('reembolso', __( 'cash_register.reembolso' ) . ':') !!}
              {!! Form::textarea('reembolso', $register_details->total_refund, ['class' => 'form-control', 'rows' => 3 ]); !!}
          </div>
        </div>
      </div> 
    </div>
    <div class="modal-footer">
      <button type="button"  class="btn btn-default" data-dismiss="modal">@lang( 'messages.cancel' )</button>
      <button type="submit" class="btn btn-primary">@lang( 'cash_register.close_register' )</button>
    </div>
     
            
    {!! Form::close() !!}
    @include('cash_register.register_product_details')
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->