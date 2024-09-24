<?php
include('conexion.php');
$con = connection();

// Manejar la inserción de datos cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editar'])) {

        // Lógica de actualización
        $id_Reserva_editar = $_POST['id_Reserva_editar'];
        $estado_editar = $_POST['estado_editar'];
       
        $cita_editar = $_POST['cita_editar'];
        $cliente_editar = $_POST['cliente_editar'];
        $servicio_editar = $_POST['servicio_editar'];
      
        
        // Actualizar datos en la tabla cita
       
            $sql_actualizar_reserva = "UPDATE reserva 
                    SET Estado = '$estado_editar',   
                    id_Cita = '$cita_editar',  
                    id_Cliente = '$cliente_editar',  
                    id_Servicio = '$servicio_editar'
                    WHERE id_Reserva = '$id_Reserva_editar'";

        $result_actualizar_reserva = mysqli_query($con, $sql_actualizar_reserva);

        // Verificar si todas las consultas fueron exitosas
        if ($result_actualizar_reserva) {
            // Redirigir a la página de clientes después de la actualización
            header("Location: CRUDReserva.php");
            exit();
        } else {
            echo "Error al actualizar datos: " . mysqli_error($con);
        }

    } elseif (isset($_POST['eliminar'])) {
        // Lógica de eliminación
        $id_Reserva_eliminar = $_POST['id_Reserva_eliminar'];

        // Eliminar datos en la tabla cita
        $sql_eliminar_reserva = "DELETE FROM reserva WHERE id_Reserva = '$id_Reserva_eliminar'";
        $result_eliminar_reserva = mysqli_query($con, $sql_eliminar_reserva);

        // Verificar si la eliminación fue exitosa
        if ($result_eliminar_reserva) {
            // Redirigir a la página de clientes después de la eliminación
            header("Location: CRUDReserva.php");
            exit();
        } else {
            echo "Error al eliminar datos: " . mysqli_error($con);
        }
    } else {
        // Verificar que todos los campos obligatorios están llenos
        $required_fields = ['Estado', 'cita', 'cliente', 'servicio'];

        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                // Mostrar ventana de advertencia
                echo "<script>alert('Por favor, llene todos los campos obligatorios.');</script>";
                echo "<script>window.location.href='CRUDReserva.php';</script>";
                exit; // Detener la ejecución si faltan datos
            }
        }

        $estado = $_POST['Estado'];
        $id_Cita = $_POST['cita'];// Modificado para obtener el ID de la cita
        $id_Cliente = $_POST['cliente']; // Modificado para obtener el ID del cliente
        $id_Servicio = $_POST['servicio']; // Modificado para obtener el ID del empleado

        // Insertar en la tabla reserva
        $sql_reserva = "INSERT INTO reserva (Estado, id_Cita, id_Cliente, id_Servicio) 
                        VALUES ('$estado', '$id_Cita', '$id_Cliente', '$id_Servicio')";
        $result_reserva = mysqli_query($con, $sql_reserva);

        // Obtener el id_Cita recién insertado
        $id_Reserva_insertado_insertado = mysqli_insert_id($con);

        if (!$result_reserva) {
            die("Error al insertar datos: " . mysqli_error($con));
        }
    }
}

// Consulta para obtener los datos
$sql = "SELECT reserva.*, cita.id_Cita, reserva.Estado, cliente.id_Cliente, CONCAT(cliente.nombre_1, ' ', cliente.apellido_1) as nombre_cliente, servicio.nombre_Servicio
FROM reserva
LEFT JOIN cita ON reserva.id_Cita = cita.id_Cita
LEFT JOIN cliente ON reserva.id_Cliente = cliente.id_Cliente
LEFT JOIN servicio ON reserva.id_Servicio = servicio.id_Servicio";

$query = mysqli_query($con, $sql);


if (!$query) {
    die("Error en la consulta: " . mysqli_error($con));
}

