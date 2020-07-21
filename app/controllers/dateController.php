<?php 
	require_once dirname(dirname(__FILE__))."/models/dateModel.php";
	require_once APP_URL."/libs/Security.php";
	require_once APP_URL."/libs/Alerts.php";

	class dateController extends dateModel
	{
		public function __construct()
		{
			$this->dm = new dateModel; 
		}

		public function consult_dates_controller()
		{
			if(is_array($this->dm->consult_dates_model()))
			{
				return $this->dm->consult_dates_model();
			}else{
				return $arr = [];
			}
		}

		public function consult_dates0_controller($documento)
		{
			$dates = [
				'profesional' => $documento
			];

			return $this->dm->consult_dates0_model($dates);
		}

		public function consult_dates1_controller()
		{
			$dates = [
				'paciente' => $_SESSION['documento']
			];

			return $this->dm->consult_dates1_model($dates);
		}

		public function ast_controller($dates)
		{
			if($this->dm->ast_model($dates) == 'no_exist')
			{
				$result = 'no_exist';
			}else{
				$result = $this->dm->ast_model($dates);
			}
			return $result;
		}

		public function add_date_controller()
		{
			$asistencia = Security::clear_string($_POST['asistencia']);
			$motivo = Security::clear_string($_POST['motivo']);
			$obs = Security::clear_string($_POST['obs']);
			$diag = Security::clear_string($_POST['diag']);
			$trmento = Security::clear_string($_POST['trmento']);
			$remision = Security::clear_string($_POST['remision']);
			$paciente = Security::clear_string($_POST['paciente']);
			$profesional = Security::clear_string($_POST['profesional']);
			$cita = Security::clear_string($_POST['cita']);
			$res = Security::clear_string($_POST['res']);
			$tel_res = Security::clear_string($_POST['tel_res']);
			$mail_res = Security::clear_string($_POST['mail_res']);

			if(isset($_POST['prox']) && !empty($_POST['prox']))
			{
				$prox = Security::clear_string($_POST['prox']);
				$proxima = explode(" ", $prox);
			}else{
				$prox = '';
				$proxima = ['',''];
				$fecha = '';
				$hora = ''; 
			}
			
			$dates = [
				'asistencia' => $asistencia,
				'motivo' => $motivo,
				'obs' => $obs,
				'diag' => $diag,
				'trmento' => $trmento,
				'remision' => $remision,
				'prox_cita' => $prox,
				'fecha' => $proxima[0],
				'hora' =>  $proxima[1],
				'paciente' => $paciente,
				'profesional' => $profesional,
				'cita' => $cita,
				'responsable' => $res,
				'tel' => $tel_res,
				'mail' => $mail_res
			];

			$add = $this->dm->add_date_model($dates);

			switch ($add) 
			{
				case 'query_success':
					$result = Alerts::sweet_alert('close',$alert = [
						'title' => 'Datos guardados!',
						'text' => 'Esta ventana va a cerrarse.',
						'type' => 'success'
					]);
				break;

				case 'fail':
					$result = Alerts::sweet_alert('reload',$alert = [
						'title' => 'Datos guardados!',
						'text' => 'Esta ventana va a cerrarse.',
						'type' => 'error'
					]);
				break;
			}
			return $result;
		}
	}