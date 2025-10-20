<?php
//para visualizar que la base de datos esta correcta
include("datos/conexionbd.php");
$mensaje_confirmacion = '';
if (isset($_POST['registro'])) {
    $DNI = $_POST['DNI'];
    $mascota = $_POST['mascota'];

    if (isset($con)) {
        // PREVENCIÓN BÁSICA: Uso de sentencias preparadas (mejorar seguridad)
        $inserta_datos = "insert into adopciones (ID_mascota, ID_usuario) values (?, ?)";
        
        $stmt = $con->prepare($inserta_datos);
        //'ii' indica que ambos parámetros son enterosS
        $stmt->bind_param("ii", $mascota, $DNI); 

        if ($stmt->execute()) {
             $mensaje_confirmacion = "<div class='mensaje-exito'>¡Gracias por tu interés! Le contactaremos muy pronto.</div>";
        } else {
            $mensaje_confirmacion = "<div class='mensaje-error'>Error al registrar: ".mysqli_error($con)."</div>";
        }
        $stmt->close();
        mysqli_close($con);
    } else {
        $mensaje_confirmacion = "<div class='mensaje-error'>Error: No se pudo conectar a la base de datos.</div>";
    }
}
?>
<link rel="stylesheet" href="form.css">
<div class="container">
    <?php echo $mensaje_confirmacion; ?> 
</div>
<div class="modal fade" id="adopcionModal" tabindex="-1" aria-labelledby="adopcionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adopcionModalLabel">Adoptar a <span id="modal-pet-name">Mascota</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="adopcionForm" action="index.php" method="POST">
                    <div class="mb-3">
                        <label for="dniInput" class="form-label">DNI:</label>
                        <input type="number" class="form-control" name="DNI" id="dniInput" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombreInput" class="form-label">Nombre completo:</label>
                        <input type="text" class="form-control" name="nombre" id="nombreInput" required>
                    </div>
                    <div class="mb-3">
                        <label for="mascotaInput" class="form-label">Mascota seleccionada (ID):</label>
                        <input type="number" class="form-control" name="mascota" id="mascotaSeleccionada" readonly required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="registro">Enviar Solicitud</button>
                </form>
            </div>
        </div>
    </div>
</div>