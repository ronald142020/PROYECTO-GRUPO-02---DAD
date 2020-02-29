<?php
  $page_title = 'Agregar proveedor';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_providers=find_all('providers');
?>
<?php
 if(isset($_POST['add_provider'])){
   $req_fields = array('ruc_label','nombre_label','direccion_label','tipo_label' );
   validate_fields($req_fields);
   if(empty($errors)){
     $p_ruc  = remove_junk($db->escape($_POST['ruc_label']));
     $p_nombre   = remove_junk($db->escape($_POST['nombre_label']));
     $p_direccion   = remove_junk($db->escape($_POST['direccion_label']));
     $p_tipo   = remove_junk($db->escape($_POST['tipo_label']));
     
     $query  = "INSERT INTO providers (";
     $query .=" ruc,nombre, direccion,tipo";
     $query .=") VALUES (";
     $query .=" '{$p_ruc}', '{$p_nombre}','{$p_direccion}','{$p_tipo}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE ruc='{$p_ruc}'";
     if($db->query($query)){
       $session->msg('s',"Proveedor agregado exitosamente. ");
       redirect('add_provider.php', false);
     } else {
       $session->msg('d',' Lo siento, registro falló.');
       redirect('add_provider.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('add_provider.php',false);
   }

 }

?>


<!DOCTYPE html>
<html lang="es">
<meta charset="utf-8">
  <head>
		<!-- Bootstrap -->
		<!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
      
      <script type="text/javascript" src="provider/js/jquery.min.js"></script>

</head>

	<body>
      <div class="modal-header" style="background:#116FA0; color: white">
               <h4 class="modal-title">
                  <span class="glyphicon glyphicon-user"></span>
                  &nbsp; Información de proveedor - Consulta en SUNAT
               </h4>
      </div>
        

   <form method="post" action="add_provider.php" class="clearfix">
      
      <div class="modal-body">
         
         <div class="form-group">
            <label class="col-sm-2 control-label text-capitalize">RUC:</label>
                  <div class="col-sm-10">
                     <input class="form-control" type="text" id="ruc" name="ruc_label" value="" maxlength="15" autocomplete="off" placeholder="Ingrese el RUC"><br/>       
                  </div>
         </div>

         <div align="center">
               <button class="btn btn-primary hidden-sm" type="submit" onclick="busqueda(); return false">
                  <span class="glyphicon glyphicon-search"></span>&nbsp;<b>Consultar</b>
               </button>
            
         </div><br/>
          

         <div class="form-group">     
            <label class="col-sm-2 control-label text-capitalize">NOMBRE O RAZÓN SOCIAL:</label>
               <div class="col-sm-10">
                     <input class="form-control" type="text" name="nombre_label" id="nombre" autocomplete="off" placeholder="Nombre" readonly="readonly"><br/>
               </div>
         </div>
              
             
         <div class="form-group">
            <label class="col-sm-2 control-label text-capitalize">DIRECCIÓN:</label>
               <div class="col-sm-10">
                     <input type="text" name="direccion_label" id="direccion" class="form-control" autocomplete="off" placeholder="Dirección" readonly="readonly"><br/>
               </div>
         </div>
            
         
         <div class="form-group">
            <label class="col-sm-2 control-label">TIPO:</label>
               <div class="col-sm-10">
                     <input type="text" name="tipo_label" id="tipo" class="form-control" autocomplete="off" placeholder="Tipo" readonly="readonly"><br/>
               </div>
         </div>     
     
         
         <div align="center">
             <button class="btn btn-danger hidden-sm" type="submit" onclick="window.close();">
                  <span class="glyphicon glyphicon-remove-sign"></span>&nbsp; <b>Cancelar</b>
            </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <button class="btn btn-primary hidden-sm" type="submit" name="add_provider">
                  <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp; <b>Enviar</b>
            </button>
            
         </div><br/>
      
      </div>

   </form>






      

        
</body>

           
         
<div class="modal-header" style="background:#116FA0; color: white">
   <footer class="footer text-center">
            <div class="col">
               <p><small>DENIM RESINTEC - PERÚ &copy; </small></p>
            </div>
      </footer>

</div>
		

		   <script type="text/javascript">

   (function($){
   $.ajaxblock    = function(){
      $("body").prepend("<div id='ajax-overlay'><div id='ajax-overlay-body' class='center'><i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i><span class='sr-only'>Loading...</span></div></div>");
      $("#ajax-overlay").css({
         position: 'absolute',
         color: '#FFFFFF',
         top: '0',
         left: '0',
         width: '100%',
         height: '100%',
         position: 'fixed',
         background: 'rgba(39, 38, 46, 0.67)',
         'text-align': 'center',
         'z-index': '9999'
      });
      $("#ajax-overlay-body").css({
         position: 'absolute',
         top: '40%',
         left: '50%',
         width: '120px',
         height: '48px',
         'margin-top': '-12px',
         'margin-left': '-60px',
         //background: 'rgba(39, 38, 46, 0.1)',
         '-webkit-border-radius':   '10px',
         '-moz-border-radius':      '10px',
         'border-radius':        '10px'
      });
      $("#ajax-overlay").fadeIn(50);
   };
   $.ajaxunblock  = function(){
      $("#ajax-overlay").fadeOut(100, function()
      {
         $("#ajax-overlay").remove();
      });
   };
})(jQuery);

		function busqueda(){
               //$this.button('loading');
               $.ajaxblock();
               $.ajax({
                  data: { "nruc" : $("#ruc").val() },
                  type: "POST",
                  dataType: "json",
                  url: "provider/sunat/consulta.php",
               }).done(function( data, textStatus, jqXHR ){
                  if(data['success']!="false" && data['success']!=false)
                  {
                     $("#json_code").text(JSON.stringify(data, null, '\t'));

                     var res = JSON.stringify(data['result']['RUC']);
                    // alert(data['result']['RUC']);
                              //console.log(JSON.stringify(respuesta));
                     $('#direccion').val(data['result']['Direccion']);
                     $('#nombre').val(data['result']['RazonSocial']);
                     $('#tipo').val(data['result']['Tipo']);
                     if(typeof(data['result'])!='undefined')
                     {

                        //$("#tbody").html("");
                        $.each(data['result'], function(i, v)
                        {
                           //$("#tbody").append('<tr><td>'+i+'<\/td><td>'+v+'<\/td><\/tr>');
                           
                        });
                     }

                     $.ajaxunblock();
                  }else{
                     if(typeof(data['msg'])!='undefined')
                     {
                        alert(data['msg']);
                        $('#direccion').val('');
                        $('#tipo').val('');
                        $('#nombre').val('');
                     }
                     //$this.button('reset');
                     $.ajaxunblock();
                  }
               }).fail(function( jqXHR, textStatus, errorThrown ){
                  alert( "Solicitud fallida:" + textStatus );
                  $.ajaxunblock();
               });
   }



</script>
	</body>
</html>

