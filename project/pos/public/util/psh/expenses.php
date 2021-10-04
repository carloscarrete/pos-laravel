<?php 
include('../conect.php');
require_once('../Mail/config.php');
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
?>
<!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
        <link href="../assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
        <style>
            .hidden{
                visibility: hidden;
                height: 0px;
                width: 0px;
            }
        </style>

        <table class="display responsive-table ">
            <thead>
                <tr>
                    
                        <th width="100"><font style=color:blue>Categoria</font></th>
                        <th width="100"><font style=color:blue>Monto</font></th>
                        <th width="100"><font style=color:blue>Sucursal</font></th>
                        <th width="120"><font style=color:blue>Acción</font></th>
                    
                </tr><hr/>
            </thead>
            <tbody>
            <?php
            $SEARCH= "SELECT * FROM transactions WHERE auth='0'";
            $QyBar = $dbP -> prepare($SEARCH);
            //$QyBar->bindParam(':idl',$location,PDO::PARAM_STR);
            $QyBar->execute();
            $RsBar=$QyBar->fetchAll(PDO::FETCH_OBJ);
            if($QyBar->rowCount() > 0){  
                    foreach($RsBar as $RB){
                        $ID=$RB -> id;
                        $C_ID=$RB -> expense_category_id;
                        $Monto=$RB ->final_total;
                        $L_ID=$RB ->location_id;
                        $REC_VAL=$RB ->rec;
                        
                            $catgry= "SELECT * FROM expense_categories WHERE id=:c_id";
                            $QyCat = $dbP -> prepare($catgry);
		                    $QyCat->bindParam(':c_id',$C_ID,PDO::PARAM_STR);
                            $QyCat->execute();
                            $RsCat=$QyCat->fetchAll(PDO::FETCH_OBJ);
                            if($QyCat->rowCount() > 0){  
                                    foreach($RsCat as $RT){
                                        $NameCat=$RT -> name;
                                    }
                            }
                            $buss= "SELECT * FROM business_locations WHERE id=:l_id";
                            $QyBuss = $dbP -> prepare($buss);
		                    $QyBuss->bindParam(':l_id',$L_ID,PDO::PARAM_STR);
                            $QyBuss->execute();
                            $RsBuss=$QyBuss->fetchAll(PDO::FETCH_OBJ);
                            if($QyBuss->rowCount() > 0){  
                                    foreach($RsBuss as $RB){
                                        $NameLoc=$RB -> name;
                                    }
                            }
                            $VAL = 6;
                            $CODE = base64_encode($ID);
                            $REST = $VAL-$REC_VAL;
                        echo "
                        <tr>
                            <th>$NameCat</th>  
                            <th>$$Monto</th> 
                            <th>$NameLoc</th>
                            <th>";
                                
                            if($REST<2){echo " ";}
                            else{  echo "
                            <a href='/util/psh/send.php?idre=$ID'
                            class='waves-effect waves-orange btn-flat m-b-xs' 
                            title='ENVIAR UN RECORDATORIO' target='under'>RECORDAR</a>
                            <iframe name='under' style='width:0;height:0;border:none; '></iframe>
                            ";}
                            
                            echo "</tr>";
                        
                    }
                }?>
            </tbody>
        </table>
        

        