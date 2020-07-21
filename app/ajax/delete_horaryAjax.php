<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if(isset($_POST['horario']) && !empty($_POST['horario']))
		{
			require_once APP_URL."/controllers/professionalController.php";
			$ins = new professionalController;
		
			echo $ins->register_horary_controller();
		}
	}else{
		session_start(['SISCO']);
		session_destroy();
		echo '<script> window.location.href="'.SERVER_URL.'login/" </script>';
	}