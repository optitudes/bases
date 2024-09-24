<?php
include('conexion.php');
$con = connection();

// Manejar la inserción de datos cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editar'])) {
        // Lógica de actualización
        $id_Empleado_editar = $_POST['id_Empleado_editar'];
        $nombre_1_editar = $_POST['nombre_1_editar'];
        $nombre_2_editar = $_POST['nombre_2_editar'];
        $apellido_1_editar = $_POST['apellido_1_editar'];
        $apellido_2_editar = $_POST['apellido_2_editar'];
        $correo_electronico_editar = $_POST['correo_electronico_editar'];
        $salario_editar = $_POST['salario_editar'];
        $numero_editar = $_POST['numero_editar'];
        $residencia_editar = $_POST['residencia_editar'];
        $cargo_editar = $_POST['cargo_editar'];

        // Actualizar datos en la tabla empleado
        $sql_actualizar_empleado = "UPDATE empleado
                                   SET nombre_1 = '$nombre_1_editar',
                                        nombre_2 = '$nombre_2_editar',
                                       apellido_1 = '$apellido_1_editar',
                                       apellido_2 = '$apellido_2_editar',
                                       correo_electronico = '$correo_electronico_editar',
                                       salario = '$salario_editar',
                                       id_Cargo = '$cargo_editar'
                                   WHERE id_Empleado = '$id_Empleado_editar'";
        $result_actualizar_empleado = mysqli_query($con, $sql_actualizar_empleado);

        // Actualizar datos en la tabla telefono
        $sql_actualizar_telefono = "UPDATE telefono
                                     SET numero = '$numero_editar'
                                     WHERE id_Empleado = '$id_Empleado_editar'";
        $result_actualizar_telefono = mysqli_query($con, $sql_actualizar_telefono);

        // Verificar si el usuario tiene un número de teléfono relacionado
        $sql_verificar_telefono = "SELECT * FROM telefono WHERE id_Empleado = '$id_Empleado_editar'";
        $result_verificar_telefono = mysqli_query($con, $sql_verificar_telefono);

        if ($result_verificar_telefono !== false) {
            // Verificar si ya tiene un número de teléfono relacionado
            if (mysqli_num_rows($result_verificar_telefono) > 0) {
                // Si ya tiene un número de teléfono, actualizarlo
                $sql_actualizar_telefono = "UPDATE telefono
                                             SET numero = '$numero_editar'
                                             WHERE id_Empleado = '$id_Empleado_editar'";
                $result_actualizar_telefono = mysqli_query($con, $sql_actualizar_telefono);

                // Verificar si la actualización fue exitosa
                if (!$result_actualizar_telefono) {
                    echo "Error al actualizar el número de teléfono: " . mysqli_error($con);
                }
            } else {
                // Si no tiene un número de teléfono, entonces insertarlo
                $sql_insertar_telefono = "INSERT INTO telefono (id_Empleado, numero) VALUES ('$id_Empleado_editar', '$numero_editar')";
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
                                       WHERE id_Empleado = '$id_Empleado_editar'";
        $result_actualizar_residencia = mysqli_query($con, $sql_actualizar_residencia);

        // Verificar si el usuario tiene una residencia relacionada
        $sql_verificar_residencia = "SELECT * FROM residencia WHERE id_Empleado = '$id_Empleado_editar'";
        $result_verificar_residencia = mysqli_query($con, $sql_verificar_residencia);

        if ($result_verificar_residencia !== false) {
            // Verificar si ya tiene una residencia relacionada
            if (mysqli_num_rows($result_verificar_residencia) > 0) {
                // Si ya tiene una residencia, actualizarla
                $sql_actualizar_residencia = "UPDATE residencia
                                              SET nombreResidencia = '$residencia_editar'
                                              WHERE id_Empleado = '$id_Empleado_editar'";
                $result_actualizar_residencia = mysqli_query($con, $sql_actualizar_residencia);

                // Verificar si la actualización fue exitosa
                if (!$result_actualizar_residencia) {
                    echo "Error al actualizar la residencia: " . mysqli_error($con);
                }
            } else {
                // Si no tiene una residencia, entonces insertarla
                $sql_insertar_residencia = "INSERT INTO residencia (id_Empleado, nombreResidencia) VALUES ('$id_Empleado_editar', '$residencia_editar')";
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
        if ($result_actualizar_empleado && $result_actualizar_telefono && $result_actualizar_residencia) {
            // Redirigir a la página de clientes después de la actualización
            header("Location: CRUDEmpleado.php");
            exit();
        } else {
            echo "Error al actualizar datos: " . mysqli_error($con);
        }

    } elseif (isset($_POST['eliminar'])) {
        // Lógica de eliminación
        $id_Empleado_eliminar = $_POST['id_Empleado_eliminar'];

        // Eliminar datos de la tabla empleado
        $sql_eliminar_empleado = "DELETE FROM empleado WHERE id_Empleado = '$id_Empleado_eliminar'";
        $result_eliminar_empleado = mysqli_query($con, $sql_eliminar_empleado);

        // Eliminar datos de la tabla telefono
        $sql_eliminar_telefono = "DELETE FROM telefono WHERE id_Empleado = '$id_Empleado_eliminar'";
        $result_eliminar_telefono = mysqli_query($con, $sql_eliminar_telefono);

        // Eliminar datos de la tabla residencia
        $sql_eliminar_residencia = "DELETE FROM residencia WHERE id_Empleado = '$id_Empleado_eliminar'";
        $result_eliminar_residencia = mysqli_query($con, $sql_eliminar_residencia);

        // Verificar si la eliminación fue exitosa
        if ($result_eliminar_empleado && $result_eliminar_telefono && $result_eliminar_residencia) {
            // Redirigir a la página de clientes después de la eliminación
            header("Location: CRUDEmpleado.php");
            exit();
        } else {
            echo "Error al eliminar datos: " . mysqli_error($con);
        }
    } else {
        // Verificar que todos los campos obligatorios están llenos
        $required_fields = ['id_Empleado', 'nombre_1', 'apellido_1', 'correo_electronico', 'salario', 'id_Cargo'];

        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                // Mostrar ventana de advertencia
                echo "<script>alert('Por favor, llene todos los campos obligatorios.');</script>";
                echo "<script>window.location.href='CRUDEmpleado.php';</script>";
                exit; // Detener la ejecución si faltan datos
            }
        }

        $id_Empleado_insertado = $_POST['id_Empleado'];
        $nombre_1 = $_POST['nombre_1'];
        $nombre_2 = $_POST['nombre_2'];
        $apellido_1 = $_POST['apellido_1'];
        $apellido_2 = $_POST['apellido_2'];
        $correo_electronico = $_POST['correo_electronico'];
        $salario = $_POST['salario'];
        $id_Cargo = $_POST['id_Cargo'];

        // Insertar en la tabla empleado
        $sql_Empleado = "INSERT INTO Empleado (id_Empleado, nombre_1, nombre_2, apellido_1, apellido_2, correo_electronico, salario, id_Cargo) 
                        VALUES ('$id_Empleado_insertado', '$nombre_1', '$nombre_2', '$apellido_1', '$apellido_2', '$correo_electronico', '$salario', '$id_Cargo')";
        $result_Empleado = mysqli_query($con, $sql_Empleado);

        // Obtener el id_Empleado recién insertado
        $id_Empleado_insertado_insertado = mysqli_insert_id($con);

        if (!$result_Empleado) {
            die("Error al insertar datos: " . mysqli_error($con));
        }
    }
}

