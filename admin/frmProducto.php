

<form action="productos.php?accion=alta" method="post" enctype="multipart/form-data">
  <label>Nombre:</label>
  <br>
  <input type="text" name="nombre">  <br>
<br>
  <label>Precio:</label>
  <br>
  <input type="text" name="precio">  <br>
<br>
  <label>Presentacion:</label>
  <br>
  <input type="text" name="presentacion">  <br>
  <br>
  <label>Marca:</label>
  <br>
  <select name="marca">
      <option value="1">1</optionZ>
        <option value="2">2</option>
        <option value="3">3</option>
  </select>  <br>

  <br>
  <label>Imagen</label>
  <br>
  <input type="file" name="imagen">   <br>
  <br>
  <input type="submit" value="Guardar">

</form>
