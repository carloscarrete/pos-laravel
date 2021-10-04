<?php
error_reporting(0);
include('../conect.php');
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");

$Password=base64_encode($_POST["code"]);
                                            
    $Auth = "SELECT * from pin WHERE pin=:pin";
    $qyAPss = $dbP -> prepare($Auth);
    $qyAPss->bindParam(':pin',$Password,PDO::PARAM_STR);
    $qyAPss->execute();
    $rsAPss=$qyAPss->fetchAll(PDO::FETCH_OBJ);
    if($qyAPss->rowCount() > 0){  
        foreach($rsAPss as $RAP){
            $userAuth=$RAP->name;
            $Lunes=$RAP->lunes;
            $Martes=$RAP->martes;
            $Miercoles=$RAP->miercoles;
            $Jueves=$RAP->jueves;
            $Viernes=$RAP->viernes;
            $Sabado=$RAP->sabado;
            $Domingo=$RAP->domingo;
        }
    }
    $UA=$userAuth;
    if(!$UA){echo "<script type=''>alert('NIP no registrado');</script>";}
    else{
    $UA=base64_encode($UA);
    $Dia= date("w");
    echo "<script type=''>alert('Bienvenido $userAuth');</script>";
    
    if($Dia==1){
        if($Lunes==1){echo "<script>document.location='read.php?auth=$UA'</script>";}
        else{echo "<script type=''>alert('Lo siento, hoy no es posible hacer una auditoria.');</script>";
            echo "<script type=''>alert('Tus auditorias solo pueden ser en los dias asignados.');</script>";
        }
    }
    if($Dia==2){
        if($Martes==1){echo "<script>document.location='read.php?auth=$UA'</script>";}
        else{echo "<script type=''>alert('Lo siento, hoy no es posible hacer una auditoria.');</script>";
          echo "<script type=''>alert('Tus auditorias solo pueden ser en los dias asignados.');</script>";
        }
    }
    if($Dia==3){
        if($Miercoles==1){echo "<script>document.location='read.php?auth=$UA'</script>";}
        else{echo "<script type=''>alert('Lo siento, hoy no es posible hacer una auditoria.');</script>";
          echo "<script type=''>alert('Tus auditorias solo pueden ser en los dias asignados.');</script>";
        }
    }
    if($Dia==4){
        if($Jueves==1){echo "<script>document.location='read.php?auth=$UA'</script>";}
        else{echo "<script type=''>alert('Lo siento, hoy no es posible hacer una auditoria.');</script>";
          echo "<script type=''>alert('Tus auditorias solo pueden ser en los dias asignados.');</script>";
        }
    }
    if($Dia==5){
        if($Viernes==1){echo "<script>document.location='read.php?auth=$UA'</script>";}
        else{echo "<script type=''>alert('Lo siento, hoy no es posible hacer una auditoria.');</script>";
          echo "<script type=''>alert('Tus auditorias solo pueden ser en los dias asignados.');</script>";
        }
    }
    if($Dia==6){
        if($Sabado==1){echo "<script>document.location='read.php?auth=$UA'</script>";}
        else{echo "<script type=''>alert('Lo siento, hoy no es posible hacer una auditoria.');</script>";
          echo "<script type=''>alert('Tus auditorias solo pueden ser en los dias asignados.');</script>";
        }
    }
    if($Dia==0){
        if($Domingo==1){echo "<script>document.location='read.php?auth=$UA'</script>";}
        else{echo "<script type=''>alert('Lo siento, hoy no es posible hacer una auditoria.');</script>";
          echo "<script type=''>alert('Tus auditorias solo pueden ser en los dias asignados.');</script>";
        }
    }
?>  
    
<?php
    }
?>