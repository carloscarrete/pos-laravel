<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0)
    {   
header("location:/admin");
}
else{?>

<!DOCTYPE html>
<html>
<head>

</head>
<body>
    
        
    
    <br>
    <h6>Fotos en SISTEMA:</h6><br>
    <?php
    $directorio='Fotos';
    if($dir = opendir($directorio)) {
        while($Foto=readdir($dir)){
            if($Foto!='.' && $Foto!='..')
                echo "Archivo: <strong>$Foto</strong><br />";
            }
    }

    ?>
    
</body>
</html>
<?php } ?> 