<?php 
  $requestAjax = true;
  require_once "../../controllers/registerController.php";
  $ins = new registerController;
  $datos = $ins->select();
?>

<div class="col-sm-6 mb-3">
	<label>Tipo de profesional*</label>
	<select name="tipo_profesional" required class="form-control">
		<option value="0">Seleccione una opción</option>
	  <?php foreach ($datos['tipo_prof'] as $opcion){?>
	    <option value="<?php echo $opcion->id_tipo_prof; ?>"><?php echo $opcion->tipo_profesional; }?></option>
	</select>
</div>