<?php 
  $tipo = $_SESSION['tipo_usuario'];
?>

<section class="forms">      
  <div class="container-fluid">
    <header> 
      <h1 class="h3 display"></h1>
    </header>
    <a href="<?php echo SERVER_URL ?>home/"><span class="d-none d-sm-inline-block">Volver</span></a>
    <div class="row">
      <div class="col-sm-12 row">
        <?php if($tipo == 2)
          {
            include('profile-professional.php');
          }
          elseif($tipo == 3)
          {
            include('profile-patient.php');
          }
        ?>
      </div>
    </div>
  </div>
</section>
