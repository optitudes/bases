<?php
include('conexion.php');
$con = connection();

// Consulta para obtener los datos de la tabla Empleado
$sqlEmpleado = "SELECT * FROM Empleado";
$resultEmpleado = mysqli_query($con, $sqlEmpleado);

// Consulta para obtener los datos de la tabla Cargo
$sqlCargo = "SELECT * FROM Cargo";
$resultCargo = mysqli_query($con, $sqlCargo);

// Consulta para obtener los datos de la tabla Cliente
$sqlCliente = "SELECT * FROM Cliente";
$resultCliente = mysqli_query($con, $sqlCliente);

// Consulta para obtener los datos de la tabla Servicio
$sqlServicio = "SELECT * FROM Servicio";
$resultServicio = mysqli_query($con, $sqlServicio);

// Consulta para obtener los datos de la tabla Producto
$sqlProducto = "SELECT * FROM Producto";
$resultProducto = mysqli_query($con, $sqlProducto);

// Consulta para obtener los datos de la tabla Proveedor
$sqlProveedor = "SELECT * FROM Proveedor";
$resultProveedor = mysqli_query($con, $sqlProveedor);

// Consulta para obtener los datos de la tabla Residencia
$sqlResidencia = "SELECT * FROM Residencia";
$resultResidencia = mysqli_query($con, $sqlResidencia);

// Consulta para obtener los datos de la tabla Telefono
$sqlTelefono = "SELECT * FROM Telefono";
$resultTelefono = mysqli_query($con, $sqlTelefono);

// Consulta para obtener los datos de la tabla Cita
$sqlCita = "SELECT * FROM Cita";
$resultCita = mysqli_query($con, $sqlCita);

// Consulta para obtener los datos de la tabla Pago
$sqlPago = "SELECT * FROM Pago";
$resultPago = mysqli_query($con, $sqlPago);

// Consulta para obtener los datos de la tabla Reserva
$sqlReserva = "SELECT * FROM Reserva";
$resultReserva = mysqli_query($con, $sqlReserva);

// Consulta para obtener los datos de la tabla CalificacionServicio
$sqlCalificacionServicio = "SELECT * FROM CalificacionServicio";
$resultCalificacionServicio = mysqli_query($con, $sqlCalificacionServicio);

// Consulta para obtener los datos de la tabla Servicio_Has_Cita
$sqlServicioHasCita = "SELECT * FROM Servicio_Has_Cita";
$resultServicioHasCita = mysqli_query($con, $sqlServicioHasCita);

// Consulta para obtener los datos de la tabla Producto_Has_Proveedor
$sqlProductoHasProveedor = "SELECT * FROM Producto_Has_Proveedor";
$resultProductoHasProveedor = mysqli_query($con, $sqlProductoHasProveedor);

// Consulta para obtener los datos de la tabla Empleado_Has_Producto
$sqlEmpleadoHasProducto = "SELECT * FROM Empleado_Has_Producto";
$resultEmpleadoHasProducto = mysqli_query($con, $sqlEmpleadoHasProducto);

// Consulta para obtener los datos de la tabla Inventario
$sqlInventario = "SELECT * FROM Inventario";
$resultInventario = mysqli_query($con, $sqlInventario);