// Consulta para obtener los datos
$sql = "SELECT empleado.*, residencia.nombreResidencia, telefono.numero, cargo.nombreCargo
        FROM empleado
        LEFT JOIN telefono ON empleado.id_Empleado = telefono.id_Empleado
        LEFT JOIN residencia ON empleado.id_Empleado = residencia.id_Empleado
        LEFT JOIN cargo ON empleado.id_Cargo = cargo.id_Cargo";
$query = mysqli_query($con, $sql);

if (!$query) {
    die("Error en la consulta: " . mysqli_error($con));
}

// Consulta para obtener los cargos
$sql_cargos = "SELECT * FROM cargo";
$query_cargos = mysqli_query($con, $sql_cargos);
if (!$query_cargos) {
    die("Error en la consulta de cargos: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD EMPLEADO</title>
    <link rel="stylesheet" href="./CSS/style.css">
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
        left: 10px; /* Posición izquierda para el botón de menú */
    }

    #graficaButton {
        background-color: #4285f4;
        color: white;
        left: 100px; /* Posición izquierda para el botón de gráfica */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Botón de menú
        var menuButton = document.createElement('button');
        menuButton.textContent = 'Menú';
        menuButton.className = 'menuButton'; // Cambiado de id a className
        menuButton.id = 'menuButton';

        menuButton.addEventListener('click', function () {
            window.location.href = 'menu.php';
        });

        document.body.appendChild(menuButton);

        // Botón de gráfica
        var graficaButton = document.createElement('button');
        graficaButton.textContent = 'GRAFICA';
        graficaButton.className = 'menuButton'; // Cambiado de id a className
        graficaButton.id = 'graficaButton';

        graficaButton.addEventListener('click', function () {
            window.location.href = 'graficoEmpleado.php';
        });

        document.body.appendChild(graficaButton);
    });
