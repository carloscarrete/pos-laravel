<div class="row">
  <div class="col-md-12">
    <hr>
    <h3>@lang('lang_v1.product_sold_details_register')</h3>
    <table class="table">
      <tr>
        <th>#</th>
        <th>@lang('brand.brands')</th>
        <th>@lang('sale.qty')</th>
        <th class="hidden">@lang('sale.total_amount')</th>
      </tr>
      @php
        $total_amount = 0;
        $total_quantity = 0;
      @endphp
      @foreach($details['product_details'] as $detail)
        <tr>
          <td>
            {{$loop->iteration}}.
          </td>
          <td>
            {{$detail->brand_name}}
          </td>
          <td>
            {{ number_format($detail->total_quantity)}}
            @php
              $total_quantity += $detail->total_quantity;
            @endphp
          </td>
          <td class="hidden">
            <span class="display_currency" data-currency_symbol="true">
              {{$detail->total_amount}}
            </span>
            @php
              number_format($total_amount += $detail->total_amount);
            @endphp
          </td>
        </tr>
      @endforeach

      
      @php
        $total_amount += ($details['transaction_details']->total_tax - $details['transaction_details']->total_discount);
      @endphp

    </table>
  </div>
</div>