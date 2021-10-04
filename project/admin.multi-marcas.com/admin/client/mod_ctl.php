<?php
session_start();
error_reporting(0);
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
include('../includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
    echo "<script type=''>alert('Sesion caducada, inicia nuevamente.');</script>";
    echo "<script lenguaje=\"JavaScript\">window.close();</script>";
}

else{
    
//cklass
if(isset($_GET['ack'])){
$id=$_GET['ack'];
$sql = "update contacts set Cklass='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['dck'])){
$id=$_GET['dck'];
$sql = "update contacts set Cklass='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//castalia
if(isset($_GET['ac'])){
$id=$_GET['ac'];
$sql = "update contacts set Castalia='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['dc'])){
$id=$_GET['dc'];
$sql = "update contacts set Castalia='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//terra
if(isset($_GET['at'])){
$id=$_GET['at'];
$sql = "update contacts set Terra='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['dt'])){
$id=$_GET['dt'];
$sql = "update contacts set Terra='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//onena
if(isset($_GET['ao'])){
$id=$_GET['ao'];
$sql = "update contacts set Onena='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['do'])){
$id=$_GET['do'];
$sql = "update contacts set Onena='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//rinna brunni
if(isset($_GET['ar'])){
$id=$_GET['ar'];
$sql = "update contacts set RinnaB='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['dr'])){
$id=$_GET['dr'];
$sql = "update contacts set RinnaB='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//price shoes
if(isset($_GET['ap'])){
$id=$_GET['ap'];
$sql = "update contacts set PSh='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['dp'])){
$id=$_GET['dp'];
$sql = "update contacts set PSh='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//farelli
if(isset($_GET['af'])){
$id=$_GET['af'];
$sql = "update contacts set Fareli='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['df'])){
$id=$_GET['df'];
$sql = "update contacts set Fareli='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//andrea
if(isset($_GET['aa'])){
$id=$_GET['aa'];
$sql = "update contacts set Andrea='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['da'])){
$id=$_GET['da'];
$sql = "update contacts set Andrea='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//andrea
if(isset($_GET['acl'])){
$id=$_GET['acl'];
$sql = "update contacts set Ciclon='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['dcl'])){
$id=$_GET['dcl'];
$sql = "update contacts set Ciclon='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//jennifer
if(isset($_GET['aj'])){
$id=$_GET['aj'];
$sql = "update contacts set Jenifer='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['dj'])){
$id=$_GET['dj'];
$sql = "update contacts set Jenifer='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//lis
if(isset($_GET['al'])){
$id=$_GET['al'];
$sql = "update contacts set Lis='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['dl'])){
$id=$_GET['dl'];
$sql = "update contacts set Lis='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//lis
if(isset($_GET['aw'])){
$id=$_GET['aw'];
$sql = "update contacts set West='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['dw'])){
$id=$_GET['dw'];
$sql = "update contacts set West='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//moda club
if(isset($_GET['am'])){
$id=$_GET['am'];
$sql = "update contacts set ModC='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['dm'])){
$id=$_GET['dm'];
$sql = "update contacts set ModC='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//verochi
if(isset($_GET['av'])){
$id=$_GET['av'];
$sql = "update contacts set Verochi='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['dv'])){
$id=$_GET['dv'];
$sql = "update contacts set Verochi='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//incognita
if(isset($_GET['ain'])){
$id=$_GET['ain'];
$sql = "update contacts set Incognita='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['din'])){
$id=$_GET['din'];
$sql = "update contacts set Incognita='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//ilusion
if(isset($_GET['ail'])){
$id=$_GET['ail'];
$sql = "update contacts set Ilusion='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['dil'])){
$id=$_GET['dil'];
$sql = "update contacts set Ilusion='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//stop
if(isset($_GET['as'])){
$id=$_GET['as'];
$sql = "update contacts set Stop='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['ds'])){
$id=$_GET['ds'];
$sql = "update contacts set Stop='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//devendi
if(isset($_GET['ad'])){
$id=$_GET['ad'];
$sql = "update contacts set Devendi='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['dd'])){
$id=$_GET['dd'];
$sql = "update contacts set Devendi='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

//impulss
if(isset($_GET['aim'])){
$id=$_GET['aim'];
$sql = "update contacts set Impulss='1' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

if(isset($_GET['dim'])){
$id=$_GET['dim'];
$sql = "update contacts set Impulss='0' WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
header("Location: client_ctl?empid=$id");
}

}
 ?>