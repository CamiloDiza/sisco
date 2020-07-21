<?php 
  require_once"app/controllers/dateController.php";
  $ins = new dateController;
  $dates = $ins->consult_dates_controller();
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
                <?php if($tipo == 2){ ?>  
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre completo</th>
                    <th>Documento</th>
                    <th>Fecha/Hora</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($dates as $fields){ 
                      $fecha_hora = date_create($fields->fecha_hora); 
                    ?>
                  <tr>
                    <th scope="row"><?php echo ++$cont ?></th>
                    <td><?php echo $fields->usuario ?></td>
                    <td><?php echo $fields->tipo_documento.' '.$fields->documento ?></td>
                    <td><?php echo date_format($fecha_hora, 'd-m-y h:i a') ?></td>
                    <td>
                      <a target="_blank" href="<?php echo SERVER_URL ?>AST/<?php echo $fields->documento.'?'.$fields->id_agenda ?>" class="btn btn-primary">Valoración</a>
                      <a target="_blank" href="<?php echo SERVER_URL ?>dates?id=<?php echo $fields->id_agenda; ?>" class="btn btn-secondary">Cancelar cita</a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>

                <?php }elseif($tipo != 1)
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