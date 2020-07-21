<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		require_once "../config/config.php";
		if(isset($_POST['agenda']) && !empty($_POST['agenda']))
		{
			require_once APP_URL."/controllers/plannerController.php";
			$ins = new plannerController;
		
			echo $ins->delete_planner_controller();
		}
	}else{
		session_start(['SISCO']);
		session_destroy();
		echo '<script> window.location.href="'.SERVER_URL.'login/" </script>';
	}