<?php
	//validar si se esta logeado
	session_start();
	if ( !isset( $_SESSION["usuario"] ) ) {
		header("location: login.php");
	}

	include("conexion.php");

	//$sql = "SELECT * FROM `Productos` LIMIT 0,10";
	$sql = "SELECT `P`.`idProducto`, `P`.`Nombre`, `P`.`Precio`, `P`.`Presentacion`, `M`.`Nombre` AS `Marca` FROM `Productos` AS `P` INNER JOIN `Marcas` AS `M` ON `P`.`Marca` = `M`.`idMarca`";
	$query = mysqli_query( $laConexion, $sql );
	mysqli_close($laConexion);

?>
<html>
	<head>
		<title>Sarasa | Back-End</title>
		<style type="text/css">
			body { font-family: sans-serif; }
			table th, table td { border: solid 1px #d9d9d9; padding: 10px; }
			table td { text-align: right; }
			table th:nth-of-type(1) { width: 150px }
			table th:nth-of-type(2) { width: 100px }
			table th:nth-of-type(3) { width: 150px }
			table th:nth-of-type(4) { width: 200px }
			body > p:nth-of-type(1) { float: right; }
		</style>
	</head>
	<body>
		<p>Hola <strong><?php echo $_SESSION["usuario"]; ?><strong> | <a href="usuarios.php?accion=logout">[x] Cerrar sesión</a></p>
		<h1>Panel de Control</h1>
		<h2>Lista de Productos:</h2>
		<table>
			<tr>
				<th>ID</th>
				<th>Nombre:</th>
				<th>Precio:</th>
				<th>Marca:</th>
				<th>Presentacion:</th>
				<th>Acciones</th>
			</tr>
			<?php while ( $producto = mysqli_fetch_assoc($query) ) { ?>
			<tr>
				<td><?php echo $producto["idProducto"]; ?>
				<td><?php echo $producto["Nombre"]; ?></td>
				<td>$<?php echo $producto["Precio"]; ?></td>
				<td><?php echo $producto["Marca"]; ?></td>
				<td><?php echo $producto["Presentacion"]; ?></td>
				<!--<td><img src=<?php echo $destino ?>></td>-->
				<td><a href="frmProducto_editar.php?p=<?php echo $producto['idProducto']; ?>">editar</a> <a href="productos.php?accion=baja&p=<?php echo $producto['idProducto']; ?>">Borrar</a></td>
			</tr>
			<?php } ?>
		</table>

	</body>
</html>
