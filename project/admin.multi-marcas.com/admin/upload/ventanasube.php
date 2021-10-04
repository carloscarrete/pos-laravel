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
    <label>Subir foto</label>
    <br><br>
	<form action="/admin/upload/sube.php" method="post" enctype="multipart/form-data" target="ident2">
		<input type="file" name="Fotos">
		<br><br><div align="center">
		<button>Subir</button>
	    <br><font size=1>Es peso maximo de la fotografia es de 2mb y solo admite extenciones .jpg, .png y .img</font>
	    </div>
                                
	</form>
	<iframe name="ident2" style="width:0;height:0;border:0; border:none;"></iframe>
	</div>
</body>
</html>
<?php } ?> 