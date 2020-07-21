<?php
	require_once dirname(dirname(__FILE__))."/models/logModel.php";
	require_once APP_URL."/libs/Security.php";
	require_once APP_URL."/libs/Alerts.php";

	class logController extends logModel
	{
		public function __construct()
		{
			//Instanciar clases
			$this->mdl = new logModel;
			$this->st = new Security;
		}

		//Método para iniciar sesión
		public function login_controller()
		{
			//Limpiar cadenas
			$documento = $this->st->clear_string($_POST['loginUser']);
			$clave = $this->st->clear_string($_POST['loginPassword']);

			//Encriptar contraseña
			$clave = $this->st->encryption($_POST['loginPassword']);

			$dates = [
				'documento' => $documento,
				'clave' => $clave
			];

			//Enviar datos al modelo
			$userDates = $this->mdl->login_model($dates);

			//Mostrar alerta según resultado de la base de datos
			switch($userDates) 
			{
				case 'no_document':
					$result = Alerts::sweet_alert('simple', $alert=[
							'title' => 'Información incorrecta',
							'text' => 'El número de documento ingresado no es correcto',
							'type' => 'error'
						]);
				break;

				case 'no_pss':
					$result = Alerts::sweet_alert('simple', $alert=[
							'title' => 'Información incorrecta',
							'text' => 'La contraseña ingresado no es correcta',
							'type' => 'error'
						]);
				break;

				case 'inactive':
					$result = Alerts::sweet_alert('simple', $alert=[
							'title' => 'Usuario inactivo',
							'text' => 'La cuenta a la que desea ingresar de encuentra desactivada.',
							'type' => 'error'
						]);
				break;
				
				//Si el documento y contraseña son correctos inicia sesión y asigna variables
				default:
					session_start(['SISCO']);
					$_SESSION['online'] = true;
					$_SESSION['usuario'] = $userDates->nombres.' '.$userDates->apellidos;
					$_SESSION['id_usuario'] = $userDates->nombres.' '.$userDates->apellidos;
					$_SESSION['documento'] = $userDates->documento;
					$_SESSION['tipo_usuario'] = $userDates->tipo_usuario;
					$_SESSION['foto'] = $userDates->foto_usuario;

					//Redirige a la página principal
					$url = "<script>window.location.href='".SERVER_URL."home/'</script>";
					$result = $url;
				break;
			}
			return $result;
		}

		//Método para cerrar sesión
		public function logout_controller()
		{
			session_start(['SISCO']);
			$_SESSION = array();

			if (ini_get("session.use_cookies")) 
			{
			    $params = session_get_cookie_params();
			    setcookie(session_name(), '', time() - 42000,
			        $params["path"], $params["domain"],
			        $params["secure"], $params["httponly"]
			    );
			}
			session_destroy();
				
			return true;
		}

		//Método para forzar a cerrar sesión
		public function forced_logout()
		{
			session_destroy();
			return header("location: ".SERVER_URL."login/");
		}
	}