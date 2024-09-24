

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style\style.css">
</head>
<body>  
    <h1>Agregar productos</h1>


     <form action="" method="post">
     <label for="nombre">Nombre del Producto:</label>
    <input type="text" name="nombre" required><br>

    <label for="precio">Precio:</label>
    <input type="number" step="0.01" name="precio" required><br>

    <label for="imagen">Imagen (URL):</label>
    <input type="text" name="imagen" required><br>

    <label for="categoria">Categoría:</label>
    <input type="text" name="categoria" required><br>

    <button type="submit">Crear Producto</button>



     </form>




</body>
</html>