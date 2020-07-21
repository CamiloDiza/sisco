<?php 
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		require_once "../config/config.php";
		require_once "../libs/Alerts.php";

		if(isset($_POST['asistencia']) && !empty($_POST['asistencia']))
		{
			require_once APP_URL."/controllers/dateController.php";

			if($_POST['asistencia'] == 1)
			{
				if(isset($_POST['motivo']) &&
					isset($_POST['obs']) &&
					isset($_POST['diag']) &&
					isset($_POST['trmento']) &&
					isset($_POST['remision']))
				{
					$ins = new dateController;
					$result = $ins->add_date_controller();
				}else{
					$result = Alerts::incomplete_alert();
				}
			}
			elseif($_POST['asistencia'] == 0)
			{
				//Si no asistió a la cita
			}
		}else{
			$result = Alerts::incomplete_alert();
		}
		print_r($result); 
	}else{
		session_start();
		session_destroy();
		echo '<script> window.location.href="'.SERVER_URL.'login/" </script>';
	}