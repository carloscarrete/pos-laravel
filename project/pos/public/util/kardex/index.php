<?php include 'header.php';?>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../plugins/select2/select2.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php include 'main_sidebar.php';?>

        <!-- top navigation -->
       <?php include 'top_nav.php';?>      <!-- /top navigation -->
       <style>
label{

color: black;
}
li {
  color: white;
}
ul {
  color: white;
}
#buscar{
  text-align: right;
}
       </style>

        <!-- page content -->
        <div class="right_col" role="main"  style=" widht: auto;" >
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class = "x-panel">

            </div>

        </div><!--end of modal-dialog-->
 </div>
 

                 <div class="panel-heading" >


        </div>
 
 <!--end of modal-->


                  <div class="box-header">
                  <h3 class="box-title"> </h3>

                </div><!-- /.box-header -->
                 <a class = "btn btn-success btn-print" href = "" onclick = "window.print()"><i class ="glyphicon glyphicon-print"></i> Impresión</a>
                <a class="btn btn-warning btn-print" href="usuario_agregar"    style="height:25%; width:15%; font-size: 12px " role="button">REGISTRAR</a>


                <div class="box-body">


      
 <!--end of modal-->


                  <div class="box-header">
                  <h3 class="box-title"> ARCHIVO DE CIERRES Y DECLARACIONES</h3>
                </div><!-- /.box-header -->
                <div class="caja">
                    <?php
                        $SUCURSAL = $_POST["suc"];
                        $ESTADO = $_POST["edo"];
                    ?>
                    
                    <form method="post">
                        <label>Sucursal: </label>
                        <select name="suc" id="suc">
                            <option value=" "> TODAS</option>
                            <?php
                                $VALUE="";
                                $query_b=mysqli_query($con,"select * from business_locations")or die(mysqli_error());
                                while($row_b=mysqli_fetch_array($query_b)){
                                    $NAME=$row_b['name'];
                                    $IDB=$row_b['id'];
                                    $VALUE=" AND location_id='$IDB'";
                                ?>    
                                    <option value="<?php echo $VALUE;?>"> <?php echo $NAME;?></option>";
                                <?php }
                                
                            ?>
                        </select>
                        
                        <label> Estado: </label>
                        <select name="edo" id="edo">
                            <option value=" "> TODAS</option>
                            <option value="AND auth='1'"> REVISADO</option>
                            <option value="AND auth='0'"> PENDIENTE</option>
                        </select>
                        
                        
                        
                        <button class = "btn btn-success btn-print"> BUSCAR</button>
                    </form>
                    
                </div>
              


                <div class="box-body">
                
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr style="background-color:white">

                    <th>#</th>
                        <th>Fondo Recibido</th>
                        <th>Venta Total</th>
                        <th>Devolucion Total</th>
                        <th>Gasto Total</th>
                        <th>Retiro Total</th>
                        <th>Total Efectivo</th>
                        <th>Declarado Efectivo</th>
                        <th>Diferencia Efectivo</th>
                        <th>Fondo Entregado</th>
                        <th>Efectivo Entregado</th>
                        <th>Sucursal (Usuario)</th>
                        <th>Fecha</th>
                        <th>Comentarios de el cierre</th>
     

                      </tr>
                    </thead>
                    <tbody>