</script>
</head>
<body>
    <div class="container">
        <h1>CRUD Empleado</h1>

        <h2>Crear empleado</h2>
        <form method="post" action="">
            <!-- Nuevo campo de cargo con combobox -->
            <select name="id_Cargo">
                <option value="" disabled selected>Seleccionar cargo</option>
                <?php while ($cargo = mysqli_fetch_assoc($query_cargos)): ?>
                    <option value="<?= $cargo['id_Cargo'] ?>"><?= $cargo['nombreCargo'] ?></option>
                <?php endwhile; ?>
            </select>
            <!-- Resto de los campos -->
            <input type="text" name="id_Empleado" placeholder="Identificación">
            <input type="text" name="nombre_1" placeholder="Primer Nombre">
            <input type="text" name="nombre_2" placeholder="Segundo Nombre">
            <input type="text" name="apellido_1" placeholder="Primer Apellido">
            <input type="text" name="apellido_2" placeholder="Segundo Apellido">
            <input type="text" name="correo_electronico" placeholder="Correo electronico">           
            <input type="text" name="salario" placeholder="Salario">
           
            <input type="submit" value="Agregar empleado">
        </form>

        <div>
            <h2>Empleados registrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th>Primer Nombre</th>
                        <th>Segundo Nombre</th>
                        <th>Primer Apellido</th>
                        <th>Segundo Apellido</th>
                        <th>Corero electronico</th>
                        <th>Salario</th>
                        <th>Número de teléfono</th>
                        <th>Residencia</th>
                        <th>Cargo</th>
                        <th colspan="2">Acciones</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($query)): ?>
                        <tr>
                            <td><?= $row['id_Empleado'] ?></td>
                            <td><?= $row['nombre_1'] ?></td>
                            <td><?= $row['nombre_2'] ?></td>
                            <td><?= $row['apellido_1'] ?></td>
                            <td><?= $row['apellido_2'] ?></td>
                            <td><?= $row['correo_electronico'] ?></td>
                            <td><?= $row['salario'] ?></td>
                            <td><?= $row['numero'] ?></td>
                            <td><?= $row['nombreResidencia'] ?></td>
                            <td><?= $row['nombreCargo'] ?></td>
                            <td>
                                <a href="?editar=<?= $row['id_Empleado'] ?>" class="crud-table--editar">Editar</a>
                            </td>
                            <td>
                                <form method="post" action="">
                                    <input type="hidden" name="id_Empleado_eliminar" value="<?= $row['id_Empleado'] ?>">
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
            $id_Empleado_editar = $_GET['editar'];
            $sql_editar = "SELECT empleado.*, residencia.nombreResidencia, telefono.numero, cargo.nombreCargo
            FROM empleado
            LEFT JOIN telefono ON empleado.id_Empleado = telefono.id_Empleado
            LEFT JOIN residencia ON empleado.id_Empleado = residencia.id_Empleado
            LEFT JOIN cargo ON empleado.id_Cargo = cargo.id_Cargo
            WHERE empleado.id_Empleado = '$id_Empleado_editar'";
            $result_editar = mysqli_query($con, $sql_editar);
            $empleado_editar = mysqli_fetch_assoc($result_editar);
            ?>
            <div>
                <h2>Editar Empleado - ID <?= $empleado_editar['id_Empleado'] ?></h2>
                <form method="post" action="">
                    <label for="cargo_editar">Cargo:</label>
                    <select name="cargo_editar">
                        <?php
                        // Obtener todos los cargos
                        $query_cargos = mysqli_query($con, "SELECT * FROM cargo");
                        
                        // Iterar sobre los cargos para crear opciones
                        while ($cargo = mysqli_fetch_assoc($query_cargos)) {
                            // Comprobar si el cargo es el actual del empleado
                            $selected = ($cargo['id_Cargo'] == $empleado_editar['id_Cargo']) ? 'selected' : '';
                            
                            // Imprimir la opción
                            echo "<option value='{$cargo['id_Cargo']}' $selected>{$cargo['nombreCargo']}</option>";
                        }
                        ?>
                    </select>

                    <input type="hidden" name="id_Empleado_editar" value="<?= $empleado_editar['id_Empleado'] ?>">
                    <!-- Resto de los campos -->
                    <label for="nombre_1_editar">Primer Nombre:</label>
                    <input type="text" name="nombre_1_editar" value="<?= $empleado_editar['nombre_1'] ?>">
                    
                    <label for="nombre_2_editar">Segundo Nombre:</label>
                    <input type="text" name="nombre_2_editar" value="<?= $empleado_editar['nombre_2'] ?>">
                    
                    <label for="apellido_1_editar">Primer Apellido:</label>
                    <input type="text" name="apellido_1_editar" value="<?= $empleado_editar['apellido_1'] ?>">
                    
                    <label for="apellido_2_editar">Segundo Apellido:</label>
                    <input type="text" name="apellido_2_editar" value="<?= $empleado_editar['apellido_2'] ?>">
                    
                    <label for="correo_electronico_editar">Correo Electronico:</label>
                    <input type="text" name="correo_electronico_editar" value="<?= $empleado_editar['correo_electronico'] ?>">
                    
                    <label for="salario_editar">Salario:</label>
                    <input type="text" name="salario_editar" value="<?= $empleado_editar['salario'] ?>">
                    
                    <label for="numero_editar">Número de teléfono:</label>
                    <input type="text" name="numero_editar" value="<?= $empleado_editar['numero'] ?? '' ?>">

                    <label for="residencia_editar">Residencia:</label>
                    <input type="text" name="residencia_editar" value="<?= $empleado_editar['nombreResidencia'] ?? '' ?>">

                    <input type="submit" name="editar" value="Guardar cambios">
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
