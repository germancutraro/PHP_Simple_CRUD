<?php
	include("conexion.php");

if( isset($_GET["accion"]) && !empty($_GET["accion"])) :
	
	$controlador = $_GET["accion"];

	////////////////////////////////////////////////////
	if($controlador == "registro" ): 

		$email = $_POST["email"];
		$pass = $_POST["pass"];

		//1) Validar si el email existe en la Base de Datos
		$sql = "SELECT * FROM `usuarios` WHERE `E-Mail` = '" . $email . "'";
		$query = mysqli_query($laConexion, $sql);

		if ( mysqli_num_rows( $query ) > 0 ) {
			mysqli_close( $laConexion );
			header("location: registro.php?r=0x001");
		} else {
			//Inicia la registracion
			$string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789,;:!?.$/*-+&@_+;./*&?$-!,";

			$salt = str_shuffle( $string ); //1) Mezclar la varable $string
			$salt = base64_encode( $salt ); //2) Codificar a Base64
			$salt = strtr( $salt, "+", "." ); //3) Reemplazo el caracter "+" por "."
			$salt = sprintf( "$2a$%2d$", 10 ) . $salt; //4) Le agrego a la Sal una firma/patron

			$hash = crypt( $pass, $salt ); //$hash => Contraseña Encriptada + Sal

			//Crear clave de activacion
			$key = str_shuffle( $string );
			$key = base64_encode( $key );
			$key = sprintf( "$2a$%2d$", 15 ) . $key; 

			//Registrar usuario
			$sql = "INSERT INTO `usuarios` (`E-Mail`, `Password`, `Key`) VALUES ('$email', '$hash', '$key')";

			if( mysqli_query($laConexion, $sql) == true ) {
				//Registro Exitoso!
				mysqli_close($laConexion);

				$url_activacion = "http://" . $_SERVER["SERVER_NAME"] . "/SistemaDeProductos3/admin/";
				$url_activacion.= "usuarios.php";
				$url_activacion.= "?u=" . $email;
				$url_activacion.= "&k=" . $key;
				$url_activacion.= "&accion=activacion";

				$cuerpo = "<h1>Bienvenido a Sistema De Productos</h1>";
				$cuerpo.= "<br>";
				$cuerpo.= "<p>Por favor, active su cuenta para operar en la plataforma</p>";
				$cuerpo.= "<br>";
				$cuerpo.= "<a style='background-color: green; color: white; display: block; padding: 10px;' href='" . $url_activacion . "'>ACTIVAR MI CUENTA</a>";
				$cuerpo.= "<hr>";

				$cabecera = "From: no-reply@" . $_SERVER["SERVER_NAME"] . "\r\n";
				$cabecera.= "MIME-Version: 1.0" ."\r\n";
				$cabecera.= "Content-Type: text/html; charset=UTF-8" . "\r\n";

				mail( $email , "Alta de nuevo Usuario", $cuerpo, $cabecera);

				//header("location: registro.php?r=0x003");

				echo $cuerpo;

			} else {
				mysqli_close($laConexion);
				header("location: registro.php?r=0x002");
			}
		}
	endif; //Fin del Controlador "Registro"
	////////////////////////////////////////////////////
	if( $controlador == "login" ):
		include("lib/hash.php");

		$email = $_POST["email"];
		$pass = $_POST["pass"];

		$sql = "SELECT * FROM `usuarios` WHERE `E-Mail` = '$email' AND `Activo` = 1";
		$query = mysqli_query($laConexion, $sql);

		if ( mysqli_num_rows($query) > 0 ) {
			//Hay un usuario con el e-mail ingresado
			$user = mysqli_fetch_assoc( $query );

			$pass_encriptada = crypt( $pass, $user["Password"] );

			if ( hash_equals( $user["Password"], $pass_encriptada ) ) {
				//La contraseña es correcta
				session_start();
				$_SESSION["usuario"] = $user["E-Mail"];
				header("location:index.php");
			} else {
				//echo "contraeña incorrecta";
				header("location:login.php?r=0x003");
			}
		} else {
			//Usuario no registrado o no activo
			header("location:login.php?r=0x002");
		}

	endif; //Fin del Controlador "Login"
	////////////////////////////////////////////////////
	if( $controlador == "logout" ):

		session_start();
		if ( isset( $_COOKIE[session_name()] ) ) //session_name() => PHPSESSID
			setcookie( session_name(), "", time()-3600, "/" );

		unset( $_SESSION["usuario"] );
		session_destroy();
		header("location:login.php");

	endif; //Fin del Controlador "Logout"
	////////////////////////////////////////////////////
	if( $controlador == "activacion" ):
		$user = $_GET["u"];
		$key = $_GET["k"];

		$sql = "SELECT * FROM `usuarios` WHERE `E-Mail` = '$user' AND `Key` = '$key'";
		$query = mysqli_query($laConexion, $sql);

		if( mysqli_num_rows( $query ) > 0 ) {
			//Activar la cuenta del usuario
			$sql = "UPDATE `usuarios` SET `Activo` = 1 WHERE `E-Mail` = '$user'";

			if( mysqli_query($laConexion, $sql) == true ) {
				mysqli_close( $laConexion );
				header("location: login.php?r=0x001");
			} else {
				mysqli_close( $laConexion );
				header("location: login.php?r=0x002");
			}

		} else {
			mysql_close($laConexion);
			header("location: registro.php?r=0x004");
		}
	endif; //Fin del Controlador "Logout"
	////////////////////////////////////////////////////

endif; //Fin del Modulo Usuarios

?>