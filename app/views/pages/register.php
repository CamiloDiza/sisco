<?php 
  $tipo = $_SESSION['tipo_usuario'];
  if($tipo == 1):

  require_once"app/controllers/registerController.php";
  $ins = new registerController;
  $datos = $ins->select();
?>
<section class="forms">
  <div class="container-fluid">
    <header> 
      <h1 class="h3 display">Registro de usuarios</h1>
    </header>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <p>Complete todos los campos obligatorios (*)</p>
            <form action="<?php echo SERVER_URL ?>app/ajax/registerAjax.php" method="POST" class="form-group row FormularioAjax" data-form="" enctype="multipart/form-data">
              <div class="form-group col-md-6">
                <label>Nombre completo*</label>
                <input type="text" placeholder="Nombre completo" name="nombres" required class="form-control">
              </div>
              <div class="form-group col-md-6">       
                <label>Apellidos*</label>
                <input type="text" placeholder="Apellidos" name="apellidos" required class="form-control">
              </div>
              <div class="col-sm-5 mb-3">
                <label>Tipo de documento*</label>
                <select name="tipo_doc" class="form-control">
                  <option value="CC">Cédula de ciudadanía</option>
                  <option value="TI">Targeta de identidad</option>
                  <option value="RC">Registro civil</option>
                  <option value="PA">Pasaporte</option>
                  <option value="CE">Cédula extranjera</option>
                </select>
              </div>
              <div class="form-group col-md-7">       
                <label>Número de documento*</label>
                <input type="text" placeholder="Númeor de documento" name="documento" required class="form-control">
              </div>
              <div class="form-group col-md-12">       
                <label>Dirección de residencia</label>
                <input type="text" placeholder="Dirección de residencia" name="direccion" class="form-control">
              </div>
              <div class="form-group col-md-5">       
                <label>Teléfono*</label>
                <input type="text" placeholder="Teléfono" name="telefono" required class="form-control">
              </div>
              <div class="form-group col-md-7">       
                <label>Correo electrónico*</label>
                <input type="mail" placeholder="Correo electrónico" name="mail" required class="form-control">
              </div>
              <div class="col-sm-5 mb-3">
                <label>Género</label>
                <div class="i-checks">
                  <input id="radioCustom1" type="radio" value="Femenino" name="genero" class="form-control-custom radio-custom">
                  <label for="radioCustom1">Femenino</label>
                  <input id="radioCustom2" type="radio" value="Masculino" name="genero" class="form-control-custom radio-custom">
                  <label for="radioCustom2">Masculino</label>
                </div>
              </div>
              <div class="col-sm-7 mb-3">
                <label>Estado civil</label>
                <div class="i-checks">
                  <input id="radioCustom3" type="radio" value="Soltero(a)" name="estado_civil" class="form-control-custom radio-custom">
                  <label for="radioCustom3">Soltero(a)</label>
                  <input id="radioCustom4" type="radio" value="Casado(a)" name="estado_civil" class="form-control-custom radio-custom">
                  <label for="radioCustom4">Casado(a)</label>
                  <input id="radioCustom5" type="radio" value="Unión libre" name="estado_civil" class="form-control-custom radio-custom">
                  <label for="radioCustom5">Unión libre</label>
                  <input id="radioCustom6" type="radio" value="Divorciado(a)" name="estado_civil" class="form-control-custom radio-custom">
                  <label for="radioCustom6">Divorciado(a)</label>
                  <input id="radioCustom7" type="radio" value="Viudo(a)" name="estado_civil" class="form-control-custom radio-custom">
                  <label for="radioCustom7">Viudo(a)</label>
                </div>
              </div>
              <div class="col-sm-6 mb-3">
                <label>Foto de perfil</label>
                <input type="file" name="foto" class="form-control">
              </div>
              <div class="col-sm-6 mb-3">
                <label>Tipo de usuario*</label>
                <select id="tipo_usuario" name="tipo_usuario" class="form-control">
                  <option value="0">Seleccione una opción</option>
                  <?php foreach ($datos['tipo_user'] as $opcion){?>
                    <option value="<?php echo $opcion->id_tipo_usuario; ?>"><?php echo $opcion->tipo_usuario; }?></option>
                </select>
              </div>
              
              <div id="contenido" class="col-sm-12 row"></div>
 
              <div class="form-group col-md-12">       
                <input type="submit" value="Aceptar" class="btn btn-primary">
              </div>

              <div class="RespuestaAjax"></div>
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php else:
  echo "<script> window.location.href='".SERVER_URL."404/' </script>";
endif;?>