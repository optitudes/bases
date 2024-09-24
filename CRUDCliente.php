<?php
include('conexion.php');
$con = connection();

// Manejar la inserción de datos cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editar'])) {

        // Lógica de actualización
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

        if ($result_verificar_telefono !== false) {
            // Verificar si ya tiene un número de teléfono relacionado
            if (mysqli_num_rows($result_verificar_telefono) > 0) {
                // Si ya tiene un número de teléfono, actualizarlo
                $sql_actualizar_telefono = "UPDATE telefono
                                             SET numero = '$numero_editar'
                                             WHERE id_Cliente = '$id_Cliente_editar'";
                $result_actualizar_telefono = mysqli_query($con, $sql_actualizar_telefono);

                // Verificar si la actualización fue exitosa
                if (!$result_actualizar_telefono) {
                    echo "Error al actualizar el número de teléfono: " . mysqli_error($con);
                }
            } else {
                // Si no tiene un número de teléfono, entonces insertarlo
                $sql_insertar_telefono = "INSERT INTO telefono (id_Cliente, numero) VALUES ('$id_Cliente_editar', '$numero_editar')";
                $result_insertar_telefono = mysqli_query($con, $sql_insertar_telefono);

                // Verificar si la inserción fue exitosa
                if (!$result_insertar_telefono) {
                    echo "Error al insertar el número de teléfono: " . mysqli_error($con);
                }
            }
        } else {
            echo "Error en la consulta de verificación de teléfono: " . mysqli_error($con);
        }

        // Actualizar datos en la tabla residencia
        $sql_actualizar_residencia = "UPDATE residencia
                                       SET nombreResidencia = '$residencia_editar'
                                       WHERE id_Cliente = '$id_Cliente_editar'";
        $result_actualizar_residencia = mysqli_query($con, $sql_actualizar_residencia);

        // Verificar si el usuario tiene una residencia relacionada
        $sql_verificar_residencia = "SELECT * FROM residencia WHERE id_Cliente = '$id_Cliente_editar'";
        $result_verificar_residencia = mysqli_query($con, $sql_verificar_residencia);

        if ($result_verificar_residencia !== false) {
            // Verificar si ya tiene una residencia relacionada
            if (mysqli_num_rows($result_verificar_residencia) > 0) {
                // Si ya tiene una residencia, actualizarla
                $sql_actualizar_residencia = "UPDATE residencia
                                              SET nombreResidencia = '$residencia_editar'
                                              WHERE id_Cliente = '$id_Cliente_editar'";
                $result_actualizar_residencia = mysqli_query($con, $sql_actualizar_residencia);

                // Verificar si la actualización fue exitosa
                if (!$result_actualizar_residencia) {
                    echo "Error al actualizar la residencia: " . mysqli_error($con);
                }
            } else {
                // Si no tiene una residencia, entonces insertarla
                $sql_insertar_residencia = "INSERT INTO residencia (id_Cliente, nombreResidencia) VALUES ('$id_Cliente_editar', '$residencia_editar')";
                $result_insertar_residencia = mysqli_query($con, $sql_insertar_residencia);

                // Verificar si la inserción fue exitosa
                if (!$result_insertar_residencia) {
                    echo "Error al insertar la residencia: " . mysqli_error($con);
                }
            }
        } else {
            echo "Error en la consulta de verificación de residencia: " . mysqli_error($con);
        }

        // Verificar si todas las consultas fueron exitosas
        if ($result_actualizar_cliente && $result_actualizar_telefono && $result_actualizar_residencia) {
            // Redirigir a la página de clientes después de la actualización
            header("Location: CRUDCliente.php");
            exit();
        } else {
            echo "Error al actualizar datos: " . mysqli_error($con);
        }
    } elseif (isset($_POST['eliminar'])) {
        // Lógica de eliminación
        $id_Cliente_eliminar = $_POST['id_Cliente_eliminar'];

        // Eliminar datos de la tabla cliente
        $sql_eliminar_cliente = "DELETE FROM cliente WHERE id_Cliente = '$id_Cliente_eliminar'";
        $result_eliminar_cliente = mysqli_query($con, $sql_eliminar_cliente);

        // Eliminar datos de la tabla telefono
        $sql_eliminar_telefono = "DELETE FROM telefono WHERE id_Cliente = '$id_Cliente_eliminar'";
        $result_eliminar_telefono = mysqli_query($con, $sql_eliminar_telefono);

        // Eliminar datos de la tabla residencia
        $sql_eliminar_residencia = "DELETE FROM residencia WHERE id_Cliente = '$id_Cliente_eliminar'";
        $result_eliminar_residencia = mysqli_query($con, $sql_eliminar_residencia);

        // Verificar si la eliminación fue exitosa
        if ($result_eliminar_cliente && $result_eliminar_telefono && $result_eliminar_residencia) {
            // Redirigir a la página de clientes después de la eliminación
            header("Location: CRUDCliente.php");
            exit();
        } else {
            echo "Error al eliminar datos: " . mysqli_error($con);
        }
    } else {
          // Verificar que todos los campos obligatorios están llenos
    $required_fields = ['id_Cliente', 'nombre_1', 'apellido_1', 'fecha_nacimiento', 'enfermedades', 'alergias'];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            // Mostrar ventana de advertencia
            echo "<script>alert('Por favor, llene todos los campos obligatorios.');</script>";
            echo "<script>window.location.href='CRUDCliente.php';</script>";
            exit; // Detener la ejecución si faltan datos
        }
    }
        // Lógica de inserción (la parte que maneja el formulario de agregar cliente)
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
    <title>CRUD CLIENTE</title>
    <link rel="stylesheet" href="./CSS/style.css">
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
    <h1>CRUD Cliente</h1>

    <h2>Crear clientes</h2>
        <form method="post" action="">
            <input type="text" name="id_Cliente" placeholder="Identificación">
            <input type="text" name="nombre_1" placeholder="Nombre">
            <input type="text" name="apellido_1" placeholder="Apellido">
            <input type="text" name="fecha_nacimiento" placeholder="Fecha de nacimiento">
            <input type="text" name="enfermedades" placeholder="Enfermedades">
            <input type="text" name="alergias" placeholder="Alergias">
            
            <input type="submit" value="Agregar cliente">
        </form>

        <div>
        <h2>Clientes registrados</h2>
        <table border="1">
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
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <td><?= $row['id_Cliente'] ?></td>
                        <td><?= $row['nombre_1'] ?></td>
                        <td><?= $row['apellido_1'] ?></td>
                        <td><?= $row['fecha_nacimiento'] ?></td>
                        <td><?= $row['enfermedades'] ?></td>
                        <td><?= $row['alergias'] ?></td>
                        <td><?= $row['numero'] ?></td>
                        <td><?= $row['nombreResidencia'] ?></td>
                        <td>
                            <a href="?editar=<?= $row['id_Cliente'] ?>" class="crud-table--editar">Editar</a>
                        </td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="id_Cliente_eliminar" value="<?= $row['id_Cliente'] ?>">
                                <input type="submit" name="eliminar" value="Eliminar">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
                </div>
    
    <!-- Formulario de edición -->
    <?php if (isset($_GET['editar'])): ?>
        <?php
        // Obtener datos del cliente, teléfono y residencia para prellenar el formulario
        $id_Cliente_editar = $_GET['editar'];
        $sql_editar = "SELECT cliente.*, telefono.numero, residencia.nombreResidencia
                       FROM cliente
                       LEFT JOIN telefono ON cliente.id_Cliente = telefono.id_Cliente
                       LEFT JOIN residencia ON cliente.id_Cliente = residencia.id_Cliente
                       WHERE cliente.id_Cliente = '$id_Cliente_editar'";
        $result_editar = mysqli_query($con, $sql_editar);
        $cliente_editar = mysqli_fetch_assoc($result_editar);
        ?>
        <div>
            <h2>Editar Usuario - ID <?= $cliente_editar['id_Cliente'] ?></h2>
            <form method="post" action="">
                <input type="hidden" name="id_Cliente_editar" value="<?= $cliente_editar['id_Cliente'] ?>">
                <label for="nombre_1_editar">Nombre:</label>
                <input type="text" name="nombre_1_editar" value="<?= $cliente_editar['nombre_1'] ?>">

                <label for="apellido_1_editar">Apellido:</label>
                <input type="text" name="apellido_1_editar" value="<?= $cliente_editar['apellido_1'] ?>">
                
                <label for="fecha_nacimiento_editar">Fecha de nacimiento:</label>
                <input type="text" name="fecha_nacimiento_editar" value="<?= $cliente_editar['fecha_nacimiento'] ?>">
                
                <label for="enfermedades_editar">Enfermedades:</label>
                <input type="text" name="enfermedades_editar" value="<?= $cliente_editar['enfermedades'] ?>">
                
                <label for="alergias_editar">Alergias:</label>
                <input type="text" name="alergias_editar" value="<?= $cliente_editar['alergias'] ?>">
                
                <label for="numero_editar">Número de teléfono:</label>
                <input type="text" name="numero_editar" value="<?= $cliente_editar['numero'] ?? '' ?>">

                <label for="residencia_editar">Residencia:</label>
                <input type="text" name="residencia_editar" value="<?= $cliente_editar['nombreResidencia'] ?? '' ?>">

                <input type="submit" name="editar" value="Guardar cambios">
            </form>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>
