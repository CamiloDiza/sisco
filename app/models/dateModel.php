<?php
	require_once dirname(dirname(__FILE__)).'/libs/Database.php';

	class dateModel extends Database
	{
		private $db;

		public function __construct()
		{
			$this->db = new Database();
		}

		protected function consult_dates_model()
		{
			$this->db->query("SELECT agenda_cita.id_agenda, agenda_cita.paciente, CONCAT(usuario.nombres,' ',usuario.apellidos) AS usuario, usuario.tipo_documento, usuario.documento, CONCAT(agenda_cita.fecha,' ',agenda_cita.hora) AS fecha_hora FROM agenda_cita INNER JOIN paciente ON agenda_cita.paciente = paciente.id_paciente INNER JOIN usuario ON paciente.usuario = usuario.id_usuario WHERE agenda_cita.estado = 1 ORDER BY CONCAT(agenda_cita.fecha,' ',agenda_cita.hora) ASC");

			if($this->db->rowCount() >= 1)
			{
				return $this->db->registers();
			}else{
				return 'empty'; 
			}
		}

		protected function consult_dates0_model($dates)
		{
			$this->db->query("SELECT profesional.id_profesional FROM profesional INNER JOIN usuario ON profesional.usuario = usuario.id_usuario WHERE usuario.documento = :documento");
			$this->db->bind(":documento", $dates['profesional']);
			$profesional = $this->db->register();

			$this->db->query("SELECT * FROM agenda_cita WHERE profesional = :profesional AND estado = 0 ORDER BY CONCAT(fecha,' ',hora) ASC");
			$this->db->bind(":profesional", $profesional->id_profesional);

			return $this->db->registers();
		}

		protected function consult_dates1_model($dates)
		{
			$this->db->query("SELECT paciente.id_paciente FROM paciente INNER JOIN usuario ON paciente.usuario = usuario.id_usuario WHERE usuario.documento = :documento");
			$this->db->bind(":documento", $dates['paciente']);
			$paciente = $this->db->register();

			$this->db->query("SELECT * FROM agenda_cita WHERE paciente = :paciente AND estado = 1 ORDER BY CONCAT(fecha,' ',hora) ASC");
			$this->db->bind(":paciente", $paciente->id_paciente);

			return $this->db->registers();
		}

		protected function ast_model($dates)
		{
			$this->db->query("SELECT * FROM agenda_cita WHERE id_agenda = :agenda");
			$this->db->bind(":agenda",$dates['cita']);

			if($this->db->rowCount() >= 1)
			{
				$agenda = $this->db->register();

				$this->db->query("SELECT tipo_paciente FROM paciente INNER JOIN usuario ON usuario.id_usuario = paciente.usuario WHERE usuario.documento = :documento");
				$this->db->bind(":documento",$dates['paciente']);

				if($this->db->rowCount() >= 1)
				{
					if($this->db->register()->tipo_paciente == 1)
					{
						$this->db->query("SELECT tipo_paciente.tipo_paciente, usuario.nombres, usuario.apellidos, usuario.tipo_documento, usuario.documento, usuario.genero, usuario.telefono, usuario.residencia_dir, usuario.mail, usuario.genero, usuario.estado_civil, usuario.foto_usuario, paciente.id_paciente, paciente.edad, paciente.semestre, paciente.jornada, paciente.año_egreso, programa_academico.programa FROM paciente INNER JOIN usuario ON paciente.usuario = usuario.id_usuario INNER JOIN tipo_paciente ON paciente.tipo_paciente = tipo_paciente.id_tipo_paciente INNER JOIN programa_academico ON paciente.programa = programa_academico.id_programa WHERE usuario.estado = 1 AND usuario.documento = :documento");
						
					}else{
						$this->db->query("SELECT tipo_paciente.tipo_paciente, usuario.nombres, usuario.apellidos, usuario.tipo_documento, usuario.documento, usuario.genero, usuario.telefono, usuario.residencia_dir, usuario.mail, usuario.genero, usuario.estado_civil, usuario.foto_usuario, paciente.id_paciente, paciente.edad, paciente.semestre, paciente.jornada, paciente.año_egreso FROM paciente INNER JOIN usuario ON paciente.usuario = usuario.id_usuario INNER JOIN tipo_paciente ON paciente.tipo_paciente = tipo_paciente.id_tipo_paciente WHERE usuario.estado = 1 AND usuario.documento = :documento");
					}
					$this->db->bind(":documento",$dates['paciente']);
					$paciente = $this->db->register();

					if($agenda->paciente == $paciente->id_paciente)
					{
						return $paciente;
					}else{
						return 'no_exist';
					} 
				}else{
					return 'no_exist';
				}
			}else{
				return 'no_exist';
			}
		}

		protected function add_date_model($dates)
		{	
			//Insertar datos en la tabla cita
			$this->db->query("INSERT INTO cita(agenda, asistio, motivo, observaciones, diagnostico, tratamiento, remision, proxima_cita) VALUES(:agenda, :asistio, :motivo, :observaciones, :diagnostico, :tratamiento, :remision, :proxima_cita)");
			$this->db->bind(":agenda", $dates['cita']);
			$this->db->bind(":asistio", $dates['asistencia']);
			$this->db->bind(":motivo", $dates['motivo']);
			$this->db->bind(":observaciones", $dates['obs']);
			$this->db->bind(":diagnostico", $dates['diag']);
			$this->db->bind(":tratamiento", $dates['trmento']);
			$this->db->bind(":remision", $dates['remision']);
			$this->db->bind(":proxima_cita", $dates['prox_cita']);

			if($this->db->execute())
			{
				//Actualizar estado en la tabla agenda cita
				$this->db->query("UPDATE agenda_cita SET estado = 2 WHERE id_agenda = :agenda");
				$this->db->bind(":agenda", $dates['cita']);
				$this->db->execute();

				//Insertar datos en la tabla responsable sí lo hay
				if(!empty($dates['responsable']) && !empty($dates['tel']))
				{
					$this->db->query("INSERT INTO responsable(nombre_completo, telefono, email) VALUES(:nombre, :tel, :mail)");
					$this->db->bind(":nombre", $dates['responsable']);
					$this->db->bind(":tel", $dates['tel']);
					$this->db->bind(":mail", $dates['mail']);
					$this->db->execute();

					//Consultar id del responsable recien insertado
					$this->db->query("SELECT id_responsable FROM responsable WHERE nombre_completo = :nombre AND telefono = :tel AND email = :mail");
					$this->db->bind(":nombre", $dates['responsable']);
					$this->db->bind(":tel", $dates['tel']);
					$this->db->bind(":mail", $dates['mail']);

					//Actualizar responsable en la tabla paciente
					if($this->db->execute())
					{
						$res = $this->db->register();

						$this->db->query("SELECT id_paciente FROM paciente INNER JOIN usuario ON paciente.usuario = usuario.id_usuario WHERE usuario.documento = :documento");
						$this->db->bind(":documento", $dates['paciente']);
						$paciente = $this->db->register(); 

						$this->db->query("UPDATE paciente SET responsable = :responsable WHERE id_paciente = :paciente");
						$this->db->bind(":responsable", $res->id_responsable);
						$this->db->bind(":paciente", $paciente->id_paciente);
					}
				}
				//Insertar nueva agenda_cita sí la hay
				if($dates['fecha'] != '' && $dates['hora'] != '')
				{
					//Consltar si ya existe una cita agendada con los mismos datos
					$this->db->query("SELECT * FROM agenda_cita WHERE profesional = :profesional AND fecha = :fecha AND hora = :hora AND estado = 0");
					$this->db->bind(":profesional", $dates['profesional']);
					$this->db->bind(":fecha", $dates['fecha']);
					$this->db->bind(":hora", $dates['hora']);

					if($this->db->rowCount() >= 1)
					{
						$id_agenda = $this->db->register();
						
						$this->db->query("SELECT id_paciente FROM paciente INNER JOIN usuario ON paciente.usuario = usuario.id_usuario WHERE usuario.documento = :documento");
						$this->db->bind(":documento", $dates['paciente']);
						$paciente = $this->db->register();

						$this->db->query("UPDATE agenda_cita SET paciente = :paciente, estado = 1 WHERE id_agenda = :id");
						$this->db->bind(":paciente", $paciente->id_paciente);
						$this->db->bind(":id", $id_agenda->id_agenda);

						if($this->db->execute())
						{
							$result = 'query_success';
						}
					}
				}else{
					$result = 'query_success';
				}
			}else{
				$result = 'fail';
			}
			return $result;
		}
	}