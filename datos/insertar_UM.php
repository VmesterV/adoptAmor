<?php
    include("conexionbd.php");
    $sql="
    insert into moderador (M_nombre, email, pass, F_registro) 
    values 
    ('moder', 'moder@gmail.com', '12345', '2025-10-20');

    insert into usuario (U_nombre, email, pass, F_registro) 
    values 
    ('user', 'user@gmail.com', '12345', '2025-10-20');
    ";
    if (mysqli_multi_query($con, $sql)) {
        //si mysqli_multi_query tiene éxito, iteramos sobre los resultados
        do {
            //para almacenar el primer resultados
            if ($result = mysqli_store_result($con)) {
                mysqli_free_result($result);
            }
        } while (mysqli_more_results($con) && mysqli_next_result($con));
    
        echo "<br>usuario y moder insertados";
    } else {
        die("Error al insertar datos: " . mysqli_error($con));
    }
    mysqli_close($con);
?> 