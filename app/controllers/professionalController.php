<?php 
	require_once dirname(dirname(__FILE__))."/models/professionalModel.php";
	require_once APP_URL."/libs/Security.php";
	require_once APP_URL."/libs/Alerts.php";

	class professionalController extends professionalModel
	{
		public function __construct()
		{
			$this->pm = new professionalModel;
		}

		public function consult_professionals_controller()
		{
			return $this->pm->consult_professionals_model();
		}

		public function consult_professional_controller($date)
		{
			$dates = [
				'documento' => $date
			];

			return $this->pm->consult_professional_model($dates);
		}

		public function register_horary_controller()
		{
			session_start(['SISCO']);
			
			$fecha = Security::clear_string($_POST['fecha']);
			$hora_inicio = Security::clear_string($_POST['hora_inicio']);
			$hora_fin = Security::clear_string($_POST['hora_fin']);

			$dates = [
				'fecha' => $fecha,
				'hora_inicio' => $hora_inicio,
				'hora_fin' => $hora_fin,
				'documento' => $_SESSION['documento']
			];

			$register_horary = $this->pm->register_horary_model($dates);
			//------------------------------------------------------
			if(is_array($register_horary))
			{
				//Calcular horarios
				$dates = [
					'profesional' => $register_horary['profesional']
				];

				$calc = $this->pm->calc_horary_model($dates);

				$citas = [];

				foreach ($calc as $dt) 
				{
					$hora_inicio = new DateTime($dt->hora_inicio);
					$min_inicio = (int)$hora_inicio->format('i');
					$hora_inicio = (int)$hora_inicio->format('H');
					$tiempo_inicio = $min_inicio + ($hora_inicio * 60);

					$hora_fin = new DateTime($dt->hora_fin);
					$min_fin = (int)$hora_fin->format('i');
					$hora_fin = (int)$hora_fin->format('H');
					$tiempo_fin = $min_fin + ($hora_fin * 60);

					$tiempo_total = $tiempo_fin - $tiempo_inicio;
					$cant = round(($tiempo_total/45),0);

					$b = true;
					$cont = 0;

					while($cont < $cant)
					{
						if($b == true)
						{
							$hora = new DateTime($dt->hora_inicio);

							array_push($citas, array(
								'fecha' => $dt->fecha,
								'hora' => $hora->format('H:i:s'),
								'profesional' => $dt->profesional,
								'horario' => $register_horary['horario']
							));
							$cant--;
							$b = false;
						}else{
							$hora = new DateTime($hora->format('H:i:s'));
							$hora->modify('+45 minute');
							array_push($citas, array(
								'fecha' => $dt->fecha,
								'hora' => $hora->format('H:i:s'),
								'profesional' => $dt->profesional,
								'horario' => $register_horary['horario']
							));
							$cont++;
						}
					}
				}

				$add_planner = $this->pm->add_horary($citas);
				
				switch ($add_planner) 
				{
					case true:
						$result = Alerts::sweet_alert('reload',$alert = [
							'title' => 'Registro exitoso!',
							'text' => 'El registro se a completado satisfactoriamente.',
							'type' => 'success'
						]);
					break;

					case false:
						$result = Alerts::sweet_alert('simple',$alert = [
							'title' => 'A ocurrido un error inesperado',
							'text' => 'Tenemos problemas para registrar los datos, intente nuevamente',
							'type' => 'error'
						]);
					break;
				}
			}else{
				switch($register_horary) 
				{
					case 'exist':
						$result = Alerts::sweet_alert('simple',$alert = [
							'title' => 'A ocurrido un error inesperado',
							'text' => 'Este horario ya se encuentra registrado',
							'type' => 'error'
						]);
					break;

					case 'invalid':
						$result = Alerts::sweet_alert('simple',$alert = [
							'title' => 'A ocurrido un error inesperado',
							'text' => 'El nuevo horario no se debe cruzar con uno ya registrado',
							'type' => 'error'
						]);
					break;

					case 'error':
						$result = Alerts::sweet_alert('simple',$alert = [
							'title' => 'A ocurrido un error inesperado',
							'text' => 'Tenemos problemas para registrar los datos, intente nuevamente',
							'type' => 'error'
						]);
					break;
				}
			}
			//------------------------------------------------------
			return $result;	
		}

		public function consult_horary_controller()
		{
			$date = ['documento' => $_SESSION['documento']];
			$ins = $this->pm->consult_professional_model($date);
			$id_profesional = $ins->id_profesional;

			$date = [
				'id_profesional' => $id_profesional
			];

			return $ins = $this->pm->consult_horary_model($date);
		}

		public function delete_horary_controller()
		{
			$dates = $_POST['horario'];

			if($this->pm->delete_horary_model($dates))
			{
				$result = Alerts::sweet_alert('reload',$alert = [
					'title' => 'Verifique!',
					'text' => 'En caso de no haber borrado uno o varios de los horarios seleccionados, significa que existe una cita agendada correspondiente a ese horario.',
					'type' => 'info'
				]);
			}
			return $result;
		}
	}