<?php
include('../includes/config.php');
if(strcasecmp(DEMO_STS,"false")==0){    
$Borrado=$_POST['borrararchivo'];
if(unlink('Fotos/'.$Borrado)){
    echo 'Archivo borrado con exito';}
		        else{
		            echo 'Error archivo no existe o esta mal escrito';}}
else {
    if(strcasecmp(DEMO_STS,"true")==0) {
    echo 'Inhabilitado para demostracion';    
    }
    else {
        echo 'No activaste o desactivaste la demostracion en config.php';
    }
}
	
		            
		            

?>