<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú PHP</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f4f4f4; /* Agregamos un color de fondo */
        }

        #container {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Agregamos una sombra */
            padding: 20px;
            text-align: center;
            width: 60%; /* Ajustamos el ancho del contenedor */
            border-radius: 10px; /* Agregamos bordes redondeados */
            background-color: white; /* Color de fondo del contenedor */
        }

        nav {
            overflow: hidden;
            border-radius: 10px; /* Redondeamos las esquinas del menú */
            margin-top: 20px; /* Añadimos espacio entre el encabezado y el menú */
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        li {
            display: block; /* Cambiamos a bloque para que cada opción esté debajo de la otra */
            margin-bottom: 10px; /* Añadimos espacio entre cada opción */
        }

        a {
            text-decoration: none;
            color: black; /* Cambiamos el color del texto a negro */
            font-weight: bold;
            display: block;
            padding: 10px 20px;
            transition: font-size 0.3s; /* Agregamos una transición de tamaño de fuente */
            border-radius: 5px; /* Agregamos bordes redondeados a las opciones */
        }

        a:hover {
            font-size: 1.2em; /* Hacemos que el texto sea un 20% más grande al pasar el mouse */
        }
    </style>
</head>
<body>

<!-- Añadimos un color gris claro al fondo del cuerpo -->
<div style="background-color: #ececec; width: 100%; height: 100vh; display: flex; justify-content: center; align-items: center;">
    <div id="container">
        <h1>Bienvenid@</h1>
        
        <nav>
            <ul>
                <li><a href="modelo_relacional.php">Modelo Relacional</a></li>
                <li><a href="vista_base_de_datos.php">Vista Base de Datos</a></li>
                <li><a href="CRUDCliente.php">CRUD Cliente</a></li>
                <li><a href="CRUDEmpleado.php">CRUD Empleado</a></li>
                <li><a href="CRUDCita.php">CRUD Cita</a></li>
                <li><a href="CRUDReserva.php">CRUD Reserva</a></li>
                <li><a href="consultas.php">Consultas</a></li>
            </ul>
        </nav>
    </div>
</div>

</body>
</html>
