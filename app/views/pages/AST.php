<?php
  $url = explode('/', $_SERVER["REQUEST_URI"]);
  $dt = explode('?', $url[3]);
  
  //require_once "../../config/config.php";
  require_once APP_URL."/controllers/dateController.php";
  require_once APP_URL."/controllers/plannerController.php";
  require_once APP_URL."/controllers/professionalController.php";
  require_once APP_URL."/libs/Alerts.php";
  
  $ins = new dateController;
  $date = new plannerController;
  $prof = new professionalController;

  $ck = ['paciente' => $dt[0], 'cita' => $dt[1]];
  
  $dates = $ins->ast_controller($ck);
  $id = $prof->consult_professional_controller($_SESSION['documento']);
  $horary = $date->horary_controller($id->id_usuario);

  $profesional = $id->id_profesional;

  if($dates == 'no_exist')
  {
    echo '<script>
            alert("Ha ocurrido un error inesperado. Vuelva a intetarlo.");
            window.close();
          </script>';
  }
?>

<section class="forms">
  <div class="container-fluid">
    <header> 
      <h1 class="h3 display"></h1>
    </header>
    <div class="col-md-12">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form action="<?php echo SERVER_URL ?>app/ajax/ASTAjax.php" method="POST" class="form-group row FormularioAjax" data-form="" enctype="multipart/form-data">

              <input type="text" name="paciente" value="<?php echo $dt[0] ?>" style="display: none;">
              <input type="text" name="profesional" value="<?php echo $profesional ?>" style="display: none;">
              <input type="text" name="cita" value="<?php echo $dt[1] ?>" style="display: none;">

              <div class="card-header d-flex align-items-center col-md-12">
                <h4>Información general del paciente</h4>
              </div>
              <div class="form-group col-md-6">
                <label>Nombres</label>
                <input type="text" value="<?php echo $dates->nombres; ?>" disabled class="form-control">
              </div>
              <div class="form-group col-md-6">       
                <label>Apellidos</label>
                <input type="text" value="<?php echo $dates->apellidos; ?>" disabled class="form-control">
              </div>
              <div class="form-group col-md-6">       
                <label>Dirección de residencia</label>
                <input type="text" value="<?php echo $dates->residencia_dir; ?>" disabled class="form-control">
              </div>
              <div class="form-group col-md-6">       
                <label>Teléfono del paciente</label>
                <input type="text" value="<?php echo $dates->telefono; ?>" disabled class="form-control">
              </div>
              <div class="form-group col-md-4">       
                <label>Nombre de acudiente</label>
                <input type="text" name="res" class="form-control">
              </div>
              <div class="form-group col-md-4">       
                <label>Teléfono del acudiente</label>
                <input type="text" name="tel_res" class="form-control">
              </div>
              <div class="form-group col-md-4">       
                <label>Correo electrónico del acudiente</label>
                <input type="mail" name="mail_res" class="form-control">
              </div>
              <div class="form-group col-md-4">       
                <label>Género</label>
                <input type="text" value="<?php echo $dates->genero; ?>" disabled class="form-control">
              </div>
              <div class="form-group col-md-4">       
                <label>Edad</label>
                <input type="text" value="<?php echo $dates->edad; ?>" disabled class="form-control">
              </div>
              <div class="form-group col-md-4">       
                <label>Estado civil</label>
                <input type="text" value="<?php echo $dates->estado_civil; ?>" disabled class="form-control">
              </div>

              <?php if($dates->tipo_paciente == 'Estudiante'){?>
                <div class="form-group col-md-6">       
                  <label>Semestre</label>
                  <input type="text" value="<?php echo $dates->semestre; ?>" disabled class="form-control">
                </div>
                <div class="form-group col-md-6">       
                  <label>Jornada</label>
                  <input type="text" value="<?php echo $dates->jornada; ?>" disabled class="form-control">
                </div>
                <div class="form-group col-md-6">       
                  <label>Programa</label>
                  <input type="text" value="<?php echo $dates->programa; ?>" disabled class="form-control">
                </div>
              <?php }elseif($dates->tipo_paciente == 'Egresado'){?>
                <div class="form-group col-md-6">       
                  <label>Año de egreso</label>
                  <input type="text" value="<?php echo $dates->año_egreso; ?>" disabled class="form-control">
                </div>
              <?php }elseif($dates->tipo_paciente == 'Vinculado'){?>
                <div class="form-group col-md-6">       
                  <label>Vinculante</label>
                  <input type="text" value="<?php echo $vinc->vinculante.' - '.$vinc->documento; ?>" disabled class="form-control">
                </div>
              <?php } ?>

              <div class="card-header d-flex align-items-center col-md-12">
                <h4>Confirmar asistencia</h4>
              </div>
              <div class="col-md-12">
                <div class="i-checks">
                  <label>¿El/La paciente asistió a la cita?</label>
                  <input id="si_as" type="radio" value="1" name="asistencia" class="form-control-custom radio-custom">
                  <label for="si_as">Si asistió</label>
                  <input id="no_as" type="radio" value="0" name="asistencia" class="form-control-custom radio-custom">
                  <label for="no_as">No asistió</label>
                </div>
              </div>

              <div class="card-header d-flex align-items-center col-md-12">
                <h4>Motivo de consulta</h4>
              </div>
              <div class="form-group col-md-12">
                <textarea name="motivo" rows="4" cols="50" maxlengtg="100" class="form-control"></textarea>
              </div>

              <div class="card-header d-flex align-items-center col-md-12">
                <h4>Observaciones</h4>
              </div>
              <div class="form-group col-md-12">
                <textarea name="obs" rows="4" cols="50" maxlengtg="100" class="form-control"></textarea>
              </div>

              <div class="card-header d-flex align-items-center col-md-12">
                <h4>Diagnostico</h4>
              </div>
              <div class="form-group col-md-12">
                <textarea name="diag" rows="4" cols="50" maxlengtg="100" class="form-control"></textarea>
              </div>

              <div class="card-header d-flex align-items-center col-md-12">
                <h4>Tratamiento</h4>
              </div>
              <div class="form-group col-md-12">
                <textarea name="trmento" rows="4" cols="50" maxlengtg="100" class="form-control"></textarea>
              </div>

              <div class="card-header d-flex align-items-center col-md-12">
                <h4>Remisión</h4>
              </div>
              <div class="col-md-4">
                <label>¿Remitir a este paciente a un profesional externo?</label>
                <div class="i-checks">
                  <input id="rem_si" type="radio" value="1" name="remision" class="form-control-custom radio-custom">
                  <label for="rem_si">Si</label>
                  <input id="rem_no" type="radio" value="0" name="remision" class="form-control-custom radio-custom">
                  <label for="rem_no">No</label>
                </div>
              </div>
              
              <div class="card-header d-flex align-items-center col-md-12">
                <h4>Agendar nueva cita</h4>
              </div>
              <div class="col-md-6">
                <table class="table table-striped table-hover display" id="mytable">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Fecha</th>
                      <th>Hora</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($horary as $field){
                      $fecha = date_create($field->fecha);
                      $hora = date_create($field->hora);
                      $profesional = $field->profesional?>
                    <tr>
                      <th>
                        <input type="radio" name="prox" value="<?php echo date_format($fecha, 'Y-m-d').' '.date_format($hora, 'H:i:s').' '.$profesional?>">
                      </th>
                      <td><?php echo date_format($fecha, 'd-m-y'); ?></td>
                      <td><?php echo date_format($hora, 'h:i a'); ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>

              <div class="form-group col-md-12">       
                <input type="submit" value="Guardar" class="btn btn-primary">
              </div>

              <div class="RespuestaAjax"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>