<!-- EMPLEADO -->


                    <?php
$eid=$_SESSION['eid'];
$sql = "SELECT FirstName,LastName,EmpId,foto,Password from  tblemployees where id=:eid";
$query = $dbh -> prepare($sql);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{              
$fus=$result->foto;
?>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
    <script>
			    $(document).ready(function(){
			        var refreshId =  setInterval( function(){ 
			            $("#count").load("notfy_c.php");
			        }, 100 );
	    		    
				});

	</script>

     <aside id="slide-out" class="side-nav nav fixed" >
                <div class="side-nav-wrapper" >
                    <div class="sidebar-profile">
                        
                            <img src="../admin/upload/Fotos/<?php echo htmlentities($fus);?>" class="box" alt="" width="100" height="100">
                        
                        <div class="sidebar-profile-info">

                                <p><?php echo htmlentities($result->FirstName." ".$result->LastName);?></p>
                                <span><?php echo htmlentities($result->EmpId)?></span>
                                
                         <?php }} ?>
                        </div>
                    </div>


                    
<ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
  <li class="no-padding"><a class="waves-effect waves-grey" href="notfy"><i class="material-icons">shopping_cart</i>Pedidos Nuevos <font id="count"></font></a></li>
  <li class="no-padding"><a class="waves-effect waves-grey" href="asistencia"><i class="material-icons">how_to_reg</i>Registrar Hoy</a></li>
  <li class="no-padding"><a class="waves-effect waves-grey" href="h_asist"><i class="material-icons">assignment</i>Asistencias</a></li>
  <li class="no-padding"><a class="waves-effect waves-grey" href="perfil"><i class="material-icons">account_box</i>Mi perfil</a></li>
  <li class="no-padding"><a class="waves-effect waves-grey" href="password_c"><i class="material-icons">create</i>Cambia la contraseña</a></li>
  <li class="no-padding"><a class="waves-effect waves-grey" href="permisos"><i class="material-icons">add_circle</i>Nueva Solicitud</a></li>
  <li class="no-padding"><a class="waves-effect waves-grey" href="h_permisos"><i class="material-icons">archive</i>Historial de Solicitudes</a></li>
  <li class="no-padding"><a class="waves-effect waves-grey" href="https://help.multi-marcas.com" target="_blank"><i class="material-icons">sms</i>Chat</a></li>
  <li class="no-padding"><a class="waves-effect waves-grey" href="https://email.multi-marcas.com" target="_blank"><i class="material-icons">mail</i>Correo</a></li>
  <li class="no-padding"><a class="waves-effect waves-grey" href="client_all"><i class="material-icons">group</i>Clientes</a></li>
  <li class="no-padding"><a class="waves-effect waves-grey" href="tutoriales"><i class="material-icons">ondemand_video</i>Video-Tutoriales</a></li>
  <li class="no-padding"><a class="waves-effect waves-grey" href="cerrar"><i class="material-icons">exit_to_app</i>Desconectar</a></li>
</ul>


 
           <div class="footer">
                    <p class="copyright"><a href="http://ventas.multi-marcas.com/">Ventas Centro </a></p>
                    <p class="copyright"><a href="http://ventas2.multi-marcas.com/">Ventas Gpe Victoria </a></p>
                    <p class="copyright"><a href="http://multi-marcas.com/">Pagina WEB </a></p>
                    <p class="copyright"><a href="https://www.facebook.com/serv.tec.la">FACEBOOK </a></p>

                </div>
            </div>
        </aside>
