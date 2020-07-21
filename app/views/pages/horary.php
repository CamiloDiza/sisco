<?php
  require_once "./app/controllers/professionalController.php";

  $ins = new professionalController;
  $dates = $ins->consult_horary_controller();

  $tipo = $_SESSION['tipo_usuario'];

  $fecha_actual = date_create(date('Y-m-d'));
  //date_add($fecha_actual, date_interval_create_from_date_string('1 days'));

  if($tipo == 2)
  {
?>

<section class="forms">      
  <div class="container-fluid">
    <header> 
      <h1 class="h3 display"></h1>
    </header>
    <div class="row">
      <a href="<?php echo SERVER_URL ?>profile/"><span class="d-none d-sm-inline-block">Volver</span></a>
      <div class="col-md-12 row"> 
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
                <h3 class="text-center">Disponibilidad registrada</h3>
                <p>Seleccione una o varias filas para eliminar un registro.</p>
                <form action="<?php echo SERVER_URL ?>app/ajax/profileAjax.php" method="POST" class="form-group row FormularioAjax" data-form="" enctype="multipart/form-data">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover display" id="mytable">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Fecha</th>
                          <th>Hora de inicio</th>
                          <th>Hora de fin</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($dates as $field){ 
                          $fecha = date_create($field->fecha);
                          $hora_inicio = date_create($field->hora_inicio); 
                          $hora_fin = date_create($field->hora_fin); 
                        ?>
                        <tr>
                          <th>
                            <input type="checkbox" name="horario[]" value="<?php echo $field->id_horario ?>">
                          </th>
                          <td><?php echo date_format($fecha, 'd-m-y')?></td>
                          <td><?php echo date_format($hora_inicio, 'h:i a')?></td>
                          <td><?php echo date_format($hora_fin, 'h:i a')?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    <div class="form-group">
                      <input type="submit" name="eliminar" value="Eliminar" class="mr-3 btn btn-primary">
                    </div>
                  </div>
                  <div class="RespuestaAjax"></div>
                </form>
            </div>
          </div>
        </div>
        
        <!-- Registro de horario -->
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h3 class="text-center">Registrar nuevo horario</h3>
              <form action="<?php echo SERVER_URL ?>app/ajax/profileAjax.php" method="POST" class="form-group row FormularioAjax" data-form="" enctype="multipart/form-data">
                <div class="form-group col-md-12">
                  <label>Fecha*</label>
                  <input type="date" name="fecha" required min="<?php echo date_format($fecha_actual, 'Y-m-d')?>" class="form-control">
                </div>
                <div class="form-group col-md-6">
                  <label>Hora de inicio*</label>
                  <input type="time" name="hora_inicio" required class="form-control">
                </div>
                <div class="form-group col-md-6">
                  <label>Hora de fin*</label>
                  <input type="time" name="hora_fin" required class="form-control">
                </div>
                <div class="form-group col-md-12">       
                  <input type="submit" name="registrar" value="Registrar" class="btn btn-primary">
                </div>
                <div class="RespuestaAjax"></div>
              </form>
            </div>
          </div>
        </div>
     </div>
    </div>
  </div>
</section>
<?php }elseif($tipo != 2){
  echo "<script> window.location.href='".SERVER_URL."404/' </script>";
} ?>