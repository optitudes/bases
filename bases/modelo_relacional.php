<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imagen Centrada al 70%</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .centered-image {
            max-width: 100%;
            max-height: 100vh;
        }
    </style>
</head>
<body>

<?php
    // Ruta de la imagen
    $imagen = "./imagenes/ImgModelo.png";
?>

<img src="<?php echo $imagen; ?>" alt="Imagen centrada al 70%" class="centered-image">

</body>
</html>
