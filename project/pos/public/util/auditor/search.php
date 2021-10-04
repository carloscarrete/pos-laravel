<?php
 include 'conexion.php';
      $aKeyword = explode(" ", utf8_encode($_POST['PalabraClave']));
      $query ="SELECT * FROM products WHERE name like '%" . $aKeyword[0] . "%' OR sku like '%" . $aKeyword[0] . "%'";
      
     for($i = 1; $i < count($aKeyword); $i++) {
        if(!empty($aKeyword[$i])) {
            $query .= " OR sku like '%" . $aKeyword[$i] . "%'";
        }
      }
     
     $result = $db->query($query);
     echo "<div align='center'><br>Resultados con:<b> ". $_POST['PalabraClave']."</b></div>";
                    
     if(mysqli_num_rows($result) > 0) {
        $row_count=0;
        echo "<br><div align='center'>  <table class='table table-striped'>";
        echo "<tr><th><font size='4'>Nombre</font></th><th><font size='4'>SKU</font></th></tr>"; 
        While($row = $result->fetch_assoc()) {   
            $Name = $row['name'];
            $row_count++;                         
            echo "<tr><td style='border: black 1px solid;'><font size='4'>". $Name . "</font></td><td><font size='4' color='blue'><b>". $row['sku'] . "</b></font></td></tr>";
        }
        echo "</table></div>";
	
    }
    else {
        echo "<div align='center'><br><font size='4' color='red'><b>Ningun</b></font> resultado.</div>";
		
    }

 
?>
