<?php

	//Ruta servidor
	const SERVER_URL = 'http://localhost/sisco/'; 
	//Ruta app
	define('APP_URL',dirname(dirname(__FILE__)));

	//Zona horaria
	date_default_timezone_set("America/Bogota");

	//Configuració BD
	const HOST = "localhost"; //servidor
	const DB = "mydb"; //nombre de la bd
	const USER = "root"; //usuario
	const PASS = ""; //contraseña