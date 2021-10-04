<?php
error_reporting(0);
include('../conect.php');
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");

$Location=$_POST["location"];
$Tipo=$_POST["auditoria"];
$admin=$_POST["admin"];
                
        if($Tipo==0){echo "<script>document.location='completa.php?locate=$Location&admin=$admin'</script>";}
        if($Tipo==1){echo "<script>document.location='parcial.php?locate=$Location&admin=$admin'</script>";}