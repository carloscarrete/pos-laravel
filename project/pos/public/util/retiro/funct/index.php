<?php
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
include('../../conect.php');
require_once('../../Mail/config.php');
$id_u =  base64_decode($_GET["c"]);
$id_b =  base64_decode($_GET["b"]);

?>
<style>
    .hidden{
        visibility: hidden;
        height: 0px;
        width: 0px;
    }
</style>
<title>Retiros</title>
<h2>Registrar Retiro:</h2>
<div align="right"><input name="button" type="button" onclick="window.close();" value="CERRAR" /></div>
<form class="col s12"  action="retiro.php" method="post" target="ident">
    <div class="hidden"><input name="empid" value="<?php echo $id_u;?>" type="text" maxlength="10" required readonly></div>
    <div class="hidden"><input name="buss_id" value="<?php echo $id_b;?>" type="text" maxlength="10" required readonly></div>
    <div class="input-field col s3" align="center"><button> Registrar</button></div> 
    <div align="center">   
        <iframe name="ident"  width="95%" height="45%"></iframe>
    </div>    
</form>