<?php
    $employe_id=$_GET["c"];
?>
<style>
    .hidden{
        visibility: hidden;
        height: 0px;
        width: 0px;
    }
</style>
<title>Devoluciones</title>
<h2>Devoluciones:</h2>
<div align="right"><input name="button" type="button" onclick="window.close();" value="CERRAR" /></div>
<form class="col s12"  action="due.php" method="post" target="ident">
    <div class="hidden"><input name="empid" value="<?php echo $employe_id;?>" type="text" maxlength="10" required readonly></div>
    <div class="input-field col s3" align="center">
        Folio de venta: <input autofocus id="code" name="code" placeholder="000000000"  type="text-area" maxlength="30" required>
        <button>BUSCAR</button> 
    </div>
    <div align="center">   
        <iframe name="ident"  width="95%" height="85%"></iframe>
    </div>    
</form>