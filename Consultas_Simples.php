<?php
include('conexion.php');
require_once('fpdf/fpdf.php');
$con = connection();

// Consulta 1: Listar los clientes que tengan como enfermedad diabetes y hayan nacido antes del año 2000
$query1 = "SELECT * FROM Cliente WHERE enfermedades = 'diabetes' AND YEAR(fecha_nacimiento) < 2000";
$result1 = $con->query($query1);
$data1 = $result1->fetch_all(MYSQLI_ASSOC);

// Consulta 2: Listar los empleados que su salario sea mayor a 50000 y el nombre inicie por 'm'
$query2 = "SELECT * FROM Empleado WHERE salario > 50000 AND (nombre_1 LIKE 'm%' OR nombre_2 LIKE 'm%') ORDER BY salario DESC";
$result2 = $con->query($query2);
$data2 = $result2->fetch_all(MYSQLI_ASSOC);

// Consulta 3: Listar las citas que hayan durado más de 1 hora
$query3 = "SELECT * FROM Cita WHERE duracion > '01:00:00'";
$result3 = $con->query($query3);
$data3 = $result3->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas Simples</title>
    <link rel="stylesheet" href="./CSS/style.css">
    <style>
             .generate-pdf-button {
            background-color: #4caf50;
            color: white;
            font-size: 15px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
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

    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Obtiene el botón de menú por su ID
            var menuButton = document.createElement('button');
            menuButton.textContent = 'Consultas';
            menuButton.id = 'menuButton';

            // Agrega un event listener para el clic en el botón de menú
            menuButton.addEventListener('click', function () {
                // Redirige a menu.php
                window.location.href = 'consultas.php';
            });

            // Agrega el botón al cuerpo del documento
            document.body.appendChild(menuButton);
        });
    </script>
</head>
<body>
    <h1>Consultas Simples</h1>

    <h2>Consulta 1: </h2>
    <h3>Clientes con diabetes nacidos antes del año 2000</h3>
    <table border="1">
        <tr>
            <th>ID Cliente</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Fecha de Nacimiento</th>
            <th>Enfermedades</th>
            <th>Alergias</th>
        </tr>
        <?php foreach ($data1 as $row): ?>
            <tr>
                <td><?php echo $row['id_Cliente']; ?></td>
                <td><?php echo $row['nombre_1']; ?></td>
                <td><?php echo $row['apellido_1']; ?></td>
                <td><?php echo $row['fecha_nacimiento']; ?></td>
                <td><?php echo $row['enfermedades']; ?></td>
                <td><?php echo $row['alergias']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <form method="post" action="generate_pdf.php">
        <input type="hidden" name="consulta" value="1">
        <input type="hidden" name="filename" value="consulta1.pdf">
        <?php foreach ($data1 as $row): ?>
            <?php foreach ($row as $key => $value): ?>
                <input type="hidden" name="data1[<?php echo $row['id_Cliente']; ?>][<?php echo $key; ?>]" value="<?php echo $value; ?>">
            <?php endforeach; ?>
        <?php endforeach; ?>
        <button type="submit" class="generate-pdf-button">Generar PDF</button>
    </form>

    <h2>Consulta 2: </h2>
    <h3>Empleados con salario mayor a 50000, que cualquiera de sus nombres inicia con 'm' y ordenalos desde menor a mayor salario</h3>

    <table border="1">
        <tr>
            <th>ID Empleado</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Salario</th>
        </tr>
        <?php foreach ($data2 as $row): ?>
            <tr>
                <td><?php echo $row['id_Empleado']; ?></td>
                <td><?php echo $row['nombre_1']; ?></td>
                <td><?php echo $row['apellido_1']; ?></td>
                <td><?php echo $row['salario']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <form method="post" action="generate_pdf.php">
        <input type="hidden" name="consulta" value="2">
        <input type="hidden" name="filename" value="consulta2.pdf">
        <?php foreach ($data2 as $row): ?>
            <?php foreach ($row as $key => $value): ?>
                <input type="hidden" name="data2[<?php echo $row['id_Empleado']; ?>][<?php echo $key; ?>]" value="<?php echo $value; ?>">
            <?php endforeach; ?>
        <?php endforeach; ?>
        <button type="submit" class="generate-pdf-button">Generar PDF</button>
    </form>

    <h2>Consulta 3:</h2>
    <h3> Citas con duración superior a 1 hora</h3>

    <table border="1">
        <tr>
            <th>ID Cita</th>
            <th>ID Empleado</th>
            <th>ID Cliente</th>
            <th>Fecha</th>
            <th>Duración</th>
        </tr>
        <?php foreach ($data3 as $row): ?>
            <tr>
                <td><?php echo $row['id_Cita']; ?></td>
                <td><?php echo $row['id_Empleado']; ?></td>
                <td><?php echo $row['id_Cliente']; ?></td>
                <td><?php echo $row['fecha']; ?></td>
                <td><?php echo $row['duracion']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <form method="post" action="generate_pdf.php">
        <input type="hidden" name="consulta" value="3">
        <input type="hidden" name="filename" value="consulta3.pdf">
        <?php foreach ($data3 as $row): ?>
            <?php foreach ($row as $key => $value): ?>
                <input type="hidden" name="data3[<?php echo $row['id_Cita']; ?>][<?php echo $key; ?>]" value="<?php echo $value; ?>">
            <?php endforeach; ?>
        <?php endforeach; ?>
        <button type="submit" class="generate-pdf-button">Generar PDF</button>
    </form>

</body>
</html>
