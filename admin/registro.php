<?php
	//validar si se esta logeado
	session_start();
	if ( isset( $_SESSION["usuario"] ) ) {
		header("location: index.php"); //Va a index
	}
?>
<h1>Registro de Usuarios</h1>
<form action="usuarios.php?accion=registro" method="post">
	E-Mail:
	<br>
	<input type="text" name="email">
	<br>
	Contraseña:
	<br>
	<input type="password" name="pass">
	<br>
	<br>
	<input type="submit" value="Enviar">
</form>