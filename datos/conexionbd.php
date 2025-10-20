<?php
    // Parámetros de conexión incluyendo la base de datos
    $servidor ="localhost";
    $usuario ="alexander";
    $password ="";
    $bd ="bdusuario";
    
    // Se establece la conexión a la base de datos específica
    $con = mysqli_connect($servidor,$usuario,$password,$bd);
    
    // Validación de la conexión
    if(!$con){
        die("Conexion fallida: ".mysqli_connect_error());
    };
    //mysqli_close($con);