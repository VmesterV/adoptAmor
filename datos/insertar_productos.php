<?php
    include("conexionbd.php");
    $sql="
    insert into producto (nombre, descripcion, precio, stock, esta_activo, ID_moderador)
    values
    ('juguete para perros','pelota resistente','25.00','10','1','7'),
    ('collar ajustable','Collar de nylon','15.50','10','1','7'),
    ('cama para mascotas','Cama acolchada de algondon suave','80.00','10','1','7'),
    ('Comedero doble','Compartimento para agua y comida','35.90','10','1','7'),
    ('Rascador para gato','Rascador de sisal','60.00','10','1','7'),
    ('Arnes reflectante','Seguridad nocturna','45.00','10','1','7'),
    ('Shampoo para perros','Cuida el pelaje','22.00','10','1','7'),
    ('Trasnportadora','Caja transportadora ventilada','110.00','10','1','7'),
    ('Ropa de gato','Ropa para tu michi','50.00','10','1','7'),
    ('Ropa de perro','Lo mejor de lo mejor','60.00','10','1','7');
    ";
    if (mysqli_multi_query($con, $sql)) {
        //si mysqli_multi_query tiene éxito, iteramos sobre los resultados
        do {
            //para almacenar el primer resultados
            if ($result = mysqli_store_result($con)) {
                mysqli_free_result($result);
            }
        } while (mysqli_more_results($con) && mysqli_next_result($con));
    
        echo "<br>datos de los productos insertados";
    } else {
        die("Error al insertar productos: " . mysqli_error($con));
    }
    mysqli_close($con);
?> 