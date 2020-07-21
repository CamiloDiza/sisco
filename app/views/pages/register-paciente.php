<?php 
  $requestAjax = true;
  require_once "../../controllers/registerController.php";
  $ins = new registerController;
  $datos = $ins->select();
?>

<div class="col-sm-6 mb-3">
  <label>Tipo de paciente*</label>
  <select id="tipo_paciente" name="tipo_paciente" required class="form-control">
    <option value="0">Seleccione una opción</option>
    <?php foreach ($datos['tipo_pac'] as $opcion){?>
      <option value="<?php echo $opcion->id_tipo_paciente; ?>"><?php echo $opcion->tipo_paciente; }?></option>
  </select>
</div>

<div class="col-sm-6 mb-3">
  <label>Edad*</label>
  <input type="number" name="edad" placeholder="Edad" required min="1" max="100" step="1" class="form-control">
</div>

<div id="contenido2" class="col-sm-12 row"></div>

<script>
  $('#tipo_paciente').change(function(){
      
    var opcion_paciente = $(this).val();

    if(opcion_paciente == 2) 
    {
      $.ajax({
        async: true,
        url: "<?php echo SERVER_URL; ?>app/views/pages/register-egresado.php",
        success: function(data2){
          $('#contenido2').css('display','flex');
          $('#contenido2').html(data2);
        }
      });
    }
    else if(opcion_paciente == 1) 
    {
      $.ajax({
        async: true,
        url: "<?php echo SERVER_URL; ?>app/views/pages/register-estudiante.php",
        success: function(data2){
          $('#contenido2').css('display','flex');
          $('#contenido2').html(data2);
        }
      });
    }
    else if(opcion_paciente == 3) 
    {
      $.ajax({
        async: true,
        url: "<?php echo SERVER_URL; ?>app/views/pages/register-vinculado.php",
        success: function(data2){
          $('#contenido2').css('display','flex');
          $('#contenido2').html(data2);
        }
      });
    }else{
      $('#contenido2').css('display','none');
    }
  });
</script>