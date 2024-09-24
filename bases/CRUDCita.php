<?php
include('conexion.php');
$con = connection();

// Manejar la inserción de datos cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_Emple_insertado = $_POST['id_Cita'];
    $fecha = $_POST['fecha'];
    $duracion = $_POST['duracion'];
  

    // Insertar en la tabla cliente
    $sql_Cita = "INSERT INTO Cita (id_Empleado, fecha,duracion)
                    VALUES ('$id_Cita_insertado', '$fecha', '$duracion')";
    $result_Cita = mysqli_query($con, $sql_Cita);

    // Obtener el id_Cliente recién insertado
    $id_Cita_insertado_insertado = mysqli_insert_id($con);

    if (!$result_cita) {
        die("Error al insertar datos: " . mysqli_error($con));
    }
}

// Consulta para obtener los datos
$sql = "SELECT cita.*, empleado.nombreEmpleado, cliente.nombreCliente
        FROM cita
        LEFT JOIN empleado ON cita.id_Empleado = empleado.id_Empleado
        LEFT JOIN cliente ON cita.id_Cita = cliente.id_Cita";
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
    <title>Cita CRUD</title>
</head>

<body>
    <div>
        <form method="post" action="">
            <h1>Crear cita</h1>
            <input type="text" name="id_Cita" placeholder="Id_Cita">
            <input type="text" name="fecha" placeholder="Fecha">
            <input type="text" name="duracion" placeholder="Duracion">
           
            <input type="submit" value="Agregar usuario">
        </form>
    </div>

    <div>
        <h2>Citas registradas</h2>
        <table>
            <thead>
                <tr>
                    <th>Identificación</th>
                    <th>Fecha</th>
                    <th>Duracion</th>
                 
                    <th>nombreEmpleado</th>
                    <th>nombreCliente</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <th><?= $row['id_Cita'] ?></th>
                        <th><?= $row['fecha'] ?></th>
                        <th><?= $row['duracion'] ?></th>
                      
                        <th><?= $row['nombreEmpleado'] ?></th>
                        <th><?= $row['nombreCliente'] ?></th>
                                
                        <th><a href="#">Editar</a></th>
                        <th><a href="eliminarCita.php?id=<?=$row['id_Cita']?>" class="crud-table--eliminar">Eliminar</a></th>

                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
