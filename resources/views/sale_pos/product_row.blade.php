<?php
$localhost = env('DB_HOST');
$user = env('DB_USERNAME');
$database = env('DB_DATABASE');
$dbpassword = env('DB_PASSWORD');



                            // Datos de la base de datos
                            define('DB_HOSTp',"$localhost");
                            define('DB_USERp',"$user");
                            define('DB_PASSp',"$dbpassword");
                            define('DB_NAMEp',"$database");
                            
                            
                            // Comando de conexion establesida m1
                            try
                            {
                            $dbP = new PDO("mysql:host=".DB_HOSTp.";dbname=".DB_NAMEp,DB_USERp, DB_PASSp,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                            }
                            catch (PDOException $eP)
                            {
                            exit("Error: " . $eP->getMessage());
                            }
                            ?>


<tr class="product_row" data-row_index="{{$row_count}}">
	<td>
		@php
			$product_name = $product->product_name . '<br/>' . $product->sub_sku ;
			if(!empty($product->brand)){ $product_name .= ' ' . $product->brand ;}
		@endphp
		<?php
		$sku= $product->sub_sku ;
		$cod= $sku;
                                $SEARCH= "SELECT * FROM variations WHERE sub_sku=:cod_v";
                                $QyBar = $dbP -> prepare($SEARCH);
		                        $QyBar->bindParam(':cod_v',$cod,PDO::PARAM_STR);
                                $QyBar->execute();
                                $RsBar=$QyBar->fetchAll(PDO::FETCH_OBJ);
                                if($QyBar->rowCount() > 0){  
                                        foreach($RsBar as $RB){
                                            $ID_V=$RB -> product_id;
                                            $DPP_inc_tax=$RB -> dpp_inc_tax;
                                            $DPP_exc_tax=$RB -> default_purchase_price;
                                            $DSP_inc_tax=$RB -> sell_price_inc_tax;
                                            $DSP_exc_tax=$RB -> default_sell_price;
                                            
                                        }
                                    }
                                $cod_P=$ID_V;
                                $DPPIT=$DPP_inc_tax;
                                $DPPET=$DPP_exc_tax;
                                $DSPIT=$DSP_inc_tax;
                                $DSPET=$DSP_exc_tax;
		
                                $BAR = "SELECT * from products WHERE id=:cod";
                                $QyBar = $dbP -> prepare($BAR);
                                $QyBar->bindParam(':cod',$cod_P,PDO::PARAM_STR);
                                $QyBar->execute();
                                $RsBar=$QyBar->fetchAll(PDO::FETCH_OBJ);
                                    if($QyBar->rowCount() > 0){  
                                        foreach($RsBar as $RB){
                                            $C1=$RB -> product_custom_field1;
                                            $P1=$RB -> pct_1;
                                            $C2=$RB -> product_custom_field2;
                                            $P2=$RB -> pct_2;
                                            $C3=$RB -> product_custom_field3;
                                            $P3=$RB -> pct_3;
                                            $C4=$RB -> product_custom_field4;
                                            $P4=$RB -> pct_4;
                                            $InEx = $RB -> tax_type;
                                            
                                        }
                                    }
                                    $RESULT = $InEx;
                                    $include="inclusive";
                                    $exclude="exclusive";
                                    
                                    if(strcmp($RESULT,$exclude)== 0){
                                    $default_buy_price = $DPPET;
                                    $default_selling_price = $DSPET;
                                    }
                                    if(strcmp($RESULT,$include)== 0){
                                    $default_buy_price = $DPPIT;
                                    $default_selling_price = $DSPIT;
                                    }
                                    
                                    $order = array("$C1","$C2","$C3","$C4");
                                    $descn = array("$P1","$P2","$P3","$P4");
                                    
                                    array_multisort($order, $descn);
                                    
                                    
        ?>

		@if(auth()->user()->can('edit_product_price_from_sale_screen') || auth()->user()->can('edit_product_discount_from_sale_screen') )
		<div data-toggle="tooltip" data-placement="bottom" title="@lang('lang_v1.pos_edit_product_price_help')">
		<span class="text-link text-info cursor-pointer" data-toggle="modal" data-target="#row_edit_product_price_modal_{{$row_count}}">
			{!! $product_name !!}
			&nbsp;<i class="fa fa-info-circle"></i>
		</span>
		</div>
		@else
			{!! $product_name !!}
		@endif
		
		<input type="hidden" class="enable_sr_no" value="{{$product->enable_sr_no}}">
		<div data-toggle="tooltip" data-placement="bottom" title="@lang('lang_v1.add_description')">
			<i class="fa fa-commenting cursor-pointer text-primary add-pos-row-description" data-toggle="modal" data-target="#row_description_modal_{{$row_count}}"></i>
		</div>

		@php
			$hide_tax = 'hide';
			
	        if(session()->get('business.enable_inline_tax') == 1){
	            
	            $hide_tax = '';
	        }
	        
			$tax_id = $product->tax_id;
			$item_tax = !empty($product->item_tax) ? $product->item_tax : 0;
			
			$unit_price_inc_tax = $product->sell_price_inc_tax;
			
			
			if($hide_tax == 'hide'){
				$tax_id = null;
				$unit_price_inc_tax = $product->default_sell_price;
				
			}
			
			
		@endphp

		<div class="modal fade row_edit_product_price_model" id="row_edit_product_price_modal_{{$row_count}}" tabindex="-1" role="dialog">
			@include('sale_pos.partials.row_edit_product_price_modal')
		</div>

		<!-- Description modal start -->
		<div class="modal fade row_description_modal" id="row_description_modal_{{$row_count}}" tabindex="-1" role="dialog">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">{{$product->product_name}} - {{$product->sub_sku}}</h4>
		      </div>
		      <div class="modal-body">
		      	<div class="form-group">
		      		<label>@lang('lang_v1.description')</label>
		      		@php
		      			$sell_line_note = '';
		      			if(!empty($product->sell_line_note)){
		      				$sell_line_note = $product->sell_line_note;
		      			}
		      		@endphp
		      		<textarea class="form-control" name="products[{{$row_count}}][sell_line_note]" rows="3">{{$sell_line_note}}</textarea>
		      		<p class="help-block">@lang('lang_v1.sell_line_description_help')</p>
		      	</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
		      </div>
		    </div>
		  </div>
		</div>
		<!-- Description modal end -->
		@if(in_array('modifiers' , $enabled_modules))
			<div class="modifiers_html">
				@if(!empty($product->product_ms))
					@include('restaurant.product_modifier_set.modifier_for_product', array('edit_modifiers' => true, 'row_count' => $loop->index, 'product_ms' => $product->product_ms ) )
				@endif
			</div>
		@endif

		@php
			$max_qty_rule = $product->qty_available;
			$max_qty_msg = __('validation.custom-messages.quantity_not_available', ['qty'=> $product->formatted_qty_available, 'unit' => $product->unit  ]);
		@endphp

		@if( session()->get('business.enable_lot_number') == 1 || session()->get('business.enable_product_expiry') == 1)
		@php
			$lot_enabled = session()->get('business.enable_lot_number');
			$exp_enabled = session()->get('business.enable_product_expiry');
			$lot_no_line_id = '';
			if(!empty($product->lot_no_line_id)){
				$lot_no_line_id = $product->lot_no_line_id;
			}
		@endphp
		@if(!empty($product->lot_numbers))
			<select class="form-control lot_number" name="products[{{$row_count}}][lot_no_line_id]" @if(!empty($product->transaction_sell_lines_id)) disabled @endif>
				<option value="">@lang('lang_v1.lot_n_expiry')</option>
				@foreach($product->lot_numbers as $lot_number)
					@php
						$selected = "";
						if($lot_number->purchase_line_id == $lot_no_line_id){
							$selected = "selected";

							$max_qty_rule = $lot_number->qty_available;
							$max_qty_msg = __('lang_v1.quantity_error_msg_in_lot', ['qty'=> $lot_number->qty_formated, 'unit' => $product->unit  ]);
						}

						$expiry_text = '';
						if($exp_enabled == 1 && !empty($lot_number->exp_date)){
							if( \Carbon::now()->gt(\Carbon::createFromFormat('Y-m-d', $lot_number->exp_date)) ){
								$expiry_text = '(' . __('report.expired') . ')';
							}
						}
					@endphp
					<option value="{{$lot_number->purchase_line_id}}" data-qty_available="{{$lot_number->qty_available}}" data-msg-max="@lang('lang_v1.quantity_error_msg_in_lot', ['qty'=> $lot_number->qty_formated, 'unit' => $product->unit  ])" {{$selected}}>@if(!empty($lot_number->lot_number) && $lot_enabled == 1){{$lot_number->lot_number}} @endif @if($lot_enabled == 1 && $exp_enabled == 1) - @endif @if($exp_enabled == 1 && !empty($lot_number->exp_date)) @lang('product.exp_date'): {{@format_date($lot_number->exp_date)}} @endif {{$expiry_text}}</option>
				@endforeach
			</select>
		@endif
	@endif

	</td>

	<td>
		{{-- If edit then transaction sell lines will be present --}}
		@if(!empty($product->transaction_sell_lines_id))
			<input type="hidden" name="products[{{$row_count}}][transaction_sell_lines_id]" class="form-control" value="{{$product->transaction_sell_lines_id}}">
		@endif

		<input type="hidden" name="products[{{$row_count}}][product_id]" class="form-control product_id" value="{{$product->product_id}}">

		<input type="hidden" value="{{$product->variation_id}}" 
			name="products[{{$row_count}}][variation_id]" class="row_variation_id">

		<input type="hidden" value="{{$product->enable_stock}}" 
			name="products[{{$row_count}}][enable_stock]">
		
		@if(empty($product->quantity_ordered))
			@php
				$product->quantity_ordered = 1;
			
			@endphp
		@endif
		
		
		
		<input type="hidden" data-min="1" class="form-control pos_basic_price_sell input_number mousetrap" 
		value="<?php echo $default_selling_price;?>" name="{{$default_selling_price}}">
		<input type="hidden" data-min="1" class="form-control pos_basic_price input_number mousetrap" 
		value="<?php echo $default_buy_price;?>" name="{{$default_buy_price}}"> 
		
		<input type="hidden" data-min="1" class="form-control pos_li input_number mousetrap" 
		value="<?php echo $order[0];?>" name="{{$order[0]}}"> 
		<input type="hidden" data-min="1" class="form-control pos_lp input_number mousetrap" 
		value="<?php echo $descn[0];?>" name="{{$descn[0]}}">
		
		<input type="hidden" data-min="1" class="form-control pos_li2 input_number mousetrap" 
		value="<?php echo $order[1];?>" name="{{$order[1]}}"> 
		<input type="hidden" data-min="1" class="form-control pos_lp2 input_number mousetrap" 
		value="<?php echo $descn[1];?>" name="{{$descn[1]}}">
		
		
		<input type="hidden" data-min="1" class="form-control pos_li3 input_number mousetrap" 
		value="<?php echo $order[2];?>" name="{{$order[2]}}"> 
		<input type="hidden" data-min="1" class="form-control pos_lp3 input_number mousetrap" 
		value="<?php echo $descn[2];?>" name="{{$descn[2]}}">
		
		<input type="hidden" data-min="1" class="form-control pos_li4 input_number mousetrap" 
		value="<?php echo $order[3];?>" name="{{$order[3]}}]"> 
		<input type="hidden" data-min="1" class="form-control pos_lp4 input_number mousetrap" 
		value="<?php echo $descn[3];?>" name="{{$descn[3]}}]">
		
		<div class="input-group input-number">
			<span class="input-group-btn">
			    <button type="button" class="btn btn-default btn-flat quantity-down">
			        <i class="fa fa-minus text-danger"></i></button></span>
			        
			        
			        
		
			        
		<input type="text" data-min="1" class="form-control pos_quantity input_number mousetrap" 
		value="{{$H = @num_format($product->quantity_ordered)}}" name="products[{{$row_count}}][quantity]" 
		
		@if($product->unit_allow_decimal == 1) 
		    data-decimal=1 
		@else 
		    data-decimal=0 
		    data-rule-abs_digit="true" 
		    data-msg-abs_digit="@lang('lang_v1.decimal_value_not_allowed')" 
		@endif
		
		data-rule-required="true"
		data-msg-required="@lang('validation.custom-messages.this_field_is_required')" 
		@if($product->enable_stock)
		    data-rule-max-value="{{$max_qty_rule}}" 
		    data-qty_available="{{$product->qty_available}}" 
		    data-msg-max-value="{{$max_qty_msg}}" 
		    data-msg_max_default="@lang('validation.custom-messages.quantity_not_available',
		    ['qty'=> $product->formatted_qty_available, 'unit' => $product->unit  ])"
		@endif >
		
		<span class="input-group-btn"><button type="button" class="btn btn-default btn-flat quantity-up"><i class="fa fa-plus text-success"></i></button></span>
		
		</div>
		{{$product->unit}}
		
		
	</td>
	
	<td class="{{$hide_tax}}">
		<input type="text" 
		name="products[{{$row_count}}][unit_price_inc_tax]" 
		class="form-control pos_unit_price_inc_tax input_number"
		value="
		{{@num_format($unit_price_inc_tax)}}" 
		@if(!auth()->user()->can('edit_product_price_from_sale_screen')) readonly
		@endif 
		@if(!empty($pos_settings['enable_msp'])) 
		data-rule-min-value="{{$unit_price_inc_tax}}"
		data-msg-min-value="{{__('lang_v1.minimum_selling_price_error_msg',
		['price' => @num_format($unit_price_inc_tax)])}}"
		@endif>
	</td>
	
	<td class="text-center v-center">
		@php
			$subtotal_type = !empty($pos_settings['is_pos_subtotal_editable']) ? 'text' : 'hidden';
		@endphp
		

		
		
		<input type="{{$subtotal_type}}" 
		class="form-control pos_line_total
		        @if(!empty($pos_settings['is_pos_subtotal_editable'])) input_number @endif"
		value="
		
		{{@num_format($product->quantity_ordered*$unit_price_inc_tax )}}
		
		">
        
		
		<span class="display_currency pos_line_total_text @if(!empty($pos_settings['is_pos_subtotal_editable'])) hide @endif"
		data-currency_symbol="true">{{$product->quantity_ordered*$unit_price_inc_tax}}</span>
		
		<h6>
		@lang('sale.unitario')
		
		
		
		<span class="display_currency price_basic input_number @if(!empty($pos_settings['is_pos_subtotal_editable'])) hide @endif"
		data-currency_symbol="true" id="pba">{{$unit_price_inc_tax}}</span></h6>
		
		
		<input type="hidden" data-min="1" class="form-control pos_basic_price_desc input_number mousetrap" 
		value="{{$unit_price_inc_tax}}" name="descount" id="descount">
	</td>
	<td class="text-center">
		<i class="fa fa-close text-danger pos_remove_row cursor-pointer" aria-hidden="true"></i>
	</td>
</tr>