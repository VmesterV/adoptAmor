<?php
class Adopcion {
    private $conn;
    private $table = "adopciones";

    public $id;
    public $id_mascota;
    public $id_usuario;
    public $dni_solicitante;
    public $nombre_solicitante;
    public $fecha_solicitud;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET ID_mascota = :id_mascota, 
                      ID_usuario = :id_usuario,
                      dni_solicitante = :dni,
                      nombre_solicitante = :nombre,
                      fecha_solicitud = NOW(),
                      estado = 'pendiente'";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar datos
        $this->id_mascota = htmlspecialchars(strip_tags($this->id_mascota));
        $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));
        $this->dni_solicitante = htmlspecialchars(strip_tags($this->dni_solicitante));
        $this->nombre_solicitante = htmlspecialchars(strip_tags($this->nombre_solicitante));
        
        // Bind parameters
        $stmt->bindParam(':id_mascota', $this->id_mascota);
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        $stmt->bindParam(':dni', $this->dni_solicitante);
        $stmt->bindParam(':nombre', $this->nombre_solicitante);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getByMascota($id_mascota) {
        $query = "SELECT * FROM " . $this->table . " WHERE ID_mascota = :id_mascota";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_mascota', $id_mascota);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>