<?php
    include("conexion.php");  // Se incluye el archivo que conecta al servidor MySQL
    // Sentencia SQL para crear la base de datos
    $sql = "create database DB_adoptAmor";
    // Ejecuta la consulta para crear la base de datos
    if (mysqli_query($con,$sql)) {
        echo"<br>Base de datos creada correctamente";  // Mensaje de éxito
    }else {
        die("Error: ".mysqli_connect_error());  // Termina la ejecución si ocurre un error
    }
    mysqli_close($con);  // Cierra la conexión con MySQL

?>