<?php
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
include('../conect.php');
$locate = $_POST["loc"];
?>
<style>
    .hidden{
        visibility: hidden;
        height: 0px;
        width: 0px;
    }
</style>
<h2 align="center">Confirmar el envio (No reversible):</h2>
<form class="col s12"  action="send_p.php" method="post">
    <div class="input-field col s3" align="center">
        NIP: <input autofocus type="password" id="code" name="code" placeholder="Nip de admin"  type="text-area" maxlength="10" required>
        <input readonly id="loc_sub" hidden="true" name="loc_sub" class="materialize-textarea" type="text" value="<?php echo $locate;?>" required />
                                        
        <button>ENVIAR</button> 
    </div>
</form>