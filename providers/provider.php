<?php
  $page_title = 'Lista de provider';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $providers = join_provider_table();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="add_provider.php" class="btn btn-primary">Agregar proveedor</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 5%;">N°</th>
                <th class="text-center" style="width: 25%;"> Nombre </th>
                <th class="text-center" style="width: 8%;"> RUC </th>
                <th class="text-center" style="width: 20%;"> Dirección </th>
                <th class="text-center" style="width: 10%;"> Tipo</th>
                <th class="text-center" style="width: 10%;"> Acciones </th>
              </tr>
            </thead>
            
            <tbody>
              <?php foreach ($providers as $provider):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
               

              <td> <?php echo remove_junk($provider['nombre']); ?></td>
              <td class="text-center"> <?php echo remove_junk($provider['ruc']); ?></td>
               
               <td class="text-center"> <?php echo remove_junk($provider['direccion']); ?></td>

              <td class="text-center"> <?php echo remove_junk($provider['tipo']); ?></td>
               
                <td class="text-center">
                  <div class="btn-group">
                    
                     <a href="delete_provider.php?id=<?php echo (int)$provider['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>