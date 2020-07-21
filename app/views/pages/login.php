<?php
  include('./app/views/include/head.php');
?>

<!-- SweetAlert2 JS-->
<script src="<?php echo SERVER_URL ?>public/js/sweetalert2.min.js"></script>

<div class="page login-page">
  <div class="container">
    <div class="form-outer text-center d-flex align-items-center">
      <div class="form-inner">
        <div class="logo text-uppercase"><span>SISTEMA DE SALUD</span><strong class="text-primary">COTECNOVA</strong></div>
        
        <form action="" method="POST" class="text-left form-validate" data-form="" enctype="multipart/form-data">
          
          <div class="form-group-material">
            <input id="login-user" type="text" name="loginUser" required data-msg="Por favor ingrese su documento" autocomplete="off" class="input-material">
            <label for="login-user" class="label-material">Número de documento</label>
          </div>

          <div class="form-group-material">
            <input id="login-password" type="password" name="loginPassword" required data-msg="Por favor ingrese su contraseña" autocomplete="off" class="input-material">
            <label for="login-password" class="label-material">Contraseña</label>
          </div>

          <div class="form-group text-center">
            <input type="submit" name="ingresar" id="ingresar" value="Ingresar" class="btn btn-primary">
          </div>

          <br>

          <div class="form-group text-center">
            <p><i class="zmdi zmdi-info"></i> Si ingresa por primera vez al sistema la contraseña es su número de documento de identidad.</p>
          </div>
          <div class="form-group text-center">
            <p>¿Olvidaste tu contraseña?<a href="" class="external">Haz clic aquí para recuperarla</a></p>
          </div>

        </form>

        <div>
          <?php 
            if(isset($_POST['loginUser']) && !empty($_POST['loginUser']) &&
              isset($_POST['loginPassword']) && !empty($_POST['loginPassword']) &&
              isset($_POST['ingresar']) && !empty($_POST['ingresar']))
            {
              require_once APP_URL."/controllers/logController.php";

              $login = new logController;
              echo $login->login_controller();
            }
          ?>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- JavaScript files-->
<script src="<?php echo SERVER_URL ?>public/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo SERVER_URL ?>public/vendor/popper.js/umd/popper.min.js"> </script>
<script src="<?php echo SERVER_URL ?>public/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo SERVER_URL ?>public/js/grasp_mobile_progress_circle-1.0.0.min.js"></script>
<script src="<?php echo SERVER_URL ?>public/vendor/jquery.cookie/jquery.cookie.js"> </script>
<script src="<?php echo SERVER_URL ?>public/vendor/chart.js/Chart.min.js"></script>
<script src="<?php echo SERVER_URL ?>public/vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo SERVER_URL ?>public/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- Main File-->
<script src="<?php echo SERVER_URL ?>public/js/front.js"></script>