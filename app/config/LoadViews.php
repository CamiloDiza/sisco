<?php
	//Clase para cargar las vistas
	class LoadViews
	{
		protected function get_views_df($views)
		{
			//Lista de páginas permitidas
			$whiteList = ['home','test','register','professionals','patients','planner','profile','horary','dates','AST','mydates'];

			if(in_array($views, $whiteList))
			{
				if(is_file("./app/views/pages/".$views.".php"))
				{
					$content = "./app/views/pages/".$views.".php";
				}else{
					$content = "login";
				}
			}elseif($views == "login"){
				$content = "login";
			}elseif ($views == "index"){
				$content = "login";
			}else{
				$content = "404";
			}
			return $content; 
		}

		public function get_home()
		{
			return require_once "./app/views/pages/home.php";
		}

		public function get_views()
		{
			if(isset($_GET['views']))
			{
				$path = explode("/", $_GET['views']);
				$result = LoadViews::get_views_df($path[0]);
			}else{
				$result = "login";
			}
			return $result;
		} 
	}