<?php 
	require_once dirname(dirname(__FILE__))."/libs/Database.php";
	require_once APP_URL."/libs/Security.php";

	class plannerModel extends Database
	{
		private $db;

		public function __construct()
		{
			$this->db = new Database;
		}

		protected function add_planner_model($dates)
		{
			//id del paciente
			$this->db->query("SELECT * FROM paciente INNER JOIN usuario ON paciente.usuario = usuario.id_usuario WHERE usuario.documento = :paciente");
			$this->db->bind(":paciente", $dates['paciente']);
			$id_paciente = $this->db->register();

			//Consltar si ya existe una cita agendada con los mismos datos 
			$this->db->query("SELECT * FROM agenda_cita WHERE profesional = :profesional AND fecha = :fecha AND hora = :hora AND estado = 0");
			$this->db->bind(":profesional", $dates['profesional']);
			$this->db->bind(":fecha", $dates['fecha']);
			$this->db->bind(":hora", $dates['hora']);
			$id_agenda = $this->db->register();

			if($this->db->rowCount() >= 1)
			{
				$this->db->query("UPDATE agenda_cita SET paciente = :paciente, estado = 1 WHERE id_agenda = :id");
				$this->db->bind(":paciente", $id_paciente->id_paciente);
				$this->db->bind(":id", $id_agenda->id_agenda);

				if($this->db->execute())
				{
					return 'query_success';
				}else{
					return 'query_fail';
				}
			}else{
				return 'error';
			}
		}

		protected function delete_planner_model($dates)
		{
			$i = 0;
			foreach($dates as $i => $value)
			{
				$this->db->query("DELETE FROM agenda_cita WHERE id_agenda = :id");
				$this->db->bind(":id", $value);
				$this->db->execute();
				$i++;
			}
			return true;
		}

		protected function consult_planner_model($dates)
		{
			$this->db->query("SELECT * FROM agenda_cita WHERE profesional = :profesional AND fecha = :fecha AND hora = :hora");
			$this->db->bind(":profesional", $dates['profesional']);
			$this->db->bind(":fecha", $dates['fecha']);
			$this->db->bind(":hora", $dates['hora']);

			return $this->db->register(); 
		}

		protected function selects_planner()
		{	
			//Consultar pacientes
			$this->db->query("SELECT documento, nombres, apellidos FROM usuario WHERE tipo_usuario = 3 AND estado = 1");
			$dates['patients'] = $this->db->registers();

			//Consultar profesionales
			$this->db->query("SELECT tipo_profesional.tipo_profesional, usuario.id_usuario, usuario.nombres, usuario.apellidos, profesional.id_profesional FROM profesional  INNER JOIN usuario ON profesional.usuario = usuario.id_usuario INNER JOIN tipo_profesional ON profesional.tipo_prof = tipo_profesional.id_tipo_prof WHERE usuario.estado = 1");
			$dates['professionals'] = $this->db->registers();

			return $dates;
		}

		protected function consult_horary_model($dates)
		{
			$this->db->query("SELECT id_profesional FROM profesional INNER JOIN usuario ON profesional.usuario = usuario.id_usuario WHERE usuario.id_usuario = :usuario");
			$this->db->bind(":usuario", $dates['profesional']);
			$profesional = $this->db->register();

			$this->db->query("SELECT * FROM agenda_cita WHERE estado = 0 AND profesional = :profesional ORDER BY CONCAT(fecha, ' ', hora) ASC");
			$this->db->bind(":profesional", $profesional->id_profesional);

			return $this->db->registers();
		}
	}