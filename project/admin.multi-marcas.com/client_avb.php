<?php 
require_once("admin/includes/config.php");
// code for empid availablity
if(!empty($_POST["noclt"])) {
	$empid=$_POST["noclt"];
	
$sql ="SELECT EmailId FROM contacts WHERE EmailId=:empid";
$query= $dbh->prepare($sql);
$query-> bindParam(':empid',$empid, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
echo "<span style='color:red'> ID ya Registrada.</span>";
 echo "<script>$('#add').prop('disabled',true);</script>";
} else{
	
echo "<span style='color:green'> ID Disponible .</span>";
echo "<script>$('#add').prop('disabled',false);</script>";
}
}

// code for emailid availablity
if(!empty($_POST["email"])) {
$empid= $_POST["email"];
$sql ="SELECT email FROM contacts WHERE email=:emailid";
$query= $dbh -> prepare($sql);
$query-> bindParam(':emailid',$empid, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Ese correo ya existe .</span>";
 echo "<script>$('#add').prop('disabled',true);</script>";
} else{
	
echo "<span style='color:green'> Correo disponible para registro .</span>";
echo "<script>$('#add').prop('disabled',false);</script>";
}
}




?>
