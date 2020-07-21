<?php 
  require_once "app/controllers/patientController.php";

  $ins = new patientController;
  $dates = $ins->consult_patient_controller();
  $vinc = $ins->consult_binding_controller();
?>

<div class="col-md-8">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <p>Datos personales</p>
        <form class="form-group row">
          <div class="form-group col-md-6">
            <label>Nombre completo</label>
            <input type="text" value="<?php echo $dates->nombres; ?>" disabled class="form-control">
          </div>
          <div class="form-group col-md-6">       
            <label>Apellidos</label>
            <input type="text" value="<?php echo $dates->apellidos; ?>" disabled class="form-control">
          </div>
          <div class="form-group col-md-6">       
            <label>Tipo de documento</label>
            <input type="text" value="<?php echo $dates->tipo_documento; ?>" disabled class="form-control">
          </div>
          <div class="form-group col-md-6">       
            <label>Número de documento</label>
            <input type="text" value="<?php echo $dates->documento; ?>" disabled class="form-control">
          </div>
          <div class="form-group col-md-6">       
            <label>Dirección de residencia</label>
            <input type="text" value="<?php echo $dates->residencia_dir; ?>" disabled class="form-control">
          </div>
          <div class="form-group col-md-6">       
            <label>Genero</label>
            <input type="text" value="<?php echo $dates->genero; ?>" disabled class="form-control">
          </div>
          <div class="form-group col-md-6">       
            <label>Edad</label>
            <input type="text" value="<?php echo $dates->edad; ?>" disabled class="form-control">
          </div>
          <div class="form-group col-md-6">       
            <label>Teléfono</label>
            <input type="text" value="<?php echo $dates->telefono; ?>" disabled class="form-control">
          </div>
          <div class="form-group col-md-6">       
            <label>Correo electrónico</label>
            <input type="text" value="<?php echo $dates->mail; ?>" disabled class="form-control">
          </div>
          <div class="form-group col-md-6">       
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

          <div class="form-group col-md-12">       
            <button type="submit" class="btn btn-primary">Editar información</button>
            <button type="submit" class="btn btn-secondary">Cambiar contraseña</button> 
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h3 class="text-center"><i class="zmdi zmdi-assignment-o zmdi-hc-5x"></i><br><a href="<?php echo SERVER_URL ?>mydates/">Ver mis citas</a></h3>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h3 class="text-center"><i class="zmdi zmdi-collection-text zmdi-hc-5x"></i><br><a href="" >Ver mi historial de citas</a></h3>
      </div>
    </div>
  </div>
</div>