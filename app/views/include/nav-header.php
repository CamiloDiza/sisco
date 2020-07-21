<?php
  include('head.php');
  $usuario = $_SESSION['usuario'];
  $foto = $_SESSION['foto'];
  $tipo = $_SESSION['tipo_usuario'];

  require_once "app/config/config.php";
  
?>

<nav class="side-navbar">
  <div class="side-navbar-wrapper">
    <!-- Sidebar Header    -->
    <div class="sidenav-header d-flex align-items-center justify-content-center">
      
      <!-- Informacíon de usuario-->
      <div class="sidenav-header-inner text-center"><img src="<?php echo SERVER_URL; ?>app/files/profile_pictures/<?php echo $foto ?>" alt="person" class="img-fluid rounded-circle">
        <h2 class="h5"><?php echo $usuario ?></h2>
      </div>

      <!-- Small Brand information, appears on minimized sidebar-->
      <div class="sidenav-header-logo"><a href="<?php echo SERVER_URL; ?>home/"" class="brand-small text-center"> <strong>S</strong><strong class="text-primary">C</strong></a></div>
    </div>
    <div class="main-menu">
      <h5 class="sidenav-heading">Menú principal</h5>
  		<?php if($tipo == 1){ ?>
  		<!-- Navbar Directivo -->
	  	<ul id="side-main-menu" class="side-menu list-unstyled">           
		    <li><a href="<?php echo SERVER_URL; ?>home/"> <i class="icon-home"></i>Inicio</a></li>
		    <li><a href="<?php echo SERVER_URL; ?>register/"> <i class="icon-close"></i>Registrar usuario</a></li>
		    <li><a href="<?php echo SERVER_URL; ?>planner/"> <i class="icon-padnote"></i>Agendar cita</a></li>
		    <li><a href="<?php echo SERVER_URL; ?>professionals/"> <i class="icon-list-1"></i>Profesionales</a></li>
		    <li><a href="<?php echo SERVER_URL; ?>patients/"> <i class="icon-list-1"></i>Pacientes</a></li>
		    <li><a href="#"> <i class="icon-page"></i>Reportes</a></li>
	    </ul>
	    <?php }elseif($tipo == 2){ ?>
	    <!-- Navbar Profesional -->
	  	<ul id="side-main-menu" class="side-menu list-unstyled">           
		    <li><a href="<?php echo SERVER_URL; ?>home"> <i class="icon-home"></i>Inicio</a></li>
		    <li><a href="<?php echo SERVER_URL; ?>planner/"> <i class="icon-padnote"></i>Agendar cita</a></li>
		    <li><a href="<?php echo SERVER_URL; ?>profile/"> <i class="icon-user"></i>Mi perfil</a></li>
		    <li><a href="<?php echo SERVER_URL; ?>patients/"> <i class="icon-list-1"></i>Pacientes</a></li>
		    <li><a href="<?php echo SERVER_URL; ?>dates/"> <i class="icon-check"></i>Citas</a></li>
		    <li><a href="#"> <i class="icon-page"></i>Reportes</a></li>
	    </ul>
	    <?php }elseif($tipo == 3){ ?>
	    <!-- Navbar Paciente -->
	  	<ul id="side-main-menu" class="side-menu list-unstyled">           
		    <li><a href="<?php echo SERVER_URL; ?>home/"> <i class="icon-home"></i>Inicio</a></li>
		    <li><a href="<?php echo SERVER_URL; ?>planner/"> <i class="icon-padnote"></i>Agendar cita</a></li>
		    <li><a href="<?php echo SERVER_URL; ?>profile/"> <i class="icon-user"></i>Mi perfil</a></li>
		    <li><a href="<?php echo SERVER_URL; ?>professionals/"> <i class="icon-list-1"></i>Profesionales</a></li>
	    </ul>
		<?php } ?>
	</div>
  </div>
</nav>

<div class="page" style="background-image: url('http://localhost/sisco/public/img/Logo_tr.png');background-repeat: no-repeat;background-size: contain;background-position: bottom;">
<header class="header">
	<nav class="navbar">
	  	<div class="container-fluid">
	    	<div class="navbar-holder d-flex align-items-center justify-content-between">
	      		<div class="navbar-header">
	      			<a id="toggle-btn" href="<?php echo SERVER_URL; ?>home/" class="menu-btn"><i class="icon-bars"> </i></a><a href="<?php echo SERVER_URL; ?>home/" class="navbar-brand">
	          			<div class="brand-text d-none d-md-inline-block"><span>SISTEMA DE SALUD</span> <strong class="text-primary">COTECNOVA</strong></div>
	          		</a>
	          	</div>
		      	<ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
			    	<li class="nav-item"><a href="" class="nav-link logout"><span class="d-none d-sm-inline-block">Salir</span><i class="fa fa-sign-out"></i></a></li>
			    </ul>
	    	</div>
	  	</div>
	</nav>
</header>
<div >    