<!DOCTYPE html>
<html lang="es">


<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alkatra:wght@500&family=Montserrat:wght@300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Inicio de sesión</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input {
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

</head>


<body>

   <?php

   // Dirección o IP del servidor MySQL
   $host = "localhost";

   // Puerto del servidor MySQL
   $puerto = "3306";

   // Nombre de usuario del servidor MySQL
   $usuario = "root";

   // Contraseña del usuario
   $contrasena = "";

   // Nombre de la base de datos
   $baseDeDatos ="bases";

   // Nombre de la tabla a trabajar
   $tabla = "administrador";

   function Conectarse()
   {
      global $host, $puerto, $usuario, $contrasena, $baseDeDatos, $tabla;

      $link = mysqli_connect("$host:$puerto", $usuario, $contrasena);

      if (!$link) {
         echo "Error conectando a la base de datos.<br>";
         exit();
      } else {
         echo "Conexion exitosa.<br>";
      }

      if (!mysqli_select_db($link, $baseDeDatos)) {
         echo "Error seleccionando la base de datos.<br>";
         exit();
      } else {
         echo "Base de datos accedida.<br>";
      }

      return $link;
   }

   $link = Conectarse();


   if ($_POST) {
      $log = $_POST['flogin'];
      $cla = $_POST['fclave'];

      // Utilizando sentencia preparada para evitar inyección de SQL
      $query = "SELECT nombreadministrador, claveadministrador FROM $tabla WHERE nombreadministrador=? AND claveadministrador=?";
      $stmt = mysqli_prepare($link, $query);
      mysqli_stmt_bind_param($stmt, "ss", $log, $cla);
      mysqli_stmt_execute($stmt);

      $resul = mysqli_stmt_get_result($stmt);

      // Verificar si la consulta se ejecutó correctamente
      if (!$resul) {
         die("Error en la consulta: " . mysqli_error($link));
      }

      $num = mysqli_num_rows($resul);

      if ($num == 0) {
         echo 'Datos incorrectos.';
      } else {
         echo 'Bienvenido: ', $log;
         ?>
         <br><br>
         <p style="text-align: center"><a href="menu.php">Continuar a la Aplicacion</a></p>
         <?php
      }

      mysqli_stmt_close($stmt);
   }

   ?>

 
 
   <form action="" method="post">
      Ingrese el nombre del administrador: <input type="text" name="flogin"> <br> <br>
      Ingrese la clave: <input type="text" name="fclave"> <br> <br><br><br>
      <input type="submit" value="Ingresar a la aplicacion">
   </form>
   <br><br>

   </body>
</html>
