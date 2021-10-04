<?php
error_reporting(0);
include('../conect.php');
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");

$Location=$_GET["locate"];
$admin=$_GET["admin"];
$TODAY= date("d-m.Y");

$verifyc = "SELECT * from auditorias WHERE fecha=:today and id_location=:locate and type='close'";
$qVer = $dbP -> prepare($verifyc);
$qVer->bindParam(':today',$TODAY,PDO::PARAM_STR);
$qVer->bindParam(':locate',$Location,PDO::PARAM_STR);
$qVer->execute();
$qVerR=$qVer->fetchAll(PDO::FETCH_OBJ);
if($qVer->rowCount() > 0){  
    foreach($qVerR as $vr){
        $VERIFY = $vr->id;
    }
}
if($VERIFY) {echo "<script type=''>alert('Auditoria enviada, no se puede modificar mas.');</script>";}
else{
?>


<div align="center">  
<table><tr><td>
<form action="locate_c.php" method="post" target="locate_c">
    
        <input type="text" id="loc_p" name="loc_p" value="<?php echo $Location;?>" hidden="true" type="text-area" maxlength="30" required readonly>
        <input type="text" id="admin" name="admin" value="<?php echo $admin;?>" hidden="true" type="text-area" maxlength="100" required readonly>
        Codigo de barras: <input autofocus type="text" id="sku" name="sku" placeholder="SKU"  type="text-area" maxlength="30" required>
        <button>BUSCAR</button> 
    
     
</form>
</td>
<td width='100px'>
</td>
<td>
<form method="post" name="search" action="search.php" enctype="multipart/form-data" target="locate_c">

    No lo tengo
    <input required name="PalabraClave" type="text" class="form-control mb-2" id="inlineFormInput" placeholder="Terminos de busqueda">  
    <input name="buscar" type="hidden" class="form-control mb-2" id="inlineFormInput" value="v">
    
    <button>BUSCAR</button>

</form>
</td>
<td width='100px'>
</td>

<td>
    
    <form method="post" action="index_c.php" enctype="multipart/form-data">
        <div class="input-field col s1">
                <input readonly id="loc" hidden="true" name="loc" class="materialize-textarea" type="text" value="<?php echo $Location;?>" required />
            
                <button  class="waves-effect waves-light btn red m-b-xs">ENVIAR AUDITORIA</button>
        </div>
    </form>
</td>

</tr></table>
</div> 
<div align="center">   
        <iframe name="locate_c"  width="95%" height="90%" style="border:0;"></iframe>
    </div>   
    
<?php  } 
?> 