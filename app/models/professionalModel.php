<?php
	require_once dirname(dirname(__FILE__)).'/libs/Database.php';
	require_once APP_URL."/libs/Alerts.php";

	class professionalModel extends Database
	{
		private $db;

		public function __construct()
		{
			$this->db = new Database;
		}

		protected function consult_professionals_model()
		{
			//Obtener datos de usuario y tipo de profesional
			$this->db->query("SELECT tipo_profesional.tipo_profesional, usuario.nombres, usuario.apellidos, usuario.tipo_documento, usuario.documento, usuario.telefono, usuario.mail FROM profesional INNER JOIN usuario ON profesional.usuario = usuario.id_usuario INNER JOIN tipo_profesional ON profesional.tipo_prof = tipo_profesional.id_tipo_prof WHERE usuario.estado = 1");

			return $this->db->registers();
		}

		protected function consult_professional_model($date)
		{
			//Obtener datos de usuario y profesional
			$this->db->query("SELECT tipo_profesional.tipo_profesional, usuario.id_usuario, usuario.nombres, usuario.apellidos, usuario.tipo_documento, usuario.documento, usuario.genero,usuario.telefono, usuario.mail, profesional.id_profesional, profesional.experiencia FROM profesional INNER JOIN usuario ON profesional.usuario = usuario.id_usuario INNER JOIN tipo_profesional ON profesional.tipo_prof = tipo_profesional.id_tipo_prof WHERE usuario.estado = 1 AND usuario.documento = :documento");
			$this->db->bind(":documento",$date['documento']);

			return $this->db->register();
		}

		protected function register_horary_model($dates)
		{
			//Consultar el id del profesional
			$this->db->query("SELECT profesional.id_profesional FROM profesional INNER JOIN usuario on profesional.usuario = usuario.id_usuario WHERE usuario.documento = :documento");
			$this->db->bind(":documento",$dates['documento']);
			$id_profesional = $this->db->register();

			//Consultar si existe un registro identico
			$this->db->query("SELECT * FROM horario_disp WHERE fecha = :fecha AND hora_inicio = :hora_inicio AND hora_fin = :hora_fin AND profesional = :profesional");
			$this->db->bind(":fecha", $dates['fecha']);
			$this->db->bind(":hora_inicio", $dates['hora_inicio']);
			$this->db->bind(":hora_fin", $dates['hora_fin']);
			$this->db->bind(":profesional", $id_profesional->id_profesional);

			if($this->db->rowCount() == 0)
			{
				$this->db->query("SELECT * FROM horario_disp WHERE fecha = :fecha AND profesional = :profesional");
				$this->db->bind(":fecha", $dates['fecha']);
				$this->db->bind(":profesional", $id_profesional->id_profesional);
				$reg = $this->db->registers();

				$cont = 0;

				foreach ($reg as $value) 
				{
					$ini = date_create($value->hora_inicio);
					$fin = date_create($value->hora_fin);
					$nw = date_create($dates['hora_inicio']);

					$ini = strtotime(date_format($ini, 'H:i:s'));
					$fin = strtotime(date_format($fin, 'H:i:s'));
					$nw = strtotime(date_format($nw, 'H:i:s'));
					
					if($nw >= $ini && $nw <= $fin) 
					{
						$cont++;
					}
				}

				if($cont == 0)
				{
					//Insertar datos en la tabla horario_disp
					$this->db->query("INSERT INTO horario_disp(fecha, hora_inicio, hora_fin, profesional) VALUES(:fecha, :hora_inicio, :hora_fin, :profesional)");
					$this->db->bind(":fecha", $dates['fecha']);
					$this->db->bind(":hora_inicio", $dates['hora_inicio']);
					$this->db->bind(":hora_fin", $dates['hora_fin']);
					$this->db->bind(":profesional", $id_profesional->id_profesional);

					if($this->db->execute())
					{
						$this->db->query("SELECT * FROM horario_disp WHERE fecha = :fecha AND hora_inicio = :hora_inicio AND hora_fin = :hora_fin AND profesional = :profesional");
						$this->db->bind(":fecha", $dates['fecha']);
						$this->db->bind(":hora_inicio", $dates['hora_inicio']);
						$this->db->bind(":hora_fin", $dates['hora_fin']);
						$this->db->bind(":profesional", $id_profesional->id_profesional);
						$horario = $this->db->register();

						if($this->db->execute())
						{
							$dates = [
								'profesional' => $id_profesional->id_profesional,
								'horario' => $horario->id_horario
							];
							return $dates;
						}
						else{
							$this->db->query("DELETE FROM horario_disp WHERE fecha = :fecha AND hora_inicio = :hora_inicio AND hora_fin = :hora_fin AND profesional = :profesional");
							$this->db->bind(":fecha", $dates['fecha']);
							$this->db->bind(":hora_inicio", $dates['hora_inicio']);
							$this->db->bind(":hora_fin", $dates['hora_fin']);
							$this->db->bind(":profesional", $id_profesional->id_profesional);
							$this->db->execute();

							return 'error';
						}
					}else{
						return 'error';
					}
				}else{
					return 'invalid';
				}
			}else{
				return 'exist';
			}
		}

		protected function consult_horary_model($date)
		{
			$this->db->query("SELECT * FROM horario_disp WHERE profesional = :profesional ORDER BY fecha ASC");
			$this->db->bind(":profesional",$date['id_profesional']);

			return $this->db->registers();
		}

		protected function delete_horary_model($dates)
		{
			$i = 0;

			foreach($dates as $i => $value) 
			{
				$this->db->query("SELECT * from agenda_cita WHERE disp_id = :id");
				$this->db->bind(":id",$value);
				$agenda = $this->db->registers();

				$cont = 0;

				foreach($agenda as $valor) 
				{
					if($valor->estado != 0)
					{
						$cont++;
					}
				}

				if($cont == 0)
				{
					$this->db->query("DELETE FROM horario_disp WHERE id_horario = :id");
					$this->db->bind(":id",$value);
					$this->db->execute();

					$i++;
				}
			}
			return true;
		}

		Protected function calc_horary_model($dates)
		{
			$this->db->query("SELECT * FROM horario_disp WHERE profesional = :profesional");
			$this->db->bind(":profesional", $dates['profesional']);

			return $this->db->registers();
		}

		protected function add_horary($dates)
		{
			foreach ($dates as $datos) 
			{
				$this->db->query("SELECT * FROM agenda_cita WHERE profesional = :profesional AND fecha = :fecha AND hora = :hora");
				$this->db->bind(":fecha", $datos['fecha']);
				$this->db->bind(":hora", $datos['hora']);
				$this->db->bind(":profesional", $datos['profesional']);

				if($this->db->rowCount() == 0)
				{
					$this->db->query("INSERT INTO agenda_cita(profesional, fecha, hora, disp_id) VALUES(:profesional, :fecha, :hora, :disp)");
					$this->db->bind(":fecha", $datos['fecha']);
					$this->db->bind(":hora", $datos['hora']);
					$this->db->bind(":profesional", $datos['profesional']);
					$this->db->bind(":disp", $datos['horario']);
					$this->db->execute();
				}
			}
			return true;
		}
	}