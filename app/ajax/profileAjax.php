<?php
	require_once "../config/config.php";
	require_once "../libs/Alerts.php";

	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if(isset($_POST['fecha']))
		{
			if(isset($_POST['fecha']) && !empty($_POST['fecha']) &&
				isset($_POST['hora_inicio']) && !empty($_POST['hora_inicio']) &&
				isset($_POST['hora_fin']) && !empty($_POST['hora_fin']))
			{
				$fecha = strtotime($_POST['fecha']);
				$fecha_actual = strtotime(date('Y-m-d'));

				if($fecha >= $fecha_actual)
				{
					$hora_inicio = strtotime($_POST['hora_inicio']);
					$hora_fin = strtotime($_POST['hora_fin']);
					
					if($hora_inicio < $hora_fin) 
					{
						require_once APP_URL."/controllers/professionalController.php";
						$ins = new professionalController;
					
						echo $ins->register_horary_controller();
					}else{
						echo Alerts::sweet_alert('simple',$alert = [
							'title' => 'Las horas no concuerdan!',
							'text' => 'La hora de inicio debe ser menor a la hora de fin',
							'type' => 'warning'
						]);
					}
				}else{
					echo Alerts::sweet_alert('simple',$alert = [
						'title' => 'Fecha no permitida!',
						'text' => 'La fecha introducida debe ser superior a '.date('m-d-Y'),
						'type' => 'warning'
					]);
				}
			}else{
				echo Alerts::incomplete_alert();
			}
		}
		elseif(isset($_POST['horario']) && !empty($_POST['horario']))
		{
			require_once APP_URL."/controllers/professionalController.php";
			$ins = new professionalController;
		
			echo $ins->delete_horary_controller();
		}
		
	}else{echo 'entra';
		session_start(['SISCO']);
		session_destroy();
		echo '<script> window.location.href="'.SERVER_URL.'login/" </script>';
	}