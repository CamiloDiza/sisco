<?php
	require_once "./app/config/config.php"; //Configuraciones generales
	require_once "./app/config/LoadViews.php"; //Cargar vistas

	$home = new LoadViews;
	$home->get_home();