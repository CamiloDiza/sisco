<?php 
  $requestAjax = true;
  require_once "../../controllers/registerController.php";
  $ins = new registerController;
  $datos = $ins->select();
?>

<div class="col-sm-6 mb-3">
	<label>Vinculante*</label>
	<input list="vinculante" name="vinculante" required autocomplete="Off" class="form-control">

	<datalist  id="vinculante">
		<?php foreach ($datos['usuario'] as $opcion){?>
	  <option value="<?php echo $opcion->documento; ?>"><?php echo $opcion->nombres.' '.$opcion->apellidos; }?></option>
	</datalist >
</div>