<?php
                                            /*if(isset($_POST['add'])){
                                                
                                            $Password=base64_encode($_POST["pass"]);
                                            
                                            $Auth = "SELECT * from pin WHERE pin=:pin";
                                            $qyAPss = $dbP -> prepare($Auth);
                                            $qyAPss->bindParam(':pin',$Password,PDO::PARAM_STR);
                                            $qyAPss->execute();
                                            $rsAPss=$qyAPss->fetchAll(PDO::FETCH_OBJ);
                                            if($qyAPss->rowCount() > 0){  
                                                foreach($rsAPss as $RAP){
                                                    $userAuth=$RAP->name;
                                                }
                                            }
                                            $UA=$userAuth;
                                                if($UA){*/
                                                date_default_timezone_set('UTC');
                                                date_default_timezone_set("America/Mexico_City");
                                                include('../conect.php');
                                                require_once('../Mail/config.php');
                                                $exist_file = "Documento: <b style=color:red> Sin documento anexado</b>";
                                                $MaxLimit=4096; /*En Mb*/
                                                $Type=$_FILES['Docs']['type'];
                                                $Tam=$_FILES['Docs']['size']/1024;
                                                $nombre=$_FILES['Docs']['name'];
                                                $guardado=$_FILES['Docs']['tmp_name'];
                                                $format= array('.jpg','.img','.png','.pdf');
                                                $ext=substr($nombre, strrpos($nombre,'.'));
                                                
                                                
                                                    $document = $nombre;
                                                    $CashReg=$_POST["cashreg"];
                                                    $ToDate=$_POST["fecha"];
                                                    $Empleado=$_POST["id"];
                                                    $NameEmpleado=$_POST["empid"];
                                                    $Location=$_POST["location"];
                                                    $Category=$_POST["category"];
                                                    $Money=$_POST["cash"];
                                                    $Desctp=$_POST["desc"];
                                                    $today=date("dmY");
                                                    $hour=date("his");
                                                    $invNo="GASTO.$today$CashReg$Location$hour";
                                                    $Tdate=date("Y-m-d H:i:s");
                                                    $b_id = $_POST["bussid"];
                                                    
                                                    
                                                    $InsertCash = "INSERT INTO transactions(business_id, location_id, type, status, payment_status, ref_no, total_before_tax, 
                                                    transaction_date, final_total, created_by, created_at, updated_at, expense_category_id, additional_notes, auth, document, cash_reg_id) 
                                                    values(:bus_id, :loc_id, 'expense','final','paid',:ref,:cash,:data, :cash, :eid,:data,:data,:category, :desc, '0', :docs , :idcash)";
                                                    $QyCsh = $dbP -> prepare($InsertCash);
                                                    $QyCsh->bindParam(':bus_id',$b_id,PDO::PARAM_STR);
                                                    $QyCsh->bindParam(':loc_id',$Location,PDO::PARAM_STR);
                                                    $QyCsh->bindParam(':ref',$invNo,PDO::PARAM_STR);
                                                    $QyCsh->bindParam(':cash',$Money,PDO::PARAM_STR);
                                                    $QyCsh->bindParam(':data',$Tdate,PDO::PARAM_STR);
                                                    $QyCsh->bindParam(':eid',$Empleado,PDO::PARAM_STR);
                                                    $QyCsh->bindParam(':category',$Category,PDO::PARAM_STR);
                                                    $QyCsh->bindParam(':desc',$Desctp,PDO::PARAM_STR);
                                                    $QyCsh->bindParam(':docs',$document,PDO::PARAM_STR);
                                                    $QyCsh->bindParam(':idcash',$CashReg,PDO::PARAM_STR);
                                                    $QyCsh->execute();
                                                    $lastInsertId = $dbP->lastInsertId();
                                                    $TRSC_id = base64_encode($lastInsertId);
                                                    
                                                    $CashReg=base64_encode($CashReg);
                                                     $CashReg=base64_encode($CashReg);
                                                    if($lastInsertId)
                                                    {
                                                        if(in_array($ext,$format)){
                                                            if($Tam<$MaxLimit){
                                                                if(!file_exists('../../Docs')){
                                                	                mkdir('../../Docs',0777,true);
                                                	                if(file_exists('../../Docs')){
                                                	        	        if(move_uploaded_file($guardado, '../../uploads/documents/'.$nombre)){
                                                	        	            $exist_file = "Documento:
                                                	        	                <b style=color:blue> 
                                                	        	                    <a href='https://ventas.saludable.mx/uploads/documents/$nombre' target='_blank'>
                                                	        	                        <i class='btn btn-warning' title='VER DOCUMENTO'>
                                                	        	                            DOCUMENTO
                                                	        	                        </i>
                                                	        	                    </a>
                                                	        	                </b>";
                                                	        	        }
                                                	                }
                                                                }
                                                                else{
                                                	                if(move_uploaded_file($guardado, '../../uploads/documents/'.$nombre)){
                                                	                    $exist_file = "Documento:
                                                	        	          <b style=color:blue> 
                                                	        	              <a href='https://ventas.saludable.mx/uploads/documents/$nombre' target='_blank'>
                                                	        	                  <i class='btn btn-warning' title='DESCARGAR'>
                                                	        	                      DESCARGAR
                                                	        	                  </i>
                                                	        	              </a>
                                                	        	          </b>";
                                                	                }
                                                                    }
                                                            }   
                                                    }
                                                
                                                
                                                        $Auth = "SELECT * from pin WHERE mail IS NOT NULL";
                                                        $qyAPss = $dbP -> prepare($Auth);
                                                        $qyAPss->execute();
                                                        $rsAPss=$qyAPss->fetchAll(PDO::FETCH_OBJ);
                                                        if($qyAPss->rowCount() > 0){  
                                                            foreach($rsAPss as $RAP){
                                                                $userMail=$RAP->mail;
                                                                $nip=$RAP->pin;
                                                                $idadm=$RAP->id;
                                                         
                                                        $BssIdN = "SELECT  * from business_locations WHERE id=:id";
                                                        $QyBssN = $dbP -> prepare($BssIdN);
                                                        $QyBssN->bindParam(':id',$Location,PDO::PARAM_STR);
                                                        $QyBssN->execute();
                                                        $resultBSIDN=$QyBssN->fetchAll(PDO::FETCH_OBJ);
                                                        if($QyBssN->rowCount() > 0){
                                                            foreach($resultBSIDN as $RBI){ 
                                                                $LocateName=$RBI->name; 
                                                            }
                                                        }
                                                        $LNme=$LocateName;
                                                        //HAY ERROR
                                                        $CatSlct = "SELECT * from expense_categories WHERE id=:id";
                                                        
                                                        $QyCtgry = $dbP -> prepare($CatSlct);
                                                        $QyCtgry->bindParam(':id',$Category,PDO::PARAM_STR);
                                                        $QyCtgry->execute();
                                                        $resCatgry=$QyCtgry->fetchAll(PDO::FETCH_OBJ);
                                                        if($QyCtgry->rowCount() > 0){
                                                            foreach($resCatgry as $RCty){ 
                                                                $CtgryName=$RCty->name; 
                                                            }
                                                        }
                                                        $CtName = $CtgryName;
                                                        $Pago = number_format($Money,2);
                                                        $idadm=base64_encode($idadm);
                                                        
                                                        
                                                        $mail->ClearAllRecipients();
                                                        $mail->AddAddress("$userMail");
                                                        $mail->IsHTML(true);  //podemos activar o desactivar HTML en mensaje
                                                        $mail->Subject = "$invNo" ;

                                                        $msg = "
                                                        <h2>Hola! MULTI MARCAS te informa que tienes una nueva solicitud de gasto:</h2>
                                                        <p>Te incluimos los detalles de la solicitud</p>
                                                        <p>Referencia:<b style=color:blue> $invNo </b></p>
                                                        <p>Fecha:<b style=color:black> $Tdate </b></p>
                                                        <p>Empleado:<b style=color:black> $NameEmpleado </b></p>
                                                        <p>Ubicación:<b style=color:black> $LNme </b></p>
                                                        <p>Categoria:<b style=color:blue> $CtName </b></p>
                                                        <p>Comentarios:<b style=color:black> $Desctp </b></p>
                                                        <p>Monto:<b style=color:red> $$Pago </b></p>
                                                        <p>$exist_file </p>
                                                        
                                                        <p><a href='https://sys.multi-marcas.com/public/util/psh/auth.php?code=$TRSC_id&ath=$nip&id=$idadm&cash=$CashReg' target='popup'
                                                        onClick='window.open(this.href, this.target, 'toolbar=1 , location=1 , 
                                                        status=0 , menubar=0 , scrollbars=1 , resizable=0 ,left=200pt,top=150pt,width=1100px,height=550'); 
                                                        return true;'>
                                                        <i class='btn btn-warning' title='AUTORIZA EL GASTO'>
                                                        AUTORIZAR</i></a>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <a href='https://sys.multi-marcas.com/public/util/psh/refuse.php?code=$TRSC_id&ath=$nip&id=$idadm' target='popup'
                                                        onClick='window.open(this.href, this.target, 'toolbar=1 , location=1 , 
                                                        status=0 , menubar=0 , scrollbars=1 , resizable=0 ,left=200pt,top=150pt,width=1100px,height=550'); 
                                                        return true;'>
                                                        <i class='btn btn-warning' title='RECHAZA EL GASTO'>
                                                        RECHAZAR</i></a></p>
                                                        
                                                        <img src='https://sys.multi-marcas.com/uploads/documents/$nombre' width='400px'>
                                                        ";
                                                        
                                                        $mail->Body    = $msg;
                                                        $mail->Send();
                                                       
                                                        }
                                                    }
                                                        
                                                         echo "<script type=''>alert('Agregado correctamente');</script>
                                                                <script type='text/javascript'>
                                                                    function imprimir() {
                                                                        if (window.print) {
                                                                            window.print();
                                                                        } else {
                                                                            alert('La función de impresion no esta soportada por su navegador.');
                                                                        }
                                                                    }
                                                                </script>
                                                                <body onload='imprimir();'>
                                                                <div align='center'>
                                                                    <h1>Solicitud de gasto</h1>
                                                                    </br>Fecha: ".date('H:i d-m-Y')."</br>
                                                                    <b style=color:black> $invNo </b></br>
                                                                    Empleado:<b style=color:black> $NameEmpleado </b></br>
                                                                    Ubicación:<b style=color:black> $LNme </b></br>
                                                                    Categoria:<b style=color:black> $CtName </b></br>
                                                                    Descripción:<b style=color:black> $Desctp </b></br>
                                                                    Monto:<b style=color:black> $$Pago </b></br>
                                                                    <h4>Retirado por: </h4></br></br>
                                                                    <hr/>Nombre y Firma
                                                                </div>
                                                                </body>
                                                                
                                                        ";
                                                        
                                                    }
                                                    else {
                                                        echo "<script type=''>alert('ERROR: CONEXION RECHAZADA MYSQL');</script>";
                                                    }
                                                    
                                                     
                                                    
                                                /*}
                                                else {
                                                    echo "<script type=''>alert('Error: NIP no registrado');</script>";
                                                }
                                            }*/
                                            ?>