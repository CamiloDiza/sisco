<?php
  require_once "../../config/config.php";
  require_once APP_URL."/controllers/plannerController.php";

  $date = new plannerController;
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $horary = $date->horary_controller($_POST['id']);
  }
?>

<table class="table table-striped table-hover display" id="mytable">
  <thead>
    <tr>
      <th></th>
      <th>Fecha</th>
      <th>Hora</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($horary as $field){
      $fecha = date_create($field->fecha);
      $hora = date_create($field->hora);
      $profesional = $field->profesional?>
    <tr>
      <th>
        <input type="radio" name="fecha_hora" value="<?php echo date_format($fecha, 'Y-m-d').' '.date_format($hora, 'H:i:s').' '.$profesional?>">
      </th>
      <td><?php echo date_format($fecha, 'd-m-y'); ?></td>
      <td><?php echo date_format($hora, 'h:i a'); ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>