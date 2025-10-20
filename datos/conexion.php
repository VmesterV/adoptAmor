<?php
     // Parámetros de conexión al servidor MySQL (sin seleccionar base de datos)
    $servidor ="localhost";
    $usuario ="alexander";
    $password ="";
    
    // Se establece la conexión al servidor
    $con = mysqli_connect($servidor,$usuario,$password);
    
    // Validación de la conexión
    if(!$con){
        die("Conexion fallida: ".mysqli_connect_error());  // Termina si no se logra conectar
    }
    echo "Conexión exitosa";  // Mensaje de prueba
