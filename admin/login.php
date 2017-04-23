<?php
	//validar si se esta logeado
	session_start();
	if ( isset( $_SESSION["usuario"] ) ) {
		header("location: index.php"); //Va a index
	}
?>
<h1>Login de Usuarios</h1>
<form action="usuarios.php?accion=login" method="post">
	E-Mail:
	<br>
	<input type="text" name="email">
	<br>
	Contrase&ntilde;a:
	<br>
	<input type="password" name="pass">
	<br>
	<input type="submit" value="Enviar">
</form>