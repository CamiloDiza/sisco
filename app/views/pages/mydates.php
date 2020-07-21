<?php
	require_once"app/controllers/dateController.php";

	$tipo = $_SESSION['tipo_usuario'];
	$ins = new dateController;

	
	$cont = 0;

	

	
?>
<section class="forms">
	<div class="container-fluid">
	    <header> 
	      	<h1 class="h3 display"></h1>
	    </header>
	    <div class="row">
	    	<a href="<?php echo SERVER_URL ?>profile/"><span class="d-none d-sm-inline-block">Volver</span></a>
	      	<div class="col-sm-12 row">
	      		<?php if($tipo == 2){ 
	      			$dates = $ins->consult_dates0_controller($_SESSION['documento']);
	      		?>
				<div class="col-md-6">
				    <div class="card">
				      <div class="card-body">
				        <header> 
					      	<h1 class="h3 display">Citas por asignar</h1>
					      	<p>Seleccione una o varias filas para eliminar un registro.</p>
					    </header>
					    <form action="<?php echo SERVER_URL ?>app/ajax/delete_plannerAjax.php" method="POST" class="form-group FormularioAjax" data-form="" enctype="multipart/form-data">
							<table class="table table-striped table-hover display" id="mytable">
								<thead>
									<tr>
										<th></th>
										<th>Fecha</th>
										<th>Hora</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($dates as $datos) {
										$fecha = date_create($datos->fecha);
										$hora = date_create($datos->hora);
									?>
									<tr>
										<th><input type="checkbox" name="agenda[]" value="<?php echo $datos->id_agenda ?>"></th>
										<th><?php echo date_format($fecha, 'd-m-y') ?></th>
										<th><?php echo date_format($hora, 'h:i a') ?></th>
									</tr>
								<?php } ?>
								</tbody>
							</table>
							<div class="form-group">
		                      	<input type="submit" name="eliminar" value="Eliminar" class="mr-3 btn btn-primary">
		                    </div>
		                    <div class="RespuestaAjax"></div>
				        </form>
				      </div>
				    </div>
				</div>
				<?php }elseif ($tipo = 3) {
					$datesP = $ins->consult_dates1_controller();
				?>
					<div class="col-md-12">
					    <div class="card">
					      <div class="card-body">
					        <header> 
						      	<h1 class="h3 display">Mis citas</h1>
						    </header>
						    
								<table class="table table-striped table-hover display" id="mytable">
									<thead>
										<tr>
											<th>Fecha</th>
											<th>Hora</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($datesP as $datos) {
											$fecha = date_create($datos->fecha);
											$hora = date_create($datos->hora);
										?>
										<tr>
											<th><?php echo date_format($fecha, 'd-m-y') ?></th>
											<th><?php echo date_format($hora, 'h:i a') ?></th>
										</tr>
									<?php } ?>
									</tbody>
								</table>
					      </div>
					    </div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</section>