if (!$resultEmpleado || !$resultCargo || !$resultCliente||
    !$resultServicio || !$resultProducto || !$resultProveedor || !$resultResidencia || !$resultTelefono ||
    !$resultCita || !$resultPago || !$resultReserva || !$resultCalificacionServicio || !$resultServicioHasCita ||
    !$resultProductoHasProveedor || !$resultEmpleadoHasProducto || !$resultInventario
) {
    die("Error en la consulta: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Base de Datos</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h1>Información de la Tabla Empleado</h1>
<table>
    <thead>
        <tr>
            <th>ID Empleado</th>
            <th>ID Cargo</th>
            <th>Salario</th>
            <th>Nombre 1</th>
            <th>Nombre 2</th>
            <th>Apellido 1</th>
            <th>Apellido 2</th>
            <th>Correo Electrónico</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($resultEmpleado)): ?>
            <tr>
                <td><?= $row['id_Empleado'] ?></td>
                <td><?= $row['id_Cargo'] ?></td>
                <td><?= $row['salario'] ?></td>
                <td><?= $row['nombre_1'] ?></td>
                <td><?= $row['nombre_2'] ?></td>
                <td><?= $row['apellido_1'] ?></td>
                <td><?= $row['apellido_2'] ?></td>
                <td><?= $row['correo_electronico'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<h1>Información de la Tabla Cargo</h1>
<table>
    <thead>
        <tr>
            <th>ID Cargo</th>
            <th>Nombre Cargo</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($resultCargo)): ?>
            <tr>
                <td><?= $row['id_Cargo'] ?></td>
                <td><?= $row['nombreCargo'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<h1>Información de la Tabla Cliente</h1>
<table>
    <thead>
        <tr>
            <th>ID Cliente</th>
            <th>Nombre 1</th>
            <th>Apellido 1</th>
            <th>Fecha Nacimiento</th>
            <th>Enfermedades</th>
            <th>Alergias</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($resultCliente)): ?>
            <tr>
                <td><?= $row['id_Cliente'] ?></td>
                <td><?= $row['nombre_1'] ?></td>
                <td><?= $row['apellido_1'] ?></td>
                <td><?= $row['fecha_nacimiento'] ?></td>
                <td><?= $row['enfermedades'] ?></td>
                <td><?= $row['alergias'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<h1>Información de la Tabla Servicio</h1>
<table>
    <thead>
        <tr>
            <th>ID Servicio</th>
            <th>Nombre Servicio</th>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($resultServicio)): ?>
            <tr>
                <td><?= $row['id_Servicio'] ?></td>
                <td><?= $row['nombre_Servicio'] ?></td>
                <td><?= $row['descripcion'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<h1>Información de la Tabla Producto</h1>
<table>
    <thead>
        <tr>
            <th>ID Producto</th>
            <th>Nombre Producto</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($resultProducto)): ?>
            <tr>
                <td><?= $row['id_Producto'] ?></td>
                <td><?= $row['nombre_Producto'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<h1>Información de la Tabla Proveedor</h1>
<table>
    <thead>
        <tr>
            <th>ID Proveedor</th>
            <th>Nombre Proveedor</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($resultProveedor)): ?>
            <tr>
                <td><?= $row['id_Proveedor'] ?></td>
                <td><?= $row['nombre_Proveedor'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<h1>Información de la Tabla Residencia</h1>
<table>
    <thead>
        <tr>
            <th>ID Residencia</th>
            <th>ID Cliente</th>
            <th>ID Empleado</th>
            <th>Nombre Residencia</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($resultResidencia)): ?>
            <tr>
                <td><?= $row['id_Residencia'] ?></td>
                <td><?= $row['id_Cliente'] ?></td>
                <td><?= $row['id_Empleado'] ?></td>
                <td><?= $row['nombreResidencia'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<h1>Información de la Tabla Telefono</h1>
<table>
    <thead>
        <tr>
            <th>ID Telefono</th>
            <th>ID Empleado</th>
            <th>ID Cliente</th>
            <th>Número</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($resultTelefono)): ?>
            <tr>
                <td><?= $row['id_Telefono'] ?></td>
                <td><?= $row['id_Empleado'] ?></td>
                <td><?= $row['id_Cliente'] ?></td>
                <td><?= $row['numero'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<h1>Información de la Tabla Cita</h1>
<table>
    <thead>
        <tr>
            <th>ID Cita</th>
            <th>ID Empleado</th>
            <th>ID Cliente</th>
            <th>Fecha</th>
            <th>Duración</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($resultCita)): ?>
            <tr>
                <td><?= $row['id_Cita'] ?></td>
                <td><?= $row['id_Empleado'] ?></td>
                <td><?= $row['id_Cliente'] ?></td>
                <td><?= $row['fecha'] ?></td>
                <td><?= $row['duracion'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<h1>Información de la Tabla Pago</h1>
<table>
    <thead>
        <tr>
            <th>ID Pago</th>
            <th>ID Cita</th>
            <th>ID Cliente</th>
            <th>Total Pago</th>
            <th>Fecha Pago</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($resultPago)): ?>
            <tr>
                <td><?= $row['id_Pago'] ?></td>
                <td><?= $row['id_Cita'] ?></td>
                <td><?= $row['id_Cliente'] ?></td>
                <td><?= $row['total_Pago'] ?></td>
                <td><?= $row['fecha_pago'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<h1>Información de la Tabla Reserva</h1>
<table>
    <thead>
        <tr>
            <th>ID Reserva</th>
            <th>ID Cita</th>
            <th>ID Cliente</th>
            <th>ID Servicio</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($resultReserva)): ?>
            <tr>
                <td><?= $row['id_Reserva'] ?></td>
                <td><?= $row['id_Cita'] ?></td>
                <td><?= $row['id_Cliente'] ?></td>
                <td><?= $row['id_Servicio'] ?></td>
                <td><?= $row['Estado'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<h1>Información de la Tabla CalificacionServicio</h1>
<table>
    <thead>
        <tr>
            <th>ID CalificacionServicio</th>
            <th>Calificación</th>
            <th>ID Cliente</th>
            <th>ID Servicio</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($resultCalificacionServicio)): ?>
            <tr>
                <td><?= $row['id_CalificacionServicio'] ?></td>
                <td><?= $row['calificacion'] ?></td>
                <td><?= $row['id_Cliente'] ?></td>
                <td><?= $row['id_Servicio'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<h1>Información de la Tabla Servicio_Has_Cita</h1>
<table>
    <thead>
        <tr>
            <th>ID Cita</th>
            <th>ID Servicio</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($resultServicioHasCita)): ?>
            <tr>
                <td><?= $row['id_Cita'] ?></td>
                <td><?= $row['id_Servicio'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>



</body>
</html>
