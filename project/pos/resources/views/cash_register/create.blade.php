@extends('layouts.app')
@section('title',  __('cash_register.open_cash_register'))

@section('content')

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
}?>


<style type="text/css">



</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('cash_register.open_cash_register')</h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
{!! Form::open(['url' => action('CashRegisterController@store'), 'method' => 'post', 
'id' => 'add_cash_register_form' ]) !!}
  <div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <div class="form-group">
            {!! Form::label('amount', __('cash_register.cash_in_hand') . ':') !!}
              {!! Form::text('amount', null, ['class' => 'form-control input_number',
              'placeholder' => __('cash_register.enter_amount')]); !!}
          </div>
        </div> 
        <div class="col-sm-8 col-sm-offset-2">
            <div class="form-group">
                <?php $U_ID= request()->session()->get('user.id'); ?>
            
                
                {!! Form::label('location', __('lang_v1.select_location') . ':') !!}
                <select id='location' name='location' null required class='form-control input-sm mousetrap' placeholder="{lang_v1.select_location}">
                    <option value="">Selecciona...</option>
                        <?php $sql = "SELECT  * from business_locations";
                                $query = $dbP -> prepare($sql);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                if($query->rowCount() > 0)
                                {
                                foreach($results as $result)
                                {   ?>                                            
                    <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->name);?></option><?php }} ?>
                </select>
            </div>
        </div>
        
           
       
							
        
        <div class="col-sm-8 col-sm-offset-2">
          <button type="submit" class="btn btn-primary pull-right">@lang('cash_register.open_register')</button>
        </div>
      </div>
    </div>
  </div>
  {!! Form::close() !!}
</section>
<!-- /.content -->
@endsection