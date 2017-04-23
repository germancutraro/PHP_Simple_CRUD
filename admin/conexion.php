<?php

	//1) Nombre del Servidor
	//2) Nombre de Usuario de MySQL
	//3) Contraseña de Usuario de MySQL
	//4) Nombre de la Base de Datos
	$laConexion = mysqli_connect("localhost", "root", "", "ComercioPHP_Final");

	if( $laConexion == false ) {
		$error = mysqli_connect_error();
		$fecha = date("Y-m-d H:i:s");

		$cuerpo = "Error de BD:";
		$cuerpo.= "<em>" . $error . "</em>";
		$cuerpo.= "Fecha: " . $fecha;

		$cabecera = "From: no-reply@sarasa.com\r\n";
		$cabecera .=  "MIME-Version: 1.0" ."\r\n";
		$cabecera .= "Content-Type: text/html; charset=UTF-8" . "\r\n";

		mail("profe@silviomessina.com", "Error de DB", $cuerpo, $cabecera);
		echo "Error de Conexion - Se envio un reporte al administrador";
		die();
	}

?>