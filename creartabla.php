<?php
    include("conexionbd.php");
    
    $sql ="
        create table usuarios(
            ID_usuario INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            U_nombre VARCHAR(30) NOT NULL,
            Pass VARCHAR(30) NOT NULL,
            Email VARCHAR(30) UNIQUE NOT NULL,
            Rol VARCHAR(30) NOT NULL,
            F_registro DATE NOT NULL   
        );
        create table mascotas(
            ID_mascota INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            nombre VARCHAR(30) NOT NULL,
            Edad INT NOT NULL,
            tipo VARCHAR(30) NOT NULL,
            ID_usuario VARCHAR(30) NOT NULL
        );
        create table adopciones(
            ID_adopcion INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            ID_mascota INT NOT NULL,
            ID_usuario INT NOT NULL,
            F_adopcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL 
        );
        create table productos(
            ID_producto INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            Nombre VARCHAR(30) NOT NULL,
            Descripcion VARCHAR(50) NOT NULL,
            Precio DECIMAL(10,2) NOT NULL,
            Stock INT NOT NULL
        );
        create table pedidos(
            ID_pedido INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            Fecha DATE NOT NULL,
            Total DECIMAL(10,2) UNIQUE NOT NULL,
            ID_usuario INT NOT NULL
        );
        create table detallepedidos(
            ID_dp INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            ID_pedido INT NOT NULL,
            ID_producto INT UNIQUE NOT NULL,
            Cantidad INT NOT NULL
        );";


if (mysqli_multi_query($con, $sql)) {
    //si mysqli_multi_query tiene éxito, iteramos sobre los resultados
    do {
        //para almacenar el primer resultados
        if ($result = mysqli_store_result($con)) {
            mysqli_free_result($result);
        }
    } while (mysqli_more_results($con) && mysqli_next_result($con));

    echo "<br>Tablas creadas exitosamente";
} else {
    die("Error en la creación de tablas: " . mysqli_error($con));
}
mysqli_close($con);