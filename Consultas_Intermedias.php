<?php
include('conexion.php');
require_once('fpdf/fpdf.php');
$con = connection();

// Consulta 1: Contar la cantidad de citas que ha realizado cada empleado, imprimiendo ID empleado, nombre empleado y detalles de la cita
$query5 = "SELECT Empleado.id_Empleado, Empleado.nombre_1, COUNT(Cita.id_Cita) AS cantidad_citas
           FROM Empleado
           INNER JOIN Cita ON Empleado.id_Empleado = Cita.id_Empleado
           GROUP BY Empleado.id_Empleado";
$result5 = $con->query($query5);
$data1 = $result5->fetch_all(MYSQLI_ASSOC);


// Consulta 2: Obtener la cantidad total de productos que ha proporcionado cada proveedor.
$query6 = "SELECT P.id_Proveedor, P.nombre_Proveedor, COUNT(PP.id_Producto) AS cantidad_productos
FROM Proveedor P
INNER JOIN Producto_Has_Proveedor PP ON P.id_Proveedor = PP.id_Proveedor
GROUP BY P.id_Proveedor";
$result6 = $con->query($query6);
$data2 = $result6->fetch_all(MYSQLI_ASSOC);


// Consulta 3: Listar los empleados y la cantidad de productos que han manejado, ordenados por la cantidad de productos de forma descendente.
$query7 = "SELECT E.id_Empleado, E.nombre_1, COUNT(EP.id_Producto) AS cantidad_productos
FROM Empleado E
INNER JOIN Empleado_Has_Producto EP ON E.id_Empleado = EP.id_Empleado
GROUP BY E.id_Empleado
ORDER BY cantidad_productos DESC";
$result7 = $con->query($query7);
$data3 = $result7->fetch_all(MYSQLI_ASSOC);

// Consulta 4: Listar las citas junto con los detalles del cliente, el empleado y el servicio para las citas programadas para un día específico.
$query8 = "SELECT C.id_Cita, C.fecha, C.duracion, CL.nombre_1 AS nombre_cliente, E.nombre_1 AS nombre_empleado, S.nombre_Servicio
FROM Cita C
INNER JOIN Cliente CL ON C.id_Cliente = CL.id_Cliente
INNER JOIN Empleado E ON C.id_Empleado = E.id_Empleado
INNER JOIN Reserva R ON C.id_Cita = R.id_Cita
INNER JOIN Servicio S ON R.id_Servicio = S.id_Servicio
WHERE C.fecha = '2023-11-22'";
$result8 = $con->query($query8);
$data4 = $result8->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas Intermedias</title>
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
    <h1>Consultas Intermedias</h1>

    <h2>Consulta 1: </h2>
    <h3>Cantidad de citas realizadas por cada empleado</h3>
    <table border="1">
        <tr>
            <th>ID Empleado</th>
            <th>Nombre</th>
            <th>Cantidad de Citas</th>
        </tr>
        <?php foreach ($data1 as $row): ?>
            <tr>
                <td><?php echo $row['id_Empleado']; ?></td>
                <td><?php echo $row['nombre_1']; ?></td>
                <td><?php echo $row['cantidad_citas']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Consulta 2: </h2>
    <h3>Cantidad total de productos proporcionados por cada proveedor</h3>
    <table border="1">
        <tr>
            <th>ID Proveedor</th>
            <th>Nombre del Proveedor</th>
            <th>Cantidad Total de Productos</th>
        </tr>
        <?php foreach ($data2 as $row): ?>
            <tr>
                <td><?php echo $row['id_Proveedor']; ?></td>
                <td><?php echo $row['nombre_Proveedor']; ?></td>
                <td><?php echo $row['cantidad_productos']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Consulta 3: </h2>
    <h3>Cantidad de productos manejados por cada empleado</h3>
    <table border="1">
        <tr>
            <th>ID Empleado</th>
            <th>Nombre del Empleado</th>
            <th>Cantidad de Productos</th>
        </tr>
        <?php foreach ($data3 as $row): ?>
            <tr>
                <td><?php echo $row['id_Empleado']; ?></td>
                <td><?php echo $row['nombre_1']; ?></td>
                <td><?php echo $row['cantidad_productos']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Consulta 4: </h2>
    <h3>Citas programadas para un día específico</h3>
    <table border="1">
        <tr>
            <th>ID Cita</th>
            <th>Fecha</th>
            <th>Duración</th>
            <th>Nombre del Cliente</th>
            <th>Nombre del Empleado</th>
            <th>Nombre del Servicio</th>
        </tr>
        <?php foreach ($data4 as $row): ?>
            <tr>
                <td><?php echo $row['id_Cita']; ?></td>
                <td><?php echo $row['fecha']; ?></td>
                <td><?php echo $row['duracion']; ?></td>
                <td><?php echo $row['nombre_cliente']; ?></td>
                <td><?php echo $row['nombre_empleado']; ?></td>
                <td><?php echo $row['nombre_Servicio']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
