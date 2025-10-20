<?php
    include("conexionbd.php");
    $sql="
    insert into mascota (nombre, edad, tipo, raza, ID_moderador)
    values
    ('roky','2','perro','Shiva','7'),
    ('Luna','3','perro','Golden','7'),
    ('Odin','5','perro','Dalmata','7'),
    ('Cosmo','7','perro','Pug','7'),
    ('Bruno','3','perro','Dorberman','7'),
    ('kira','2','perro','Maltes','7'),
    ('Simon','1','gato','Siames','7'),
    ('Simba','5','gato','Esfinge','7'),
    ('Sasha','3','gato','Angora','7'),
    ('Pelusa','5','gato','Persa','7'),
    ('Nala','6','gato','Vengala','7'),
    ('Chispa','4','gato','Bizco','7');

    ";
    if (mysqli_multi_query($con, $sql)) {
        //si mysqli_multi_query tiene éxito, iteramos sobre los resultados
        do {
            //para almacenar el primer resultados
            if ($result = mysqli_store_result($con)) {
                mysqli_free_result($result);
            }
        } while (mysqli_more_results($con) && mysqli_next_result($con));
    
        echo "<br>datos de las mascotas insertados insertados";
    } else {
        die("Error al insertar datos de las mascotas: " . mysqli_error($con));
    }
    mysqli_close($con);
?> 