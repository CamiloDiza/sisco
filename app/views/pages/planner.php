<?php 
  require_once APP_URL."/controllers/plannerController.php";
  
  $ins = new plannerController;
  $datos = $ins->selects_planner();

  $tipo = $_SESSION['tipo_usuario'];
  $documento = $_SESSION['documento'];
?>

<section class="forms">
	<div class="container-fluid">
		<header> 
      <h1 class="h3 display">Agendar cita</h1>
    </header>
    <div class="row">
    	<div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <form action="<?php echo SERVER_URL ?>app/ajax/plannerAjax.php" method="POST" class="form-group FormularioAjax" data-form="" enctype="multipart/form-data">
              <?php if($tipo == 1 || $tipo == 2){ ?>
              <div class="form-group">
                <label>No. documento del paciente*</label>
                <input list="paciente" name="paciente" required autocomplete="Off" class="form-control">
              </div>

              <datalist id="paciente">
              	<?php foreach($datos['patients'] as $opcion){ ?>
              	<option value="<?php echo $opcion->documento; ?>"><?php echo $opcion->nombres.' '.$opcion->apellidos; }?></option>
              </datalist>

              <?php }elseif($tipo == 3){ ?>
                <div class="form-group">
                  <label>No. documento del paciente*</label>
                  <select name="paciente" required autocomplete="Off" class="form-control">
                    <option value="<?php echo $documento; ?>"><?php echo $documento; ?></option>
                </select>
              </div>
              <?php } ?>

              <div class="form-group">
              	<label>Profesional*</label>
              	<select id="selecprof" name="profesional" class="form-control">
              		<option value="">Seleccione un profesional</option>
              		<?php foreach($datos['professionals'] as $opcion){ ?>
              			<option value="<?php echo $opcion->id_usuario; ?>"><?php echo $opcion->nombres.' '.$opcion->apellidos.' - '.$opcion->tipo_profesional;  }?></option>
              	</select>
              </div>

              <div class="form-group table-horary"></div>
              
              <div class="form-group">       
                <input type="submit" value="Agendar" class="btn btn-primary">
              </div>

              <div class="RespuestaAjax"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
	</div>
</section>