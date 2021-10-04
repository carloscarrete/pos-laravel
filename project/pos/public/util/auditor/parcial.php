<?php
error_reporting(0);
include('../conect.php');
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");

$Location=$_GET["locate"];
$admin=$_GET["admin"];?>
<div align="center">  
<table><tr><td>
<form action="locate_p.php" method="post" target="locate_p">
    
        <input type="text" id="loc_p" name="loc_p" value="<?php echo $Location;?>" hidden="true" type="text-area" maxlength="30" required readonly>
        <input type="text" id="admin" name="admin" value="<?php echo $admin;?>" hidden="true" type="text-area" maxlength="100" required readonly>
        Codigo de barras: <input autofocus type="text" id="sku" name="sku" placeholder="SKU"  type="text-area" maxlength="30" required>
        <button>BUSCAR</button> 
    
     
</form>
</td>
<td width='100px'>
</td>
<td>
<form method="post" name="search" action="search.php" enctype="multipart/form-data" target="locate_p">

    No lo tengo
    <input required name="PalabraClave" type="text" class="form-control mb-2" id="inlineFormInput" placeholder="Terminos de busqueda">  
    <input name="buscar" type="hidden" class="form-control mb-2" id="inlineFormInput" value="v">
    
    <button>BUSCAR</button>

</form>
</td>
<td width='100px'>
</td>
<td>
    
    <form method="post" action="index_p.php" enctype="multipart/form-data">
        <div class="input-field col s1">
                <input readonly id="loc" hidden="true" name="loc" class="materialize-textarea" type="text" value="<?php echo $Location;?>" required />
            
                <button  class="waves-effect waves-light btn red m-b-xs">ENVIAR AUDITORIA</button>
        </div>
    </form>
</td>

</tr></table>
</div> 
<div align="center">   
        <iframe name="locate_p"  width="95%" height="90%" style="border:0;"></iframe>
    </div>   