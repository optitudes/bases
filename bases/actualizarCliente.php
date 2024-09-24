<?php
include('conexion.php');
$con = connection();

$cliente_editar = [];

// Manejar la actualización de datos cuando se envía el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])) {
    $id_Cliente_editar = $_POST['id_Cliente_editar'];
    $nombre_1_editar = $_POST['nombre_1_editar'];
    $apellido_1_editar = $_POST['apellido_1_editar'];
    $fecha_nacimiento_editar = $_POST['fecha_nacimiento_editar'];
    $enfermedades_editar = $_POST['enfermedades_editar'];
    $alergias_editar = $_POST['alergias_editar'];
    $numero_editar = $_POST['numero_editar'];
    $residencia_editar = $_POST['residencia_editar'];

    // Actualizar datos en la tabla cliente
    $sql_actualizar_cliente = "UPDATE cliente
                       SET nombre_1 = '$nombre_1_editar',
                           apellido_1 = '$apellido_1_editar',
                           fecha_nacimiento = '$fecha_nacimiento_editar',
                           enfermedades = '$enfermedades_editar',
                           alergias = '$alergias_editar'
                       WHERE id_Cliente = '$id_Cliente_editar'";
    $result_actualizar_cliente = mysqli_query($con, $sql_actualizar_cliente);

    // Actualizar datos en la tabla telefono
    $sql_actualizar_telefono = "UPDATE telefono
                       SET numero = '$numero_editar'
                       WHERE id_Cliente = '$id_Cliente_editar'";
    $result_actualizar_telefono = mysqli_query($con, $sql_actualizar_telefono);

    // Verificar si el usuario tiene un número de teléfono relacionado
    $sql_verificar_telefono = "SELECT * FROM telefono WHERE id_Cliente = '$id_Cliente_editar'";
    $result_verificar_telefono = mysqli_query($con, $sql_verificar_telefono);

     // Actualizar datos en la tabla residencia
     $sql_actualizar_residencia = "UPDATE residencia
     SET nombreResidencia = '$residencia_editar'
     WHERE id_Cliente = '$id_Cliente_editar'";
     $result_actualizar_residencia= mysqli_query($con, $sql_actualizar_residencia);

     // Verificar si el usuario tiene una residencia relacionado
     $sql_verificar_residencia = "SELECT * FROM residencia WHERE id_Cliente = '$id_Cliente_editar'";
     $result_verificar_residencia = mysqli_query($con, $sql_verificar_residencia);

    if (mysqli_num_rows($result_verificar_telefono) == 0) {
        // Si no hay resultados, el usuario no tiene un número de teléfono, entonces insertarlo
        $sql_insertar_telefono = "INSERT INTO telefono (id_Cliente, numero) VALUES ('$id_Cliente_editar', '$numero_editar')";
        $result_insertar_telefono = mysqli_query($con, $sql_insertar_telefono);

        // Verificar si la inserción fue exitosa
        if (!$result_insertar_telefono) {
            echo "Error al insertar el número de teléfono: " . mysqli_error($con);
        }
    }

    if (mysqli_num_rows($result_verificar_residencia) == 0) {
        // Si no hay resultados, el usuario no tiene un número de teléfono, entonces insertarlo
        $sql_insertar_residencia = "INSERT INTO residencia (id_Cliente, nombreResidencia) VALUES ('$id_Cliente_editar', '$residencia_editar')";
        $result_insertar_residencia = mysqli_query($con, $sql_insertar_residencia);

        // Verificar si la inserción fue exitosa
        if (!$result_insertar_residencia) {
            echo "Error al insertar la residencia: " . mysqli_error($con);
        }
    }

    // Verificar si ambas consultas fueron exitosas
    if ($result_actualizar_cliente && $result_actualizar_telefono && $result_actualizar_residencia ) {
        // Redirigir a la página de clientes después de la actualización
        header("Location: CRUDCliente.php");
        exit();
    } else {
        echo "Error al actualizar datos: " . mysqli_error($con);
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
    <style>
        .selected {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    
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
                    <tr class="<?= isset($_GET['editar']) && $_GET['editar'] == $row['id_Cliente'] ? 'selected' : '' ?>">
                        <th><?= $row['id_Cliente'] ?></th>
                        <th><?= $row['nombre_1'] ?></th>
                        <th><?= $row['apellido_1'] ?></th>
                        <th><?= $row['fecha_nacimiento'] ?></th>
                        <th><?= $row['enfermedades'] ?></th>
                        <th><?= $row['alergias'] ?></th>
                        <th><?= $row['numero'] ?></th>
                        <th><?= $row['nombreResidencia'] ?></th>
                        <th>
                            <a href="?editar=<?= $row['id_Cliente'] ?>" class="crud-table--editar">Editar</a>
                        </th>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Sección para mostrar el formulario de edición -->
    <?php
    if (isset($_GET['editar'])) {
        $id_Cliente_editar = $_GET['editar'];
        $sql_editar = "SELECT * FROM cliente WHERE id_Cliente = '$id_Cliente_editar'";
        $result_editar = mysqli_query($con, $sql_editar);
        $cliente_editar = mysqli_fetch_assoc($result_editar);

        // Obtener datos del teléfono
        $sql_telefono = "SELECT * FROM telefono WHERE id_Cliente = '$id_Cliente_editar'";
        $result_telefono = mysqli_query($con, $sql_telefono);
        $telefono_editar = mysqli_fetch_assoc($result_telefono);

        // Obtener datos de la residencia
        $sql_residencia = "SELECT * FROM residencia WHERE id_Cliente = '$id_Cliente_editar'";
        $result_residencia = mysqli_query($con, $sql_residencia);
        $residencia_editar = mysqli_fetch_assoc($result_residencia);
    ?>
        <div>
            <h2>Editar Usuario - ID <?= $cliente_editar['id_Cliente'] ?></h2>
            <form method="post" action="">
                <input type="hidden" name="id_Cliente_editar" value="<?= $cliente_editar['id_Cliente'] ?>">
                <label for="nombre_1_editar">Nombre:</label>
                <input type="text" name="nombre_1_editar" value="<?= $cliente_editar['nombre_1'] ?>"><br>

                <label for="apellido_1_editar">Apellido:</label>
                <input type="text" name="apellido_1_editar" value="<?= $cliente_editar['apellido_1'] ?>"><br>
                
                <label for="fecha_nacimiento_editar">Fecha de nacimiento:</label>
                <input type="text" name="fecha_nacimiento_editar" value="<?= $cliente_editar['fecha_nacimiento'] ?>"><br>
                
                <label for="enfermedades_editar">Enfermedades:</label>
                <input type="text" name="enfermedades_editar" value="<?= $cliente_editar['enfermedades'] ?>"><br>
                
                <label for="alergias_editar">Alergias:</label>
                <input type="text" name="alergias_editar" value="<?= $cliente_editar['alergias'] ?>"><br>
                
                <label for="numero_editar">Número de teléfono:</label>
                <input type="text" name="numero_editar" value="<?= $telefono_editar['numero'] ?? '' ?>"><br>

                <label for="residencia_editar">Residencia:</label>
                <input type="text" name="residencia_editar" value="<?= $residencia_editar['nombreResidencia'] ?? '' ?>"><br>

                <input type="submit" name="editar" value="Guardar cambios">
            </form>
        </div>
    <?php
    }
    ?>
</body>
</html>
