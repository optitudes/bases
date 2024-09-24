<?php
include('conexion.php');
$con = connection(); // Asegúrate de que la función se llama connection()
?>
<html>
  <head>

  <style>
        .menuButton {
            font-size: 15px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: absolute;
            top: 10px;
        }

        #menuButton {
            background-color: #4caf50;
            color: white;
            left: 10px;
        }

        #graficaButton {
            background-color: #4285f4;
            color: white;
            left: 100px;
        }

        #volverButton {
            background-color: #e74c3c; /* Color rojo */
            color: white;
            left: 200px; /* Ajusta la posición según tu preferencia */
        }
    </style>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            

            // Botón de volver
            var volverButton = document.createElement('button');
            volverButton.textContent = 'Volver';
            volverButton.className = 'menuButton';
            volverButton.id = 'volverButton';

            volverButton.addEventListener('click', function () {
                window.location.href = 'CRUDEmpleado.php'; // Reemplaza con tu página anterior
            });

            document.body.appendChild(volverButton);
        });
    </script>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
        
        <?php

            $SQL = "SELECT * FROM empleado";
            $consulta = mysqli_query($con, $SQL) or die(mysqli_error($con)); // Usar $con en lugar de $conecction
            while ($resultado = mysqli_fetch_assoc($consulta)){
                echo "['" .$resultado['nombre_1']."'," .$resultado['salario']."],";
            }

        ?>
        ]);

        var options = {
          title: 'Diagrama circular sobre el empleado que mas gana salarialmente.'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>
