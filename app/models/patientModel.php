<?php
	require_once dirname(dirname(__FILE__)).'/libs/Database.php';

	class patientModel extends Database
	{
		private $db;

		public function __construct()
		{
			$this->db = new Database;
		}

		protected function consult_patients_model()
		{
			//Obtener datos de usuario y tipo de profesional
			$this->db->query("SELECT tipo_paciente.tipo_paciente, usuario.nombres, usuario.apellidos, usuario.tipo_documento, usuario.documento, usuario.telefono, usuario.mail FROM paciente  INNER JOIN usuario ON paciente.usuario = usuario.id_usuario INNER JOIN tipo_paciente ON paciente.tipo_paciente = tipo_paciente.id_tipo_paciente WHERE usuario.estado = 1");

			return $this->db->registers();
		}

		protected function consult_patient_model($dates)
		{
			$this->db->query("SELECT tipo_paciente FROM paciente INNER JOIN usuario ON usuario.id_usuario = paciente.usuario WHERE usuario.documento = :documento");
			$this->db->bind(":documento",$dates['documento']);

			if($this->db->register()->tipo_paciente == 1)
			{
				$this->db->query("SELECT tipo_paciente.tipo_paciente, usuario.nombres, usuario.apellidos, usuario.tipo_documento, usuario.documento, usuario.genero, usuario.telefono, usuario.residencia_dir, usuario.mail, usuario.genero, usuario.estado_civil, usuario.foto_usuario, paciente.id_paciente, paciente.edad, paciente.semestre, paciente.jornada, paciente.año_egreso, programa_academico.programa FROM paciente INNER JOIN usuario ON paciente.usuario = usuario.id_usuario INNER JOIN tipo_paciente ON paciente.tipo_paciente = tipo_paciente.id_tipo_paciente INNER JOIN programa_academico ON paciente.programa = programa_academico.id_programa WHERE usuario.estado = 1 AND usuario.documento = :documento");
				
			}else{
				$this->db->query("SELECT tipo_paciente.tipo_paciente, usuario.nombres, usuario.apellidos, usuario.tipo_documento, usuario.documento, usuario.genero, usuario.telefono, usuario.residencia_dir, usuario.mail, usuario.genero, usuario.estado_civil, usuario.foto_usuario, paciente.id_paciente, paciente.edad, paciente.semestre, paciente.jornada, paciente.año_egreso FROM paciente INNER JOIN usuario ON paciente.usuario = usuario.id_usuario INNER JOIN tipo_paciente ON paciente.tipo_paciente = tipo_paciente.id_tipo_paciente WHERE usuario.estado = 1 AND usuario.documento = :documento");
			}
			$this->db->bind(":documento",$dates['documento']);
			
			return $this->db->register();
		}

		protected function consult_binding_model($date)
		{
			$this->db->query("SELECT CONCAT(nombres,' ',apellidos) as vinculante, documento FROM usuario INNER JOIN paciente ON paciente.usuario = usuario.id_usuario INNER JOIN vinculacion ON vinculacion.paciente_vinculante = paciente.id_paciente WHERE vinculacion.paciente_vinculado = :vinculado");
			$this->db->bind(":vinculado", $date['vinculado']);

			return $this->db->register();
		}
	}