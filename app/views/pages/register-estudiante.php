<?php 
  $requestAjax = true;
  require_once "../../controllers/registerController.php";
  $ins = new registerController;
  $datos = $ins->select();
?>

<div class="col-sm-6 mb-3">
  <label>Programa académico*</label>
  <select name="programa" required class="form-control">
    <?php foreach ($datos['programa'] as $opcion){?>
      <option value="<?php echo $opcion->id_programa; ?>"><?php echo $opcion->programa; }?></option>
  </select>
</div>

<div class="col-sm-6 mb-3">
  <label>Jornada*</label>
  <select id="select" name="jornada" required class="form-control">
      <option value="0">Seleccione una opción</option>
      <option value="diurna">Diurna</option>
      <option value="nocturna">Nocturna</option>
      <option value="sabatina">Sabatina</option>
  </select>
</div>

<div class="col-sm-6 mb-3">
  <label>Actual semestre cursado*</label>
  <input type="number" name="semestre" required min="1" max="10" step="1" class="form-control">
</div>