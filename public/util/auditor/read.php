<?php
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
include('../conect.php');
$ath = base64_decode($_GET["auth"]);
?>
<style>
    .hidden{
        visibility: hidden;
        height: 0px;
        width: 0px;
    }
</style>
<form class="col s12"  action="select.php" method="post" target="ident">
    <div class="input-field col s3" align="center">
        Ubicación:
            <select  name="location" autocomplete="off" required>
                <option value="">Selecciona...</option>
                <?php $sql = "SELECT  * from business_locations";
                        $query = $dbP -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $result)
                        {   ?>                                            
                        <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->name);?></option>
                        <?php }} ?>
            </select>
            Tipo de Auditoria:
            <select  name="auditoria" autocomplete="off" required>
                <option value="">Selecciona...</option>
                <option value="0">Completa</option>
                <option value="1">Parcial</option>
            </select>
            <input name="admin" hidden="true" autofocus valign="top"class="materialize-textarea"  type="text-area" value="<?php echo $ath; ?>" readonly required />
        <button>SELECCIONAR</button> 
    </div>
    <div align="center">   
        <iframe name="ident"  width="95%" height="90%" style="border:0;"></iframe>
    </div>    
</form>