<?php
   // $branch=$_SESSION['branch'];
    $query=mysqli_query($con,"select * from cash_registers where id!='0' $SUCURSAL $ESTADO ORDER BY created_at DESC")or die(mysqli_error());
    $i=0;
    while($row=mysqli_fetch_array($query)){
    $cid=$row['id'];
    $i++;
?>
                      <tr style="background-color:white">

<td><?php echo $i;?></td>  

<?php 
$suma=0;
$fondo=0;
$venta=0;
$gasto=0;
$retiro=0;
$fondoe=0;
$entrega=0;

$devolucion=0;
 $query4=mysqli_query($con,"select * from cash_register_transactions where cash_register_id='$cid' and pay_method='cash'")or die(mysqli_error());
             while($row4=mysqli_fetch_array($query4)){
                 if($row4["transaction_type"]=='initial'){$suma =$suma + $row4['amount'];   $fondo=$fondo + $row4['amount'];}
                 if($row4["transaction_type"]=='sell'){$suma =$suma + $row4['amount'];  $venta=$venta + $row4['amount'];}
                 if($row4["transaction_type"]=='refund'){$suma =$suma - $row4['amount']; $devolucion=$devolucion + $row4['amount'];}
                 if($row4["transaction_type"]=='gasto'){$suma =$suma - $row4['amount']; $gasto=$gasto + $row4['amount'];}
                 if($row4["transaction_type"]=='retiro'){$suma =$suma - $row4['amount']; $retiro=$retiro + $row4['amount'];}
                 }?>

<td align="right"><?php echo "$". number_format($fondo,2);?></td>
<td align="right"><?php echo "$". number_format($venta,2);?></td>
<td align="right"><?php echo "$". number_format($devolucion,2);?></td>
<td align="right"><?php echo "$". number_format($gasto,2);?></td>
<td align="right"><?php echo "$". number_format($retiro,2);?></td>
<td align="right"><?php echo "$". number_format($suma,2);?></td>
<td align="right"><?php echo "$".number_format($row["closing_amount"],2)."</br>";?>
<?php
if($row['auth']==0){ $stts = "<b><font color='orange'>PENDIENTE</font></b>";}
if($row['auth']==1){ $stts = "<b><font color='blue'>REVISADO</font></b>";}
echo "$sttsx $stts";?>
</td>
<td align="right"><?php
$Total = $row["closing_amount"] - $suma;

$COLOR="black";
 if($Total<0){$COLOR='red';}
 if($Total>0){$COLOR='blue';}
 if($row['status']=="open"){ $DIFERENCIA = "<b><font color='black' size='2'>(Caja Abierta)</font></b></br>";}
 if($row['status']=="close"){ $DIFERENCIA = "<b><font color='$COLOR' size='2'>$".number_format($Total,2)."</font></b></br>";}
echo "$DIFERENCIA";?>
    <?php 
    $CashReg= base64_encode($cid);
    $UID= base64_encode($row['user_id']);
    if($row['auth']==0&&$row['status']=="close"){ 
    
    ?>
    <a href='confirm?<?php echo "cash=$CashReg";?>'><i class='  glyphicon glyphicon-ok  '></i></a>
    <?php }
    
    if($row['status']=="close"){ ?>
    <a href='https://ventas.saludable.mx/public/util/consult.php?<?php echo "id=$CashReg&uid=$UID";?>' target='popup'
                                        onClick='window.open(this.href, this.target, 'toolbar=1 , location=1 , 
                                            status=0 , menubar=0 , scrollbars=1 , resizable=0 ,left=200pt,top=150pt,width=1100px,height=550'); 
                                                return true;'>
                                                    <i class='  glyphicon glyphicon-hdd  '></i></a>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        <?php }
                                                        
                                                        
                                                        
                                                        
                                                        ?>
</td>
<td align="right">
    <?php  
    $fondoe=$row["total_cheques"];
    echo "$".number_format($fondoe,2) ;  ?>
</td>
<td align="right">
    <?php   
    $entrega = $row["closing_amount"]-$fondoe;
    echo "$".number_format($entrega,2) ; ?>
</td>

<td><?php $idL = $row['location_id'];
            $query2=mysqli_query($con,"select * from business_locations where id='$idL'")or die(mysqli_error());
             while($row2=mysqli_fetch_array($query2)){echo $row2['name'];}
?><?php $idu = $row['user_id'];
            $query6=mysqli_query($con,"select * from users where id='$idu'")or die(mysqli_error());
             while($row6=mysqli_fetch_array($query6)){echo "(".$row6['username'].")";}
echo  "</br>ID: ".$row['id'];
?>

</td>
<td><?php echo $row['closed_at'];?></td>    

<td><?php echo $row['closing_note'];?></td> 

   
            

                      </tr>

 <!--end of modal-->

<?php }?>
                    </tbody>

                  </table>
                </div><!-- /.box-body -->

            </div><!-- /.col -->


          </div><!-- /.row -->




                </div><!-- /.box-body -->

            </div>
        </div>
      </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            TECLA SOLUTIONS <a href="#"></a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

  <?php include 'datatable_script.php';?>



        <script>
        $(document).ready( function() {
                $('#example2').dataTable( {
                 "language": {
                   "paginate": {
                      "previous": "anterior",
                      "next": "posterior"
                    },
                    "search": "Buscar:",


                  },
           "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],


  "searching": true,
                }

              );
              } );
    </script>




    <!-- /gauge.js -->
  </body>
</html>
