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

<div class="modal-dialog modal-xl" role="document">
	<div class="modal-content">
		<div class="modal-header">
		    <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      <h4 class="modal-title" id="modalTitle">{{$product->name}}</h4>
	    </div>
	    <div class="modal-body">
      		<div class="row">
      			<div class="col-sm-9">
	      			<div class="col-sm-4 invoice-col">
	      				<b>@lang('product.sku'):</b>
						{{$product->sku }}<br>
						<?php
		                $sku= $product->sku ;
		                $cod= $sku;
                                $SEARCH= "SELECT * FROM variations WHERE sub_sku=:cod_v";
                                $QyBar = $dbP -> prepare($SEARCH);
		                        $QyBar->bindParam(':cod_v',$cod,PDO::PARAM_STR);
                                $QyBar->execute();
                                $RsBar=$QyBar->fetchAll(PDO::FETCH_OBJ);
                                if($QyBar->rowCount() > 0){  
                                        foreach($RsBar as $RB){
                                            $ID_P=$RB -> product_id;
                                            $ID_V=$RB -> product_variation_id;
                                            $D_P_P=$RB -> default_purchase_price;
                                            $D_S_P=$RB -> default_sell_price;
                                            $D_PCT=$RB -> profit_percent;
                                        }
                                    }
                                $cod_P=$ID_P;
                                $cod_V=$ID_V;
                                $DPP = $D_P_P;
                                $DSP = $D_S_P;
                                $PCT = $D_PCT;
		
                                    
                                    
                                    
        ?>
						
						
						<b>@lang('product.brand'): </b>
						{{$product->brand->name or '--' }}<br>
						<b>@lang('product.unit'): </b>
						{{$product->unit->short_name or '--' }}<br>
						<b>@lang('product.barcode_type'): </b>
						{{$product->barcode_type or '--' }}
                        
                        
                            <br/>
							<b><font color="blue">@lang('lang_v1.cost')</font> =&nbsp;${{ $DPP }}</b>
						
                        <?php $num=1;?>
                            <br/>
							<b>@lang('lang_v1.margin') {{ $num }}: &nbsp; <font color="#00e600">@lang('lang_v1.start'):</font></b>
							@lang('lang_v1.pct'): {{ number_format($PCT) }}% = <b>${{ $DPP+($DPP * ($PCT/100))}}</b>
							
						<?php 	
							$order = array("$product->product_custom_field1","$product->product_custom_field2","$product->product_custom_field3","$product->product_custom_field4");
							$descn = array("$product->pct_1","$product->pct_2","$product->pct_3","$product->pct_4");
							array_multisort($order, $descn);
						?>
						
						@if(!empty($product->product_custom_field1))
						<?php $num++;?>
							<br/>
							<b>@lang('lang_v1.margin') {{ $num }}: </b>@lang('lang_v1.qty'):
							<font color="red"><b>{{$order[0] }}</b></font>,
							@lang('lang_v1.pct'): {{$descn[0]}}% = <b>${{ $DPP+ ($DPP * ($descn[0]/100))}}</b>
						@endif

						@if(!empty($product->product_custom_field2))
						<?php $num++;?>	
							<br/>
							<b>@lang('lang_v1.margin') {{ $num }}: </b>@lang('lang_v1.qty'):
							<font color="red"><b>{{$order[1]}}</b></font>,
							@lang('lang_v1.pct'): {{$descn[1]}}% = <b>${{ $DPP+($DPP * ($descn[1]/100))}}</b>
						@endif

						@if(!empty($product->product_custom_field3))
						<?php $num++;?>
							<br/>
							<b>@lang('lang_v1.margin') {{ $num }}: </b>@lang('lang_v1.qty'):
							<font color="red"><b>{{$order[2]}}</b></font>,
							@lang('lang_v1.pct'): {{$descn[2]}}% = <b>${{ $DPP+($DPP * ($descn[2]/100))}}</b>
						@endif

						@if(!empty($product->product_custom_field4))
						<?php $num++;?>
							<br/>
							<b>@lang('lang_v1.margin') {{ $num }}: </b>@lang('lang_v1.qty'):
							<font color="red"><b>{{$order[3]}}</b></font>,
							@lang('lang_v1.pct'): {{$descn[3]}}% = <b>${{ $DPP+($DPP * ($descn[3]/100))}}</b>
						@endif
	      			</div>

	      			<div class="col-sm-4 invoice-col">
						<b>@lang('product.category'): </b>
						{{$product->category->name or '--' }}<br>
						<b>@lang('product.sub_category'): </b>
						{{$product->sub_category->name or '--' }}<br>	
						
						<b>@lang('product.manage_stock'): </b>
						@if($product->enable_stock)
							@lang('messages.yes')
						@else
							@lang('messages.no')
						@endif
						<br>
						@if($product->enable_stock)
							<b>@lang('product.alert_quantity'): </b>
							{{$product->alert_quantity or '--' }}
						@endif
	      			</div>
					
	      			<div class="col-sm-4 invoice-col">
	      				<b>@lang('product.expires_in'): </b>
	      				@php
	  						$expiry_array = ['months'=>__('product.months'), 'days'=>__('product.days'), '' =>__('product.not_applicable') ];
	  					@endphp
	      				@if(!empty($product->expiry_period) && !empty($product->expiry_period_type))
							{{$product->expiry_period}} {{$expiry_array[$product->expiry_period_type]}}
						@else
							{{$expiry_array['']}}
	      				@endif
	      				<br>
						@if($product->weight)
							<b>@lang('lang_v1.weight'): </b>
							{{$product->weight }}<br>
						@endif
						<b>@lang('product.applicable_tax'): </b>
						{{$product->product_tax->name or __('lang_v1.none') }}<br>
						@php
							$tax_type = ['inclusive' => __('product.inclusive'), 'exclusive' => __('product.exclusive')];
						@endphp
						<b>@lang('product.selling_price_tax_type'): </b>
						{{$tax_type[$product->tax_type]  }}<br>
						@php
							$product_type = ['single' => 'Single', 'variable' => 'Variable'];
						@endphp
						<b>@lang('product.product_type'): </b>
						{{$product_type[$product->type] }}
						
	      			</div>
	      			<div class="clearfix"></div>
	      			<br>
      				<div class="col-sm-12">
      					{!! $product->product_description !!}
      				</div>
	      		</div>
      			<div class="col-sm-3 col-md-3 invoice-col">
      				<div class="thumbnail">
      					<img src="{{$product->image_url}}" alt="Product image">
      				</div>
      			</div>
      		</div>
      		@if($rack_details->count())
      		@if(session('business.enable_racks') || session('business.enable_row') || session('business.enable_position'))
      			<div class="row">
      				<div class="col-md-12">
      					<h4>@lang('lang_v1.rack_details'):</h4>
      				</div>
      				<div class="col-md-12">
      					<div class="table-responsive">
      					<table class="table table-condensed bg-gray">
      						<tr class="bg-green">
      							<th>@lang('business.location')</th>
      							@if(session('business.enable_racks'))
      								<th>@lang('lang_v1.rack')</th>
      							@endif
      							@if(session('business.enable_row'))
      								<th>@lang('lang_v1.row')</th>
      							@endif
      							@if(session('business.enable_position'))
      								<th>@lang('lang_v1.position')</th>
      							@endif
      							<th>Cantidad</th>
      							</tr>
      						@foreach($rack_details as $rd)
      							<tr>
	      							<td>{{$rd->name}}</td>
	      						<?php
		                        $Name=$rd->name;
                                $SEARCH= "SELECT * FROM business_locations WHERE location_id=:name";
                                $QyBar = $dbP -> prepare($SEARCH);
		                        $QyBar->bindParam(':name',$Name,PDO::PARAM_STR);
                                $QyBar->execute();
                                $RsBar=$QyBar->fetchAll(PDO::FETCH_OBJ);
                                if($QyBar->rowCount() > 0){  
                                        foreach($RsBar as $RB){
                                            $id_loc=$RB -> id;
                                        }
                                    }
                                $Locate=$id_loc;
		
                                    
                                    
                                    
        ?>
	      							
	      							@if(session('business.enable_racks'))
	      								<td>{{$rd->rack}}</td>
	      							@endif
	      							@if(session('business.enable_row'))
	      								<td>{{$rd->row}}</td>
	      							@endif
	      							@if(session('business.enable_position'))
	      								<td>{{$rd->position}}</td>
	      							@endif
	    <?php                   $cantidad=0;
	                            $sum =0;
                                $SEARCH= "SELECT * FROM variation_location_details WHERE product_id=:id_p AND product_variation_id=:id_v AND location_id=:loc_id";
                                $QyBar = $dbP -> prepare($SEARCH);
		                        $QyBar->bindParam(':id_p',$cod_P,PDO::PARAM_STR);
		                        $QyBar->bindParam(':id_v',$cod_V,PDO::PARAM_STR);
		                        $QyBar->bindParam(':loc_id',$Locate,PDO::PARAM_STR);
                                $QyBar->execute();
                                $RsBar=$QyBar->fetchAll(PDO::FETCH_OBJ);
                                if($QyBar->rowCount() > 0){  
                                        foreach($RsBar as $RB){
                                            $value = $RB -> qty_available;
                                            if($value != null){
                                                $cantidad=$RB -> qty_available;
                                                $sum++;
                                            }
                                            else{
                                                $cantidad=0;
                                            }
                                            ?>
                                            <td> <?php echo number_format($cantidad); 
	      								?></td>
                                          <?php  
                                        }
                                    }
                                    else{ ?>
                                        
                                     <td> 0 </td>   
                               <?php      }
		
                                    
                                    
                                    
        ?>
	      								
      							</tr>
      						@endforeach
      					</table>
      					</div>
      				</div>
      			</div>
      		@endif
      		@endif
      		@if($product->type == 'single')
      			@include('product.partials.single_product_details')
      		@else
      			@include('product.partials.variable_product_details')
      		@endif
      	</div>
      	<div class="modal-footer">
      		<button type="button" class="btn btn-primary no-print" 
	        aria-label="Print" 
	          onclick="$(this).closest('div.modal').printThis();">
	        <i class="fa fa-print"></i> @lang( 'messages.print' )
	      </button>
	      	<button type="button" class="btn btn-default no-print" data-dismiss="modal">@lang( 'messages.close' )</button>
	    </div>
	</div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    var element = $('div.modal-xl');
    __currency_convert_recursively(element);
  });
</script>
