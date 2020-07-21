<?php
	require_once "../config/config.php";
	require_once "../libs/Alerts.php";

	if($_GET['action'] == 'logout')
	{
		require_once APP_URL."/controllers/logController.php";

		$insLog = new logController;
		
		echo $insLog->logout_controller();
	}else{
		session_start(['SISCO']);
		session_destroy();
		echo '<script> window.location.href="'.SERVER_URL.'login/" </script>';
	}