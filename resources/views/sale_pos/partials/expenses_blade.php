
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
        <script>
			    $(document).ready(function(){
			        $("#exp").load("/util/psh/expenses.php");
			        var refreshId =  setInterval( function(){ 
			            $("#exp").load("/util/psh/expenses.php");
			        }, 10000 );
	    		    
				});

		</script>

<div class="box box-widget">
	<div class="box-header with-border">
        Gastos pendientes de Aprobacion / Rechazo
        <div id="exp"></div>
    </div>
</div>