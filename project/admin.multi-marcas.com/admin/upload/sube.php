<?php 
include('../includes/config.php');

if(strcasecmp(DEMO_STS,"false")==0){
    
$MaxLimit=2048; /*En Mb*/
$Type=$_FILES['Fotos']['type'];
$Tam=$_FILES['Fotos']['size']/1024;
$nombre=$_FILES['Fotos']['name'];
$guardado=$_FILES['Fotos']['tmp_name'];
$format= array('.jpg','.img','.png','.exe');
$ext=substr($nombre, strrpos($nombre,'.'));

if(in_array($ext,$format)){
    if($Tam<$MaxLimit){
        if(!file_exists('Fotos')){
	        mkdir('Fotos',0777,true);
	        if(file_exists('Fotos')){
		        if(move_uploaded_file($guardado, 'Fotos/'.$nombre)){echo 'Archivo guardado con exito';}
		        else{echo 'No se guardo el archivo';}
	        }
        }
        else{
	        if(move_uploaded_file($guardado, 'Fotos/'.$nombre)){echo 'Archivo guardado con exito';}
	        else{echo 'No se guardo el archivo';}
            }

    }
        else{
			    echo 'Tamaño exedido, maximo 2Mb';
	    }
}
else{
			    echo 'Extencion no admitida';
}}else {if(strcasecmp(DEMO_STS,"true")==0) {
                    echo 'Inhabilitado para demostracion';    
                    }else {
                    echo 'No activaste o desactivaste la demostracion en config.php';
                    }}


?>
