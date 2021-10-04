<?php
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
include('../conect.php');
?>
<style>
    .hidden{
        visibility: hidden;
        height: 0px;
        width: 0px;
    }
</style>
<title>AUDITORIAS</title>
<h2>Ingresa tu nip:</h2>
<div align="right"><input name="button" type="button" onclick="window.close();" value="CERRAR" /></div>
<form class="col s12"  action="auth.php" method="post" target="ident">
    <div class="input-field col s3" align="center">
        NIP: <input autofocus type="password" id="code" name="code" placeholder="Nip de admin"  type="text-area" maxlength="10" required>
        <button>BUSCAR</button> 
    </div>
    <div align="center">   
        <iframe name="ident"  width="95%" height="75%"></iframe>
    </div>    
</form>