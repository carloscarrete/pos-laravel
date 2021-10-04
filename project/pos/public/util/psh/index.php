<?php
    $employe_id=base64_decode($_GET["c"]);
    $business_id=base64_decode($_GET["b"]);
    


?>
<style>
    .hidden{
        visibility: hidden;
        height: 0px;
        width: 0px;
    }
</style>
<title>Gastos</title>
<h2>Solicitud de Gastos:</h2>
<div align="right"><input name="button" type="button" onclick="window.close();" value="CERRAR" /></div>
<form class="col s12"  action="psh.php" method="post" target="ident">
    <div class="hidden"><input name="empid" value="<?php echo $employe_id;?>" type="text" maxlength="10" required readonly></div>
    <div class="hidden"><input name="buss_id" value="<?php echo $business_id;?>" type="text" maxlength="10" required readonly></div>
    <div class="input-field col s3" align="center"><button>+ Nuevo Gasto</button></div> 
    <div align="center">   
        <iframe name="ident"  width="95%" height="82%"></iframe>
    </div>    
</form>

