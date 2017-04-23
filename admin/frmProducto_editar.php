<?php

  include("conexion.php");
    $pID = $_GET["p"];

    $sql = "SELECT * FROM `productos` WHERE `idProducto` = " . $pID;
    $query = mysqli_query($laConexion, $sql);
    $producto = mysqli_fetch_assoc( $query ); //Tengo el producto en un array

    $sqla = "SELECT * FROM `productos` WHERE `Marcas` = " . $pID;
    $query = mysqli_query($laConexion, $sql);
    $marca = mysqli_fetch_assoc($query);




?>

<form action="productos.php?accion=modificacion" method="post" enctype="multipart/form-data">
  <label>Nombre:</label>
  <br>
  <input type="text" name="nombre" value="<?php echo $producto["Nombre"]; ?>">  <br>
<br>
  <label>Precio:</label>
  <br>
  <input type="text" name="precio" value="<?php echo $producto['Precio']; ?>">  <br>
<br>
  <label>Presentacion:</label>
  <br>
  <input type="text" name="presentacion" value="<?php echo $producto['Precio']; ?>">  <br>
  <br>
  <label>Marca:</label>
  <br>
  <select name="marca">

    <option value="<?php echo $producto["Marca"]; ?>"><?php echo $marca["Marca"]; ?></option>

  </select>  <br>

  <br>
  <label>Imagen</label>
  <br>
  <input type="file" name="imagen">   <br>
  <br>


  <input type="submit" value="Guardar">
  <input type="hidden" name="id">
</form>
