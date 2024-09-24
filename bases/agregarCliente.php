<?php
include('conexion.php');
$con = connection();

// Verificar la conexión exitosa antes de continuar
if (!$con) {
    die("Error en la conexión: " . mysqli_connect_error());
}

$id_Cliente = $_POST['id_Cliente'];
$nombre_1 = $_POST['nombre_1'];
$apellido_1 = $_POST['apellido_1'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$enfermedades = $_POST['enfermedades'];
$alergias = $_POST['alergias'];

// Insertar datos en la tabla cliente
$sql_Cliente = "INSERT INTO cliente (id_Cliente, nombre1, apellido1, fecha_Nacimiento, enfermedades, alergia) VALUES ('$id_Cliente','$nombre_1','$apellido_1','$fecha_nacimiento','$enfermedades', '$alergias')";
$queryCliente = mysqli_query($con, $sql_Cliente);

// Verificar si la consulta fue exitosa
if (!$queryCliente) {
    die("Error en la consulta cliente: " . mysqli_error($con));
}

// Obtener el id_Cliente recién insertado
$id_Cliente_insertado = mysqli_insert_id($con);

// Redirigir solo si todas las consultas fueron exitosas
header("Location: CRUDS.php");
exit();
?>
