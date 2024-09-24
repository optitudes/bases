<?php
include('conexion.php');
$con = connection();

// Manejar la inserción de datos cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_Emple_insertado = $_POST['id_Empleado'];
    $nombre_1 = $_POST['nombre_1'];
    $nombre_2 = $_POST['nombre_2'];
    $apellido_1 = $_POST['apellido_1'];
    $apellido_2 = $_POST['apellido_2'];  
    $correo_electronico = $_POST['correo_electronico'];
    $salario = $_POST['salario'];

    // Insertar en la tabla cliente
    $sql_Empleado = "INSERT INTO Empleado (id_Empleado, nombre_1,nombre_2, apellido_1 apellido_2, correo_electronico, salario) 
                    VALUES ('$id_Empleado', '$nombre_1', '$nombre_2','$apellido_1','$apellido_2', '$correo_electronico', '$salario')";
    $result_Empleado = mysqli_query($con, $sql_Empleado);

    // Obtener el id_Empleado recién insertado
    $id_Emple_insertado_insertado = mysqli_insert_id($con);

    if (!$result_empleado) {
        die("Error al insertar datos: " . mysqli_error($con));
    }
}

// Consulta para obtener los datos
$sql = "SELECT empleado.*, residencia.nombreResidencia, telefono.numero, cargo.nombreCargo
        FROM empleado
        LEFT JOIN telefono ON empleado.id_Empleado = telefono.id_Empleado
        LEFT JOIN residencia ON empleado.id_Empleado = residencia.id_Empleado
        LEFT JOIN cargo on empleado.id_Cargo = cargo.id_Cargo";
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
            <h1>Crear empleado</h1>
            <input type="text" name="id_Empleado" placeholder="IdCliente">
            <input type="text" name="nombre_1" placeholder="Nombre1">
            <input type="text" name="nombre_2" placeholder="Nombre2">
            <input type="text" name="apellido_1" placeholder="Apellido1">
            <input type="text" name="apellido_2" placeholder="Apellido2">
            <input type="text" name="correo_electronico" placeholder="Correo electronico">           
            <input type="text" name="salario" placeholder="Salario">
           
            <input type="submit" value="Agregar empleado">
        </form>
    </div>

    <div>
        <h2>Empleados registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>Identificación</th>
                    <th>Nombre1</th>
                    <th>Nombre2</th>
                    <th>Apellido1</th>
                    <th>Apellido2</th>
                    <th>Corero electronico</th>
                    <th>Salario</th>
                    <th>Número de teléfono</th>
                    <th>Residencia</th>
                    <th>Cargo</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <th><?= $row['id_Empleado'] ?></th>
                        <th><?= $row['nombre_1'] ?></th>
                        <th><?= $row['nombre_2'] ?></th>
                        <th><?= $row['apellido_1'] ?></th>
                        <th><?= $row['apellido_2'] ?></th>
                        <th><?= $row['correo_electronico'] ?></th>
                        <th><?= $row['salario'] ?></th>
                        <th><?= $row['numero'] ?></th>
                        <th><?= $row['nombreResidencia'] ?></th>
                        <th><?= $row['cargo'] ?></th>

                        
                        <th><a href="#">Editar</a></th>
                        <th><a href="eliminarEmpleado.php?id=<?=$row['id_Empleado']?>" class="crud-table--eliminar">Eliminar</a></th>

                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
