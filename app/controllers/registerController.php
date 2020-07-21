<?php
	require_once dirname(dirname(__FILE__))."/models/registerModel.php";
	require_once APP_URL."/libs/Security.php";
	require_once APP_URL."/libs/Alerts.php";

	class registerController extends registerModel
	{
		public function add_user_controller()
		{
			//Limpiar y obtener campos obligatorios del form
			$nombres = Security::clear_string($_POST['nombres']);
			$apellidos = Security::clear_string($_POST['apellidos']);
			$tipo_doc = Security::clear_string($_POST['tipo_doc']);
			$documento = Security::clear_string($_POST['documento']);
			$telefono = Security::clear_string($_POST['telefono']);
			$mail = Security::clear_string($_POST['mail']);
			$tipo_usuario = Security::clear_string($_POST['tipo_usuario']);

			//Limpiar y obtener campos NO obligatorios del form
			if(isset($_POST['direccion'])){
				$direccion = Security::clear_string($_POST['direccion']);
			}else{
				$direccion='';
			}
			if(isset($_POST['genero'])){
				$genero = Security::clear_string($_POST['genero']);
			}else{
				$genero='';
			}
			if(isset($_POST['estado_civil'])){
				$estado_civil = Security::clear_string($_POST['estado_civil']);
			}else{
				$estado_civil='';
			}

			// Obtener datos de la imagen
			$img_name = $_FILES['foto']['name'];
			$type = $_FILES['foto']['type'];
			$size = $_FILES['foto']['size'];
			$tmp = $_FILES['foto']['tmp_name'];

			//Si existe imagen 
			if($img_name != NULL)
			{
				$img_name = $documento.'-'.$_FILES['foto']['name'];
				//Si tiene un tamaño correcto
				if($size <= 200000)
				{
					//Formatos permitidos 
					if($type == "image/png" || $type == "image/jpg" || $type == "image/jpeg")
					{
						//Ruta donde se guardarán las imágenes
						$dest = dirname(dirname(__FILE__))."/files/profile_pictures/";

						//Mover imagen desde el directorio temporal a ruta indicada
						move_uploaded_file($tmp, $dest.$img_name);
					}else{
						$result = Alerts::sweet_alert('simple',$alert = [
							'title' => 'Formato no permitido',
							'text' => 'La imagen subida debe ser .png, .jpg o .jpeg',
							'type' => 'warning'
						]);
						return $result;
					}
				}else{
					$result = Alerts::sweet_alert('simple',$alert = [
						'title' => 'Tamaño excedido',
						'text' => 'La imagen subida no debe pesar mas de 2--',
						'type' => 'warning'
					]);
					return $result;
				}
			}else{
				$img_name = 'default.png';
			}

			$dates = [
				'nombres' => $nombres,
				'apellidos' => $apellidos,
				'tipo_doc' => $tipo_doc,
				'documento' => $documento,
				'direccion' => $direccion,
				'telefono' => $telefono,
				'mail' => $mail,
				'genero' => $genero,
				'estado_civil' => $estado_civil,
				'foto' => $img_name, 
				'tipo_usuario' => $tipo_usuario
			];

			//Enviar datos al modelo
			$register_user = registerModel::add_user_model($dates);

			//Muestra una alerta según el resultado de la consulta
			switch ($register_user) 
			{
				case 'user_exist':
					$result = Alerts::sweet_alert('simple',$alert = [
						'title' => 'Documento registrado',
						'text' => 'El documento de identidad ingresado ya está registrado',
						'type' => 'error'
					]);
				break;
				
				case 'mail_exist':
					$result = Alerts::sweet_alert('simple',$alert = [
						'title' => 'Correo electrónico registrado',
						'text' => 'El correo electrónico ingresado ya está registrado',
						'type' => 'error'
					]);
				break;

				case 'query_fail':
					$result = Alerts::sweet_alert('simple',$alert = [
						'title' => 'A ocurrido un error inesperado',
						'text' => 'Tenemos problemas para registrar los datos, intente nuevamente',
						'type' => 'error'
					]);
				break;

				//Si se realiza la consulta
				case 'query_success':
					//Si el usuario es de tipo profesional
					if($dates['tipo_usuario'] == 2)
					{
						$tipo_prof = Security::clear_string($_POST['tipo_profesional']);

						$dates_prof = [
							'tipo_prof' => $tipo_prof
						];

						$register_prof = registerModel::add_professional_model($dates + $dates_prof);

 						switch ($register_prof) {
 							case 'query_fail':
 								$result = Alerts::sweet_alert('simple',$alert = [
									'title' => 'A ocurrido un error inesperado',
									'text' => 'Tenemos problemas para registrar los datos, intente nuevamente',
									'type' => 'error'
								]);
 							break;

 							case 'query_success':
 								$result = Alerts::sweet_alert('clear',$alert = [
									'title' => 'Registro exitoso!',
									'text' => 'El registro se a completado satisfactoriamente.',
									'type' => 'success'
								]);
 							break;
 						}
					}
					//Si el usuario es de tipo paciente
					elseif($dates['tipo_usuario'] == 3)
					{
						$tipo_pac = Security::clear_string($_POST['tipo_paciente']);
						$edad = Security::clear_string($_POST['edad']);

						switch ($tipo_pac) 
						{
							case 1: //Estudiante
								$programa = Security::clear_string($_POST['programa']); 
								$jornada = Security::clear_string($_POST['jornada']);
								$semestre = Security::clear_string($_POST['semestre']);

								$dates_pac = [
									'tipo_pac' => $tipo_pac,
									'edad' => $edad,
									'programa' => $programa,
									'jornada' => $jornada,
									'semestre' => $semestre
								];
							break;
							
							case 2: //Egresado
								$egreso = Security::clear_string($_POST['egreso']);

								$dates_pac = [
									'tipo_pac' => $tipo_pac,
									'edad' => $edad,
									'egreso' => $egreso
								];
							break;

							case 3: //Vinculado
								$vinculante = Security::clear_string($_POST['vinculante']);

								$dates_pac = [
									'tipo_pac' => $tipo_pac,
									'edad' => $edad,
									'vinculante' => $vinculante
								];
							break;

							default:
								$dates_pac = [
									'tipo_pac' => $tipo_pac,
									'edad' => $edad
								];
							break;
						}

						$register_pac = registerModel::add_patient_model($dates + $dates_pac);

						switch ($register_pac) {
 							case 'query_fail':
 								$result = Alerts::sweet_alert('simple',$alert = [
									'title' => 'A ocurrido un error inesperado',
									'text' => 'Tenemos problemas para registrar los datos, intente nuevamente',
									'type' => 'error'
								]);
 							break;

 							case 'query_success':
 								$result = Alerts::sweet_alert('clear',$alert = [
									'title' => 'Registro exitoso!',
									'text' => 'El registro se a completado satisfactoriamente.',
									'type' => 'success'
								]);
 							break;
 						}
					}
				break;
			}
			return $result;
		}

		public function select()
		{
			return registerModel::selects();
		}
	}