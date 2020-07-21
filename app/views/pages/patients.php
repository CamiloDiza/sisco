<?php 
  require_once"app/controllers/patientController.php";
  $ins = new patientController;
  $dates = $ins->consult_patients_controller();
  $cont = 0;

  $tipo = $_SESSION['tipo_usuario'];
?>
<section>
	<div class="container-fluid">
		<header>
			<h1 class="h3 display">Pacientes</h1>
		</header>
		<div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover display" id="mytable">
                <?php if($tipo == 1 || $tipo == 2){ ?>  
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre completo</th>
                    <th>Documento</th>
                    <th>Tipo de paciente</th>
                    <th>Teléfono</th>
                    <th>Correo electrónico</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($dates as $fields){ ?>
                  <tr>
                    <th scope="row"><?php echo ++$cont ?></th>
                    <td><?php echo $fields->nombres.' '.$fields->apellidos ?></td>
                    <td><?php echo $fields->tipo_documento.' '.$fields->documento ?></td>
                    <td><?php echo $fields->tipo_paciente ?></td>
                    <td><?php echo $fields->telefono ?></td>
                    <td><?php echo $fields->mail ?></td>
                    <td>
                      <button type="submit" class="btn btn-primary">Ver perfil</button>
                      <button type="submit" class="btn btn-secondary">Ver historial</button>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>

                <?php }elseif($tipo != 1 || $tipo != 2)
                  {
                    echo "<script> window.location.href='".SERVER_URL."404/' </script>";
                  } ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>    
	</div>
</section>