    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script>
            $("#tuboton").click(function(){
     
      var comentario= $("#tutextarea").val();
      $.post("msg.php?comentario="+escape(comentario), function(){
           
          alert("Tu comentario se ha guardado exitosamente...!");    
       });
     
    });
    </script>
    </head>
    <form id="tuformulario" name="tuformulario">
     
     <textearea id="tutextarea"  name="tutextarea" ></textarea>
     
     
      <button type="button" id="tuboton"></button>
    </form>