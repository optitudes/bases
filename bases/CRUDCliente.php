<?php
include('conexion.php');
$con = connection();

// Manejar la inserción de datos cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_Cliente = $_POST['id_Cliente'];
    $nombre_1 = $_POST['nombre_1'];
    $apellido_1 = $_POST['apellido_1'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $enfermedades = $_POST['enfermedades'];
    $alergias = $_POST['alergias'];

    // Insertar en la tabla cliente
    $sql_cliente = "INSERT INTO cliente (id_Cliente, nombre_1, apellido_1, fecha_nacimiento, enfermedades, alergias) 
                    VALUES ('$id_Cliente', '$nombre_1', '$apellido_1', '$fecha_nacimiento', '$enfermedades', '$alergias')";
    $result_cliente = mysqli_query($con, $sql_cliente);

    // Obtener el id_Cliente recién insertado
    $id_Cliente_insertado = mysqli_insert_id($con);

    if (!$result_cliente) {
        die("Error al insertar datos: " . mysqli_error($con));
    }
}

// Consulta para obtener los datos
$sql = "SELECT cliente.*, residencia.nombreResidencia, telefono.numero
        FROM cliente
        LEFT JOIN telefono ON cliente.id_Cliente = telefono.id_Cliente
        LEFT JOIN residencia ON cliente.id_Cliente = residencia.id_Cliente";
$query = mysqli_query($con, $sql);

if (!$query) {
    die("Error en la consulta: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios CRUD</title>
</head>

<body>
    <div>
        <form method="post" action="">
            <h1>Crear Cliente</h1>
            <input type="text" name="id_Cliente" placeholder="IdCliente">
            <input type="text" name="nombre_1" placeholder="Nombre1">
            <input type="text" name="apellido_1" placeholder="Apellido">

            <input type="text" name="fecha_nacimiento" placeholder="Fecha de nacimiento">   
                    
            <input type="text" name="enfermedades" placeholder="Enfermedades">
            <input type="text" name="alergias" placeholder="Alergias">
           
            <input type="submit" value="Agregar empleado">
        </form>
    </div>

    <div>
        <h2>Clientes registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>Identificación</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Fecha de nacimiento</th>
                    <th>Enfermedades</th>
                    <th>Alergias</th>
                    <th>Número de teléfono</th>
                    <th>Residencia</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <th><?= $row['id_Cliente'] ?></th>
                        <th><?= $row['nombre_1'] ?></th>
                        <th><?= $row['apellido_1'] ?></th>
                        <th><?= $row['fecha_nacimiento'] ?></th>
                        <th><?= $row['enfermedades'] ?></th>
                        <th><?= $row['alergias'] ?></th>
                        <th><?= $row['numero'] ?></th>
                        <th><?= $row['nombreResidencia'] ?></th>
                        
                
                        <th><a href="actualizarCliente.php?id=<?=$row['id_Cliente']?>" class="crud-table--eliminar">Actualizar</a></th>
                        <th><a href="eliminarCliente.php?id=<?=$row['id_Cliente']?>" class="crud-table--eliminar">Eliminar</a></th>

                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
