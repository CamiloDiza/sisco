<?php 
  require_once "app/controllers/professionalController.php";

  $ins = new professionalController;
  $dates = $ins->consult_professional_controller($_SESSION['documento']);
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
            <label>Genero</label>
            <input type="text" value="<?php echo $dates->genero; ?>" disabled class="form-control">
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
            <label>Perfil profesional</label>
            <textarea disabled class="form-control"><?php echo $dates->experiencia; ?></textarea>
          </div>
          <div class="form-group col-md-6">       
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
        <h3 class="text-center"><i class="zmdi zmdi-assignment-o zmdi-hc-5x"></i><br><a href="<?php echo SERVER_URL ?>mydates/">Mis citas</a></h3>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h3 class="text-center"><i class="zmdi zmdi-calendar-note zmdi-hc-5x"></i><br><a href="<?php echo SERVER_URL ?>horary/">Disponibilidad horaria</a></h3>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h3 class="text-center"><i class="zmdi zmdi-comment-edit zmdi-hc-5x"></i><br><a href="<?php echo SERVER_URL ?>">Evaluaciones de los pacientes</a></h3>
      </div>
    </div>
  </div>
</div>