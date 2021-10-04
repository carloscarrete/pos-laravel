<?php
$localhost = env('DB_HOST');
$user = env('DB_USERNAME');
$database = env('DB_DATABASE');
$dbpassword = env('DB_PASSWORD');

                            // Datos de la base de datos
                            define('DB_HOSTpx',"$localhost");
                            define('DB_USERpx',"$user");
                            define('DB_PASSpx',"$dbpassword");
                            define('DB_NAMEpx',"$database");
                            
                            
                            // Comando de conexion establesida m1
                            try
                            {
                            $dbPx = new PDO("mysql:host=".DB_HOSTpx.";dbname=".DB_NAMEpx,DB_USERpx, DB_PASSpx,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                            }
                            catch (PDOException $ePx)
                            {
                            exit("Error: " . $ePx->getMessage());
                            }?>
                            



<!-- business information here -->
            <style type="text/css" media="screen">
            .padre {
             background-color: #fafafa;
             margin: 1rem;
             padding: 1rem;
             border: 2px solid #ccc;
             /* IMPORTANTE */
             text-align: center;
            }
            </style>
<div class="row">
            <h6 align="center">
                {{$receipt_details->display_name}}</br>
                @if(!empty($receipt_details->invoice_no_prefix))
					<b>{!! $receipt_details->invoice_no_prefix !!}</b>
				@endif
				{{$receipt_details->invoice_no}}</br>
				<b>{{$receipt_details->date_label}}</b> {{$receipt_details->invoice_date}}
			

	<!-- Logo -->
	@if(!empty($receipt_details->logo))
		<img src="{{$receipt_details->logo}}" class="img img-responsive center-block" width="120" height="35"></br>
	@endif
	<!-- Header text -->
	@if(!empty($receipt_details->header_text))
		
			{!! $receipt_details->header_text !!}
		</br>
	@endif

	<!-- business information here -->
	<div class="col-xs-12 text-center">
		 

		<!-- Address -->
		<p><small class="text-center">
		@if(!empty($receipt_details->address))
				
				{!! $receipt_details->address !!}
				
		@endif
		@if(!empty($receipt_details->location_custom_fields))
			{{ $receipt_details->location_custom_fields }}
		@endif
		@if(!empty($receipt_details->contact))
			</br>{{ $receipt_details->contact }}
		@endif	
		@if(!empty($receipt_details->contact) && !empty($receipt_details->website))
			, 
		@endif
		@if(!empty($receipt_details->website))
			{{ $receipt_details->website }}
		@endif
		
		</p>
		<p>
		@if(!empty($receipt_details->sub_heading_line1))
			{{ $receipt_details->sub_heading_line1 }}
		@endif
		@if(!empty($receipt_details->sub_heading_line2))
			<br>{{ $receipt_details->sub_heading_line2 }}
		@endif
		@if(!empty($receipt_details->sub_heading_line3))
			<br>{{ $receipt_details->sub_heading_line3 }}
		@endif
		@if(!empty($receipt_details->sub_heading_line4))
			<br>{{ $receipt_details->sub_heading_line4 }}
		@endif		
		@if(!empty($receipt_details->sub_heading_line5))
			<br>{{ $receipt_details->sub_heading_line5 }}
		@endif
		</p>
		<p>
		@if(!empty($receipt_details->tax_info1))
			<b>{{ $receipt_details->tax_label1 }}</b> {{ $receipt_details->tax_info1 }}
		@endif

		@if(!empty($receipt_details->tax_info2))
			<b>{{ $receipt_details->tax_label2 }}</b> {{ $receipt_details->tax_info2 }}
		@endif
		
		</small>
		</p></h6>

		<!-- Title of receipt -->
		@if(!empty($receipt_details->invoice_heading))
			<h6 class="text-center">
				{!! $receipt_details->invoice_heading !!}
			</h6>
		@endif

		<!-- Invoice  number, Date  -->
		<p style="width: 100% !important" class="word-wrap">
			<span class="pull-left text-left word-wrap">
				

				<!-- Table information-->
		        @if(!empty($receipt_details->table_label) || !empty($receipt_details->table))
		        	<br/>
					<span class="pull-left text-left">
						@if(!empty($receipt_details->table_label))
							<b>{!! $receipt_details->table_label !!}</b>
						@endif
						{{$receipt_details->table}}

						<!-- Waiter info -->
				</span>
		        @endif
		        <h6 align="center">
				<!-- customer info -->
				@if(!empty($receipt_details->customer_info))
					
					<b>{{ $receipt_details->customer_label }}</b> {!! $receipt_details->customer_info !!}
				@endif
				@if(!empty($receipt_details->client_id_label))
					
					<b>{{ $receipt_details->client_id_label }}</b> {{ $receipt_details->client_id }}
				@endif
				@if(!empty($receipt_details->customer_tax_label))
					
					<b>{{ $receipt_details->customer_tax_label }}</b> {{ $receipt_details->customer_tax_number }}
				@endif
				@if(!empty($receipt_details->customer_custom_fields))
					{!! $receipt_details->customer_custom_fields !!}
				@endif
				
				<?php
			$idno = $receipt_details->invoice_no;
                                $SEARCH= "SELECT * FROM transactions where invoice_no=:idno";
                                $QyBar = $dbPx -> prepare($SEARCH);
                                $QyBar->bindParam(':idno',$idno,PDO::PARAM_STR);
                                $QyBar->execute();
                                $RsBar=$QyBar->fetchAll(PDO::FETCH_OBJ);
                                $personal = "Sin seleccionar";
                                if($QyBar->rowCount() > 0){  
                                        foreach($RsBar as $RB){
                                            $trid=$RB -> id;
                                            
                                            $idu=$RB -> commission_agent;
                                            $SEARCH2= "SELECT * FROM users where id = :idu";
                                            $QyBar2 = $dbPx -> prepare($SEARCH2);
                                            $QyBar2->bindParam(':idu',$idu,PDO::PARAM_STR);
                                            $QyBar2->execute();
                                            $RsBar2=$QyBar2->fetchAll(PDO::FETCH_OBJ);
                                            if($QyBar2->rowCount() > 0){  
                                                    foreach($RsBar2 as $RB2){
                                                        $personal= $RB2 -> first_name . " " . $RB2 -> last_name;
                                                    }
                                            }
                                            
                                        }
                                    }
                                    $trid=$trid;
        ?>

				
				
				@if(!empty($receipt_details->sales_person_label))</br> 
					
					<b>{{ $receipt_details->sales_person_label }}</b>    <?php echo $personal ;?>               
				@endif
				</br></h6>
			</span>
		</p>
	</div>
	<!-- /.col -->
</div>


<div class="row">
    
	<div align="center">
		    <font  size="1px">
			<table>
				@forelse($receipt_details->lines as $line)
					<tr>
                            <td>{{$line['name']}} {{$line['variation']}}</td></br>
                            
						<td width="10"></td><td>{{$line['unit_price_inc_tax']}}</td><td width="10"></td><td>{{$line['quantity']}}</td><td width="10"></td><td> {{$line['line_total']}}</td>
					
				@empty
					</tr>
				@endforelse
				</table>
				<table>
                                        
            <?php                           
                                            $z=0;
                                            $SEARCH3= "SELECT * FROM transaction_sell_lines where transaction_id = :idt";
                                            $QyBar3 = $dbPx -> prepare($SEARCH3);
                                            $QyBar3->bindParam(':idt',$trid,PDO::PARAM_STR);
                                            $QyBar3->execute();
                                            $RsBar3=$QyBar3->fetchAll(PDO::FETCH_OBJ);
                                            if($QyBar3->rowCount() > 0){  
                                                    foreach($RsBar3 as $RB3){
                                                        $SLN=$RB3->sell_line_note;
                                                        if($SLN!=null){
                                                            $z++;
                                                            if($z==1){echo "<th colspan='3' style='text-align: center'>Instrucciones de uso </th>";}
                                                        echo "<tr>";
                                                        $IDP=$RB3->product_id;
                                                        
                                                        $SEARCH4= "SELECT * FROM products where id = :idp";
                                                        $QyBar4 = $dbPx -> prepare($SEARCH4);
                                                        $QyBar4->bindParam(':idp',$IDP,PDO::PARAM_STR);
                                                        $QyBar4->execute();
                                                        $RsBar4=$QyBar4->fetchAll(PDO::FETCH_OBJ);
                                                        if($QyBar4->rowCount() > 0){  
                                                                foreach($RsBar4 as $RB4){
                                                                    $name=$RB4->name;
                                                                    echo "<td colspan='3'>$name</td></tr>";
                                                                }
                                                        }
                                                        
                                                        echo "<tr><td colspan='3'>$SLN </td>";
                                                        echo "</tr><tr></tr>";}
                                                    }
                                            }
                                            ?>
            </table>
        </font>                                    
	</div>
</div>

<div class="row">
	<div class="col-md-y21"></div>

	<div>

		<div align="center">
		    
		    <font  size="1px">
            
			@if(!empty($receipt_details->payments))
				@foreach($receipt_details->payments as $payment)
					
						{{$payment['method']}}
						&nbsp;&nbsp;{{$payment['amount']}}
						
					
				@endforeach
			@endif
		      
			<!-- Total Paid-->
			@if(!empty($receipt_details->total_paid))
				
					
							</br>{!! $receipt_details->total_paid_label !!}
					
						&nbsp;&nbsp;{{$receipt_details->total_paid}}
					
			@endif

			<!-- Total Due-->
			@if(!empty($receipt_details->total_due))
			
						</br>{!! $receipt_details->total_due_label !!}
				
					&nbsp;&nbsp;{{$receipt_details->total_due}}
				
			@endif

		{{$receipt_details->additional_notes}}
		
        </font>
	   </div>
	</div>
</div>
<div class="row">
	<div>
        <div class="table-responsive">
          	
				
			
					<!-- Shipping Charges -->
					@if(!empty($receipt_details->shipping_charges))
						<h6 align="center">
								{!! $receipt_details->shipping_charges_label !!}</br>
							
								{{$receipt_details->shipping_charges}}</br>
						</h6>
					@endif

					<!-- Discount -->
					@if( !empty($receipt_details->discount) )
						<h6 align="center">
						
								{!! $receipt_details->discount_label !!}</br>
							
								(-) {{$receipt_details->discount}}</br>
							
						</h6>
					@endif

					<!-- Tax -->
					@if( !empty($receipt_details->tax) )
						<h6 align="center">
							
								{!! $receipt_details->tax_label !!}</br>
						
								(+) {{$receipt_details->tax}}</br>
							
						</h6>
					@endif
					
		            <!-- Total -->
					<h6 align="center">
							{!! $receipt_details->total_label !!}:
						
							{{$receipt_details->total}}
						
					</h6>

			
        </div>
    </div>
</div>
<div class="row">
		<div class="col-xs-12" align="center">
			<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($receipt_details->invoice_no, 'C128', 2,30,array(39, 48, 54), true)}}">
		</div>
	</div>

					@if(!empty($receipt_details->footer_text))
	
			        <h6 align="center">{!! $receipt_details->footer_text !!}</h6>
		
                    @endif
                    
                    <hr/>
