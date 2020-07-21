<?php 
	require_once dirname(dirname(__FILE__))."/models/plannerModel.php";
	require_once APP_URL."/models/professionalModel.php";
	require_once APP_URL."/libs/Security.php";
	require_once APP_URL."/libs/Alerts.php";

	class plannerController extends plannerModel
	{
		public function __construct()
		{
			$this->pm = new plannerModel;
		}

		public function add_planner_controller()
		{
			$paciente = Security::clear_string($_POST['paciente']);
			$fecha_hora = Security::clear_string($_POST['fecha_hora']);
			
			$fecha_hora = explode(" ", $fecha_hora);

			$dates = [
				'paciente' => $paciente,
				'fecha' => $fecha_hora[0],
				'hora' =>  $fecha_hora[1],
				'profesional' => $fecha_hora[2]
			];

			$add_planner = $this->pm->add_planner_model($dates);

			switch ($add_planner) {
				case 'query_success':
					$result = Alerts::sweet_alert('reload',$alert = [
						'title' => 'Registro exitoso!',
						'text' => 'Se ha agendado la cita satisfactoriamente.',
						'type' => 'success'
					]);
				break;
				
				case 'query_fail':
					$result = Alerts::sweet_alert('simple',$alert = [
						'title' => 'A ocurrido un error inesperado',
						'text' => 'Tenemos problemas para registrar los datos, intente nuevamente',
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
			return $result;
		}

		public function delete_planner_controller()
		{
			$dates = $_POST['agenda'];

			if($this->pm->delete_planner_model($dates))
			{
				$result = Alerts::sweet_alert('reload',$alert = [
					'title' => 'Datos eliminados!',
					'text' => 'Los registros se han eliminado satisfactoriamente.',
					'type' => 'success'
				]);
			}
			return $result;
		}

		public function horary_controller($id)
		{
			$dates = [
				'profesional' => $id
			];

			return $this->pm->consult_horary_model($dates);
		}

		public function selects_planner()
		{
			return $this->pm->selects_planner();
		}
	}