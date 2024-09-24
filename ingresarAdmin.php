<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alkatra:wght@500&family=Montserrat:wght@300&display=swap"
        rel="stylesheet">

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

        h1{
            color: #333;
            text-align: Center;
        }

        h2 {
            margin-top: 5px;
            font-size: 20px;
            color: #555;
            text-align: center;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }


        input {
         background-color: #bebebe;
            padding: 10px 30px;
            border: none;
            border-radius: 5px;
           margin: auto; /* Alinea el botón en el centro horizontalmente */
           display: block; /* Permite que el margin: auto funcione */
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            font-size: 15px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: auto; /* Alinea el botón en el centro horizontalmente */
            display: block; /* Permite que el margin: auto funcione */
        }
        
    </style>
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
    $baseDeDatos = "bases";

    // Nombre de la tabla a trabajar
    $tabla = "administrador";

    function Conectarse()
    {
        global $host, $puerto, $usuario, $contrasena, $baseDeDatos, $tabla;

        $link = mysqli_connect("$host:$puerto", $usuario, $contrasena);

        if (!$link) {
            echo "Error conectando a la base de datos.<br>";
            exit();
        }

        if (!mysqli_select_db($link, $baseDeDatos)) {
            echo "Error seleccionando la base de datos.<br>";
            exit();
        }

        return $link;
    }

    $link = Conectarse();

    if ($_POST) {
        $log = $_POST['flogin'];
        $cla = $_POST['fclave'];

        $query = "SELECT nombreadministrador, claveadministrador FROM $tabla WHERE nombreadministrador=? AND claveadministrador=?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "ss", $log, $cla);
        mysqli_stmt_execute($stmt);

        $resul = mysqli_stmt_get_result($stmt);

        if (!$resul) {
            die("Error en la consulta: " . mysqli_error($link));
        }

        $num = mysqli_num_rows($resul);

        if ($num == 0) {
            echo '<script>alert("Datos incorrectos.");</script>';
        } else {
            // Redirigir a menu.php si los datos son correctos
            header("Location: menu.php");
            exit();
        }

        mysqli_stmt_close($stmt);
    }

    ?>
   
    <form action="" method="post">
      <h1>Inicio de Sesión</h1>
      <h2>Administrador:</h2>
      <input type="text" name="flogin"> <br>
      <h2>Contraseña:</h2>
       <input type="text" name="fclave"> <br>
        <input type="submit" value="Ingresar a la aplicacion">
    </form>
    <br><br>

</body>

</html>