// Consulta para obtener las citas
$sql_citas = "SELECT * FROM cita";
$query_citas = mysqli_query($con, $sql_citas);
if (!$query_citas) {
    die("Error en la consulta de citas: " . mysqli_error($con));
}

// Consulta para obtener los clientes
$sql_clientes = "SELECT * FROM cliente";
$query_clientes = mysqli_query($con, $sql_clientes);
if (!$query_clientes) {
    die("Error en la consulta de clientes: " . mysqli_error($con));
}


// Consulta para obtener los servicios
$sql_servicios = "SELECT * FROM servicio";
$query_servicios = mysqli_query($con, $sql_servicios);
if (!$query_servicios) {
    die("Error en la consulta de servicios: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Reserva</title>
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
        <h1>CRUD Reserva</h1>

        <h2>Crear reserva</h2>
        <form method="post" action="">


        <select name="cita">
            <option value="" disabled selected>Seleccionar cita</option>
            <?php while ($cita = mysqli_fetch_assoc($query_citas)): ?>
                <option value="<?= $cita['id_Cita'] ?>"><?= $cita['id_Cita'] ?></option>
            <?php endwhile; ?>
        </select>

        <select name="cliente">
            <option value="" disabled selected>Seleccionar cliente</option>
            <?php while ($cliente = mysqli_fetch_assoc($query_clientes)): ?>
                <option value="<?= $cliente['id_Cliente'] ?>"><?= $cliente['id_Cliente'] ?></option>
            <?php endwhile; ?>
        </select>

        <select name="servicio">
            <option value="" disabled selected>Seleccionar servicio</option>
            <?php while ($servicio = mysqli_fetch_assoc($query_servicios)): ?>
                <option value="<?= $servicio['id_Servicio'] ?>"><?= $servicio['id_Servicio'] ?></option>
            <?php endwhile; ?>
        </select>

            <!-- Resto de los campos -->
            
            <input type="text" name="Estado" placeholder="Estado">

    
            <input type="submit" value="Agregar reserva">
        </form>


        <div>
            <h2>Reservas registradas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Id reserva</th>
                        <th>Estado</th>
                        <th>Cita</th>
                        <th>Cliente</th>
                        <th>Servicio</th>
                        <th colspan="2">Acciones</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($query)): ?>
                        <tr>
                            <td><?= $row['id_Reserva'] ?></td>
                            <td><?= $row['Estado'] ?></td>      
                            
                            <?php
                           
                           // Obtener los nombres de cita, cliente y servicio utilizando sus IDs
                            $id_Cita = $row['id_Cita'];
                            $id_Cliente = $row['id_Cliente'];
                            $id_Servicio = $row['id_Servicio'];

                            
                            // Consulta para obtener el nombre de la cita
                            $query_id_cita = mysqli_query($con, "SELECT CONCAT(id_cita) as id_cita FROM cita WHERE id_Cita = '$id_Cita'");
                            $id_cita = mysqli_fetch_assoc($query_id_cita)['id_cita'];

                            // Consulta para obtener el nombre del cliente
                            $query_nombre_cliente = mysqli_query($con, "SELECT CONCAT(nombre_1, ' ', apellido_1) as nombre_cliente FROM cliente WHERE id_Cliente = '$id_Cliente'");
                            $nombre_cliente = mysqli_fetch_assoc($query_nombre_cliente)['nombre_cliente'];
                            
                             // Consulta para obtener el nombre del servicio
                             $query_nombre_servicio= mysqli_query($con, "SELECT CONCAT(nombre_Servicio, ' ', descripcion) as nombre_servicio FROM servicio WHERE id_Servicio = '$id_Servicio'");
                             $nombre_servicio = mysqli_fetch_assoc($query_nombre_servicio)['nombre_servicio'];
                             
                            ?>

                            <td><?= $id_cita ?></td>
                            <td><?= $nombre_cliente ?></td>
                            <td><?= $nombre_servicio ?></td>

                            <td>
                                <a href="?editar=<?= $row['id_Reserva'] ?>" class="crud-table--editar">Editar</a>
                            </td>
                            <td>
                                <form method="post" action="">
                                    <input type="hidden" name="id_Reserva_eliminar" value="<?= $row['id_Reserva'] ?>">
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
            // Obtener datos de la cita, cliente y servicio para prellenar el formulario
            $id_Reserva_editar = $_GET['editar'];
            $sql_editar = "SELECT reserva.*,reserva.Estado, cita.id_Cita, cliente.id_Cliente, CONCAT(cliente.nombre_1, ' ', cliente.apellido_1) as nombre_cliente, servicio.nombre_Servicio
            FROM reserva 
            LEFT JOIN cita ON reserva.id_Cita = cita.id_Cita
            LEFT JOIN cliente ON reserva.id_Cliente = cliente.id_Cliente
            LEFT JOIN servicio ON reserva.id_Servicio = servicio.id_Servicio
            WHERE reserva.id_Reserva = '$id_Reserva_editar'";

            $result_editar = mysqli_query($con, $sql_editar);
            $reserva_editar = mysqli_fetch_assoc($result_editar);
            ?>

            <div>
                <h2>Editar reserva - ID <?= $reserva_editar['id_Reserva'] ?></h2>
                <form method="post" action="">
                    
                    <label for="cita_editar">Cita:</label>
                    
                    <!-- Combo box con ID de cita -->
                    <select name="cita_editar">
                        <?php
                        // Obtener todas las citas
                        $query_citas = mysqli_query($con, "SELECT * FROM cita");
                        
                        // Iterar sobre las citas para crear opciones
                        while ($cita = mysqli_fetch_assoc($query_citas)) {
                            // Comprobar si el empleado es el actual del cita
                            $selected = ($cita['id_Cita'] == $reserva_editar['id_Cita']) ? 'selected' : '';
                            
                            // Imprimir la opción
                            echo "<option value='{$cita['id_Cita']}' $selected>{$cita['id_Cita']}</option>";
                        }
                        ?>
                    </select>

                    <label for="cliente_editar">Cliente:</label>
                    
                    
                    <!-- Combo box con ID de cliente -->
                    <select name="cliente_editar">
                        <?php
                        // Obtener todos los clientes
                        $query_clientes = mysqli_query($con, "SELECT * FROM cliente");
                        
                        // Iterar sobre los clientes para crear opciones
                        while ($cliente = mysqli_fetch_assoc($query_clientes)) {
                            // Comprobar si el cliente es el actual del cita
                            $selected = ($cliente['id_Cliente'] == $reserva_editar['id_Cliente']) ? 'selected' : '';
                            
                            // Imprimir la opción
                            echo "<option value='{$cliente['id_Cliente']}' $selected>{$cliente['id_Cliente']}</option>";
                        }
                        ?>
                    </select>


                    <label for="servicio_editar">Servicio:</label>
                    
                    <!-- Combo box con ID de servicio -->
                    <select name="servicio_editar">
                        <?php
                        // Obtener todos los empleados
                        $query_servicios = mysqli_query($con, "SELECT * FROM servicio");
                        
                        // Iterar sobre los empleados para crear opciones
                        while ($servicio = mysqli_fetch_assoc($query_servicios)) {
                            // Comprobar si el empleado es el actual del cita
                            $selected = ($servicio['id_Servicio'] == $reserva_editar['id_Servicio']) ? 'selected' : '';
                            
                            // Imprimir la opción
                            echo "<option value='{$servicio['id_Servicio']}' $selected>{$servicio['id_Servicio']}</option>";
                        }
                        ?>
                    </select>

                    <input type="hidden" name="id_Reserva_editar" value="<?= $reserva_editar['id_Reserva'] ?>">

                
                    <!-- Resto de los campos -->
                    
                    <label for="estado_editar">Estado:</label>
                    <input type="text" name="estado_editar" value="<?= $estado_editar['Estado'] ?? '' ?>">

                    <input type="submit" name="editar" value="Guardar cambios">
                
                
                
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
