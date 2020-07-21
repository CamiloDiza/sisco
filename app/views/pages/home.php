<?php
	require_once "./app/config/LoadViews.php";
	require_once "./app/controllers/logController.php";

	$vw = new LoadViews();
	$viewR = $vw->get_views();

	if($viewR == "login" || $viewR == "404"):
		if($viewR == "login")
		{
			require_once "./app/views/pages/login.php";
		}else{
			require_once "./app/views/pages/404.php";
		}
	else:
		session_start(['SISCO']);

		$isLog = new logController;

		//Si no se ha iniciado sesión redirige al login
		if(!isset($_SESSION['online']) || empty($_SESSION['online']))
		{
			$isLog->forced_logout();
		}else{
			include "./app/views/include/nav-header.php";
			require_once $viewR;
		}
		
		include "./app/views/include/footer.php";
		include "./app/views/include/logout.php";
	endif;
