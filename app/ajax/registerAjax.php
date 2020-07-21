<?php
	require_once "../config/config.php";
	require_once "../libs/Alerts.php";

	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		//Validar que datos obligatorios del formulario hayan sido enviados
		if(isset($_POST['nombres']) && !empty($_POST['nombres']) &&
			isset($_POST['apellidos']) && !empty($_POST['apellidos']) &&
			isset($_POST['tipo_doc']) && !empty($_POST['tipo_doc']) &&
			isset($_POST['documento']) && !empty($_POST['documento']) &&
			isset($_POST['telefono']) && !empty($_POST['telefono']) &&
			isset($_POST['mail']) && !empty($_POST['mail']) &&
			isset($_POST['tipo_usuario']) && !empty($_POST['tipo_usuario']))
		{
			require_once APP_URL."/controllers/registerController.php";
			$insUser = new registerController;

			//Si el tipo de usuario es profesional
			if($_POST['tipo_usuario'] == 2) 
			{
			 	if(!isset($_POST['tipo_profesional']) && empty($_POST['tipo_profesional']))
			 	{
			 		$error = Alerts::incomplete_alert();
					
					echo $error;
			 	}else{
			 		echo $insUser->add_user_controller();
			 	}
			}
			//Si el tipo de usuario es paciente
			elseif($_POST['tipo_usuario'] == 3) 
			{
			 	if(isset($_POST['tipo_paciente']) && !empty($_POST['tipo_paciente']) &&
			 		isset($_POST['edad']) && !empty($_POST['edad']))
			 	{
			 		//Si el tipo de paciente es estudiante
			 		if($_POST['tipo_paciente'] == 1)
			 		{
			 			if(!isset($_POST['programa']) && empty($_POST['programa']) &&
			 				!isset($_POST['jornada']) && empty($_POST['jornada']) &&
			 				!isset($_POST['semestre']) && empty($_POST['semestre']))
			 			{
			 				$error = Alerts::incomplete_alert();
							
							echo $error;
			 			}else{
			 				echo $insUser->add_user_controller();
			 			}
			 		}
			 		//Si el tipo de paciente es egresado
			 		elseif($_POST['tipo_paciente'] == 2)
			 		{
			 			if(!isset($_POST['egreso']) && empty($_POST['egreso']))
			 			{
			 				$error = Alerts::incomplete_alert();
							
							echo $error;
			 			}else{
			 				echo $insUser->add_user_controller();
			 			}
			 		}
			 		//Si el tipo de paciente es vinculado
			 		elseif($_POST['tipo_paciente'] == 3)
			 		{
			 			if(!isset($_POST['vinculante']) && empty($_POST['vinculante']))
			 			{
			 				$error = Alerts::incomplete_alert();
							
							echo $error;
			 			}else{
			 				echo $insUser->add_user_controller();
			 			}
			 		}else{
			 			echo $insUser->add_user_controller();
			 		}
			 	}else{
			 		$error = Alerts::incomplete_alert();
					
					echo $error;
			 	}
			} 
		}else{
			$error = Alerts::incomplete_alert();
			
			echo $error;
		}
	}else{
		session_start();
		session_destroy();
		echo '<script> window.location.href="'.SERVER_URL.'login/" </script>';
	}