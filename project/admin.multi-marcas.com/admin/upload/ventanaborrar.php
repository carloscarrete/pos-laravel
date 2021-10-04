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
	<title></title>
</head>
<body>

<div class="input-field col m12 s12 white">
    <form action="/admin/upload/borrar.php" method="post" enctype="multipart/form-data" target="ident">

    
        <label for="borrar">Foto a borrar</label><br><br>
        <input id="borrar" name="borrararchivo" placeholder="Instoduce un nombre"  type="text-area" required>
        <button>Borrar</button>
        


        <br><br><font size=1>Introduce el nombre de la fotografia (imagen.img, foto.png, captura.png)</font>


    </form>
    <iframe name="ident" height="50"></iframe>
</div>


</body>
</html>
<?php } ?> 