<?php
    include("conexionbd.php");
    
    $sql ="
        create table usuario(
            ID_usuario INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            U_nombre VARCHAR(30) NOT NULL,
            email VARCHAR(30) UNIQUE NOT NULL,
            pass VARCHAR(255) NOT NULL,
            F_registro DATE NOT NULL   
        );
        create table moderador(
            ID_moderador INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            M_nombre VARCHAR(30) NOT NULL,
            email VARCHAR(30) UNIQUE NOT NULL,
            pass VARCHAR(255) NOT NULL,
            F_registro DATE NOT NULL   
        );
        create table mascota(
            ID_mascota INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            nombre VARCHAR(30) NOT NULL,
            edad INT NOT NULL,
            tipo VARCHAR(30) NOT NULL,
            raza VARCHAR(30) NOT NULL,
            ID_moderador INT NOT NULL,
            FOREIGN KEY (ID_moderador) REFERENCES moderador(ID_moderador)
        );
        create table adopcion(
            ID_adopcion INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            F_adopcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            ID_mascota INT NOT NULL,
            ID_usuario INT NOT NULL,
            FOREIGN KEY (ID_usuario) REFERENCES usuario(ID_usuario),
            FOREIGN KEY (ID_mascota) REFERENCES mascota(ID_mascota)
        );
        create table producto(
            ID_producto INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL,
            descripcion TEXT NOT NULL,
            precio DECIMAL(10, 2) NOT NULL,
            stock INT NOT NULL DEFAULT 0,
            esta_activo BOOLEAN NOT NULL DEFAULT TRUE, 
            ID_moderador INT NOT NULL,
            FOREIGN KEY (ID_moderador) REFERENCES moderador(ID_moderador)
        );
        create table pedido(
            ID_pedido INT AUTO_INCREMENT NOT NULL PRIMARY KEY, 
            fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            total DECIMAL(10, 2) NOT NULL,
            D_envio VARCHAR(255) NULL,
            ID_usuario INT NOT NULL,
            FOREIGN KEY (ID_usuario) REFERENCES usuario(ID_usuario)
        );
        create table detallepedido(
            ID_detalle INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            cantidad INT NOT NULL,
            ID_pedido INT NOT NULL,
            ID_producto INT NOT NULL,
            P_unitario_captura DECIMAL(10, 2) NOT NULL,
            FOREIGN KEY (ID_pedido) REFERENCES pedido(ID_pedido) ON DELETE CASCADE, 
            FOREIGN KEY (ID_producto) REFERENCES producto(ID_producto) ON DELETE RESTRICT, 
            UNIQUE KEY uk_pedido_producto (ID_pedido, ID_producto)
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