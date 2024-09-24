<?php
include('conexion.php');
$con = connection();

// Verifica si la clave "id" está presente en el array $_GET
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    
    // Depuración: Mostrar el ID a eliminar
    echo "ID a eliminar: " . $id;

    $sql = "DELETE FROM Empleado WHERE id_Empleado='$id'";
    
    // Depuración: Mostrar la consulta SQL
    echo "SQL: " . $sql;

    $query = mysqli_query($con, $sql);

    if ($query) {
        header("Location: CRUDEmpleado.php");
        exit();
    } else {
        // Mostrar el mensaje de error específico de MySQL
        echo "Error al intentar eliminar el cliente. Error: " . mysqli_error($con);
    }
} 
?>
