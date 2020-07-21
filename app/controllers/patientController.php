<?php 
	require_once dirname(dirname(__FILE__))."/models/patientModel.php";

	class patientController extends patientModel
	{
		public function __construct()
		{
			$this->pm = new patientModel;
		}

		public function consult_patients_controller()
		{
			return $this->pm->consult_patients_model();
		}

		public function consult_patient_controller()
		{
			$dates = [
				'documento' => $_SESSION['documento']
			];

			return $this->pm->consult_patient_model($dates);
		}

		public function consult_binding_controller()
		{
			$dates = [
				'documento' => $_SESSION['documento']
			];
			$paciente = $this->pm->consult_patient_model($dates);

			$vinc = [
				'vinculado' => $paciente->id_paciente
			];
			
			return $this->pm->consult_binding_model($vinc);
		}
	}