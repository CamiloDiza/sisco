<?php
	require_once dirname(dirname(__FILE__))."/libs/Database.php";
	require_once APP_URL."/libs/Security.php";

	class logModel extends Database
	{
		private $db;
		private $result;

		public function __construct()
		{
			//Intanciar clase de la BD
			$this->db = new Database;
		}

		protected function login_model($dates)
		{
			//Consultar si existe el documento ingresado
			$this->db->query("SELECT * FROM usuario WHERE documento = :documento");
			$this->db->bind(":documento",$dates['documento']);

			$user = $this->db->register();
			
			//Si la consulta obtuvo un resultado
			if($this->db->rowCount() == 1)
			{
				//Consultar si la contraseña corresponde al usuario ingresado
				if($user->contraseña == $dates['clave'])
				{
					//Consultar si el usuario está activo
					if($user->estado == 1)
					{
						$result = $user;
					}else{
						$result = 'inactive';
					}
				}else{
					$result = 'no_pss';
				}
			}else{
				$result = 'no_document';
			}
			return $result;
		}
	}