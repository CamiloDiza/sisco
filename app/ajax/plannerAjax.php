<?php
	require_once "../config/config.php";
	require_once "../libs/Alerts.php";
	
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		require_once APP_URL."/controllers/plannerController.php";

		$ins = new plannerController;

		if(isset($_POST['paciente']) && !empty($_POST['paciente']) &&
			isset($_POST['profesional']) && !empty($_POST['profesional']) &&
			isset($_POST['fecha_hora']) && !empty($_POST['fecha_hora']))
		{
			echo $ins->add_planner_controller();
		}else{
			echo Alerts::incomplete_alert();
		}
	}else{
		session_start();
		session_destroy();
		echo '<script> window.location.href="'.SERVER_URL.'login/" </script>';
	}