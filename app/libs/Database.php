<?php
	/*if($requestAjax)
	{
		require_once APP_URL."/config/config.php";
	}else{
		require_once "./app/config/config.php";
	}*/

	require_once dirname(dirname(__FILE__))."/config/config.php";

	class Database
	{
		private $host = HOST;
		private $user = USER;
		private $pss = PASS;
		private $name = DB;

		private $dbh;
		private $stmt;
		private $error;

		private $db;

		public function __construct()
		{
			//Configurar conexión
			$dsn = 'mysql:host='.$this->host.';dbname='.$this->name;
			$options = array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			);

			//Instanciar PDO
			try{
				$this->dbh = new PDO($dsn, $this->user, $this->pss, $options);
				$this->dbh->exec('set names utf8');
			} catch(PDOException $e){
				$this->error = $e->getMessage();
				echo $this->error;
			}
		}

		//Configurar consulta
		public function query($sql)
		{
			$this->stmt = $this->dbh->prepare($sql);
		}

		//Vincular consulta con bind
		public function bind($param, $value, $type = null)
		{
			if(is_null($type))
			{
				switch (true) {
					case is_int($value):
						$type = PDO::PARAM_INT;
					break;

					case is_bool($value):
						$type = PDO::PARAM_BOOL;
					break;

					case is_string($value):
						$type = PDO::PARAM_STR;
					break;
					
					default:
						$type = PDO::PARAM_NULL;
					break;
				}
			}

			$this->stmt->bindValue($param, $value, $type);
		}

		//Ejecutar consulta
		public function execute()
		{
			return $this->stmt->execute();
		}

		//Obtener registros
		public function registers()
		{
			$this->execute();
			return $this->stmt->fetchAll(PDO::FETCH_OBJ);
		}

		//Obtener un solo registro
		public function register()
		{
			$this->execute();
			return $this->stmt->fetch(PDO::FETCH_OBJ);
		}

		//Obtener cantidad de registro
		public function rowCount()
		{
			$this->execute();
			return $this->stmt->rowCount();
		}
	}