<?php
	require_once dirname(dirname(__FILE__))."/libs/Database.php";
	require_once APP_URL."/libs/Security.php";
	
	class registerModel extends Database
	{
		private $db;
		private $error;
		private $vin = true;

		public function __construct()
		{
			//Instanciar clase de la BD
			$this->db = new Database;
		}

		//Metodo para introducir datos a la tabla usuario
		protected function add_user_model($dates)
		{
			//Consultar si el usuario a registrar ya existe en la BD
			$this->db->query("SELECT * FROM usuario WHERE documento = :documento");
			$this->db->bind(":documento", $dates['documento']);
			
			if($this->db->rowCount() >= 1)
			{
				$error = 'user_exist';
				return $error;
			}else{
				//Consultar si el mail ya existe en la BD
				$this->db->query("SELECT * FROM usuario WHERE mail = :mail");
				$this->db->bind(":mail", $dates['mail']);

				if($this->db->rowCount() >= 1)
				{
					$error = 'mail_exist';
					return $error;
				}else{
					//Insertar valores del formulario en la tabla usuario
					$this->db->query("INSERT INTO usuario(nombres, apellidos, tipo_documento, documento, residencia_dir, telefono, mail, genero, estado_civil, tipo_usuario, foto_usuario, contraseña) VALUES(:nombres, :apellidos, :tipo_documento, :documento, :direccion, :telefono, :mail, :genero, :estado_civil, :tipo_usuario, :foto, :clave)");

					//Encriptar contraseña
					$contraseña = Security::encryption($dates['documento']);

					$this->db->bind(":nombres", $dates['nombres']);
					$this->db->bind(":apellidos", $dates['apellidos']);
					$this->db->bind(":tipo_documento", $dates['tipo_doc']);
					$this->db->bind(":documento", $dates['documento']);
					$this->db->bind(":direccion", $dates['direccion']);
					$this->db->bind(":telefono", $dates['telefono']);
					$this->db->bind(":mail", $dates['mail']);
					$this->db->bind(":genero", $dates['genero']);
					$this->db->bind(":estado_civil", $dates['estado_civil']);
					$this->db->bind(":tipo_usuario", $dates['tipo_usuario']);
					$this->db->bind(":foto", $dates['foto']);
					$this->db->bind(":clave", $contraseña);

					if($this->db->execute())
					{
						return 'query_success';
					}else{
						return 'query_fail';
					}
				}
			}
		}

		//Metodo para introducir datos a la tabla profesional
		protected function add_professional_model($dates)
		{
			//Consultar id del usuario
			$this->db->query("SELECT id_usuario FROM usuario WHERE documento = :documento");
			$this->db->bind(":documento", $dates['documento']);
			$id_usuario = $this->db->register();

			$this->db->query("INSERT INTO profesional(usuario, tipo_prof) VALUES(:usuario, :tipo)");
			$this->db->bind(":usuario", $id_usuario->id_usuario);
			$this->db->bind(":tipo", $dates['tipo_prof']);

			if($this->db->execute())
			{
				return 'query_success';
			}else{
				$this->db->query("DELETE FROM usuario WHERE id_usuario = :user_id");
				$this->db->bind(":user_id", $id_usuario->id_usuario);
				return 'query_fail';
			}
		}

		//Metodo para introducir datos a la tabla paciente
		protected function add_patient_model($dates)
		{
			$vin = true;
			//Consultar id del usuario
			$this->db->query("SELECT id_usuario FROM usuario WHERE documento = :documento");
			$this->db->bind(":documento", $dates['documento']);
			$id_usuario = $this->db->register();

			//Insertar datos según el tipo de pacientes
			switch($dates['tipo_pac']) 
			{
				case 1: //Estudiante
					$this->db->query("INSERT INTO paciente(usuario,tipo_paciente,edad,semestre, jornada, programa) VALUES(:usuario,:tipo,:edad,:semestre,:jornada,:programa)");
					$this->db->bind(":usuario", $id_usuario->id_usuario);
					$this->db->bind(":tipo", $dates['tipo_pac']);
					$this->db->bind(":edad", $dates['edad']);
					$this->db->bind(":semestre", $dates['semestre']);
					$this->db->bind(":jornada", $dates['jornada']);
					$this->db->bind(":programa", $dates['programa']);
				break;

				case 2: //Egresado
					$this->db->query("INSERT INTO paciente(usuario,tipo_paciente,edad,año_egreso) VALUES(:usuario,:tipo,:edad,:egreso)");
					$this->db->bind(":usuario", $id_usuario->id_usuario);
					$this->db->bind(":tipo", $dates['tipo_pac']);
					$this->db->bind(":edad", $dates['edad']);
					$this->db->bind(":egreso", $dates['egreso']);
				break;

				case 3: //Vinculado
					//Insertar datos de paciente
					$this->db->query("INSERT INTO paciente(usuario,tipo_paciente,edad) VALUES(:usuario,:tipo,:edad)");
					$this->db->bind(":usuario", $id_usuario->id_usuario);
					$this->db->bind(":tipo", $dates['tipo_pac']);
					$this->db->bind(":edad", $dates['edad']);

					//insertar datos en la tabla vinculado
					if($this->db->execute())
					{
						//Obtener id de paciente recien insertado
						$this->db->query("SELECT id_paciente FROM paciente WHERE usuario = :usuario");
						$this->db->bind(":usuario", $id_usuario->id_usuario);
						$paciente = $this->db->register();

						//Obtener id de usuario vinculante
						$this->db->query("SELECT id_usuario FROM usuario WHERE documento = :documento");
						$this->db->bind(":documento", $dates['vinculante']);
						$usuario_id = $this->db->register();

						//Obtener id de paciente vinculante
						$this->db->query("SELECT id_paciente FROM paciente WHERE usuario = :user");
						$this->db->bind(":user", $usuario_id->id_usuario);
						$vinculante = $this->db->register();

						//Insertar datos de vinculacion
						$this->db->query("INSERT INTO vinculacion(paciente_vinculante, paciente_vinculado) VALUES(:vinculante, :vinculado)");
						$this->db->bind(":vinculante", $vinculante->id_paciente); 
						$this->db->bind(":vinculado", $paciente->id_paciente);

						$vin = true;
					}else{
						$this->db->query("DELETE FROM paciente WHERE id_paciente = :pac_id");
						$this->db->bind(":pac_id", $paciente->id_paciente);

						$vin = false;
						return 'query_fail';
					}
				break;

				default:
					$this->db->query("INSERT INTO paciente(usuario,tipo_paciente,edad) VALUES(:usuario,:tipo,:edad)");
					$this->db->bind(":usuario", $id_usuario->id_usuario);
					$this->db->bind(":tipo", $dates['tipo_pac']);
					$this->db->bind(":edad", $dates['edad']);
				break;
			}

			if($this->db->execute() && $vin == true)
			{
				return 'query_success';
			}else{
				$this->db->query("DELETE FROM usuario WHERE id_usuario = :user_id");
				$this->db->bind(":user_id", $id_usuario->id_usuario);
				return 'query_fail';
			}
		}

		//Consultar datos para llenar selects del formulario 
		protected function selects()
		{
			$this->db->query('SELECT id_tipo_usuario, tipo_usuario FROM tipo_usuario WHERE id_tipo_usuario <> 1');
			$dates['tipo_user'] = $this->db->registers();

			$this->db->query('SELECT id_tipo_paciente, tipo_paciente FROM tipo_paciente');
			$dates['tipo_pac'] = $this->db->registers();

			$this->db->query('SELECT id_tipo_prof, tipo_profesional FROM tipo_profesional');
			$dates['tipo_prof'] = $this->db->registers();

			$this->db->query('SELECT id_programa, programa FROM programa_academico');
			$dates['programa'] = $this->db->registers();

			$this->db->query('SELECT documento, nombres, apellidos FROM usuario WHERE tipo_usuario = 3');
			$dates['usuario'] = $this->db->registers();

			return $dates;
		}
	}