<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Consultas</title>
    <style>
        #menuButton {
            background-color: #4caf50;
            color: white;
            font-size: 15px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: absolute;
            top: 10px;
            left: 10px;
        }

       
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .container {
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1{
            color: #333;
            text-align: Center;
        }

        a {
            background-color: #4caf50;
            color: white;
            font-size: 15px;
            text-align: Center;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: auto; /* Alinea el botón en el centro horizontalmente */
            display: block; /* Permite que el margin: auto funcione */
        }
    </style>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Obtiene el botón de menú por su ID
            var menuButton = document.createElement('button');
            menuButton.textContent = 'Menú';
            menuButton.id = 'menuButton';

            // Agrega un event listener para el clic en el botón de menú
            menuButton.addEventListener('click', function () {
                // Redirige a menu.php
                window.location.href = 'menu.php';
            });

            // Agrega el botón al cuerpo del documento
            document.body.appendChild(menuButton);
        });
    </script>
</head>
<body>
   

        <div class="container">
        <h1>Consultas</h1> <br> <br>
        <a href="Consultas_Simples.php">Consultas Simples</a><br>
        <a href="Consultas_Intermedias.php">Consultas Intermedias</a><br>
    </div>
</body>
</html>
