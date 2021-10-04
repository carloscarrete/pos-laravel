<?php
include('admin/includes/config.php');

$sql = "SELECT * from tblpedido WHERE conf='1' AND pross='0' AND reciv<>'1' AND entrg<>'1' ORDER BY Mes,Fecha";
$query = $dbh -> prepare($sql);
$query->bindParam(':clientno',$idc,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$notf=0;
    if($query->rowCount() > 0){
        foreach($results as $result){
          $notf++;  
        }
    }
    
  if($notf>0){echo "+($notf)";}
  
  ?>