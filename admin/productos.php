<?php
	include("conexion.php");

	if( isset($_GET["accion"]) && !empty($_GET["accion"])) :

		$controlador = $_GET["accion"];

		if( $controlador == "alta" ) { //<<== Agregar

				$nombre = $_POST['nombre'];
				$precio = $_POST['precio'];
				$presentacion = $_POST['presentacion'];
				$marca = $_POST['marca'];

				//var_dump($_FILES);

				$imagen_nombre = $_FILES['imagen']['name'];
				$imagen_tipo =   $_FILES['imagen']['type'];
				$imagen_peso =   $_FILES['imagen']['size'];
				$imagen_temp =   $_FILES['imagen']['tmp_name'];

				$directorio = $_SERVER["DOCUMENT_ROOT"] . "/SistemaDeProductosV4/images/uploads/" . $imagen_nombre;

				if(move_uploaded_file($imagen_temp, $directorio)){

					$sql = "INSERT INTO `productos` (`Nombre`, `Precio`, `Presentacion`, `Marca`, `Imagen`)
																	VALUES ('$nombre', $precio, '$presentacion', '$marca', '$directorio')"; //precio es int entonces no lleva tildes
					$query = mysqli_query($laConexion, $sql);

					if($query){
						mysqli_close($laConexion);
						header("Location: index.php?rta=ok");

					}else{

						mysqli_close($laConexion);
						echo 'Error';

					}

				}




			}

		if( $controlador == "baja" ) { //<<== Quitar

				$pID = $_GET["p"];
				$sql = "DELETE FROM `productos` WHERE `idProducto` = $pID";
				$query = mysqli_query($laConexion, $sql);
				mysqli_close();
				header("Location: index.php?rta=ok");





		}

		if( $controlador == "modificacion" ) { //<<== Actualizar

			$nombre = $_POST['nombre'];
			$precio = $_POST['precio'];
			$presentacion = $_POST['presentacion'];
			$marca = $_POST['marca'];
			$pID = $_GET["p"];

			$sql = "UPDATE `productos` SET
				`Nombre` = '$nombre',
				`Precio` = $precio,
				`Presentacion` = '$presentacion',
				`Marca` = $marca
				WHERE `Id_Producto` = $pID";

				if(mysqli_query($laConexion, $sql)){

						echo "Editado";

				}else{
					mysqli_close($laConexion);
					echo "Error";

				}


		}


	endif; //Fin del Modulo Productos

?>
