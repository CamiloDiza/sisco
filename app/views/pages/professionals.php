<?php 
  require_once APP_URL."/controllers/professionalController.php";
  $ins = new professionalController;
  $dates = $ins->consult_professionals_controller();
  $cont = 0;

  $tipo = $_SESSION['tipo_usuario'];
?>

<section>
	<div class="container-fluid">
		<header>
			<h1 class="h3 display">Profesionales de la salud</h1>
		</header>
		<div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover display" id="mytable">
                <?php if($tipo == 1){ ?>  
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre completo</th>
                    <th>Documento</th>
                    <th>Area de la salud</th>
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
                    <td><?php echo $fields->tipo_profesional ?></td>
                    <td><?php echo $fields->telefono ?></td>
                    <td><?php echo $fields->mail ?></td>
                    <td>
                      <button type="submit" class="btn btn-primary">Ver perfil</button>
                      <button type="submit" class="btn btn-secondary">Ver calificaciones</button>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>

                <?php }else if($tipo == 3){ ?>  
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre completo</th>
                    <th>Area de la salud</th>
                    <th>Correo electrónico</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($dates as $fields){ ?>
                  <tr>
                    <th scope="row"><?php echo ++$cont ?></th>
                    <td><?php echo $fields->nombres.' '.$fields->apellidos ?></td>
                    <td><?php echo $fields->tipo_profesional ?></td>
                    <td><?php echo $fields->mail ?></td>
                    <td>
                      <button type="submit" class="btn btn-primary">Ver perfil</button>
                      <button type="submit" class="btn btn-secondary">Calificar</button>
                    </td>
                  </tr>
                </tbody>
                <?php }}elseif($tipo != 1 || $tipo != 3)
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