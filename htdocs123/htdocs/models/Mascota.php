<?php
class Mascota {
    private $conn;
    private $table = "mascota";

    public $id;
    public $nombre;
    public $raza;
    public $edad;
    public $imagen;
    public $tipo;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método existente
    public function getByTipo($tipo) {
        $query = "SELECT ID_mascota as id, nombre, raza, CONCAT(edad, ' años') as edad, imagen 
                  FROM " . $this->table . " WHERE tipo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$tipo]);
        return $stmt;
    }

    // NUEVO MÉTODO: Agregar mascota
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                 (nombre, raza, edad, imagen, tipo) 
                 VALUES (:nombre, :raza, :edad, :imagen, :tipo)";
        
        $stmt = $this->conn->prepare($query);
        
        // Limpiar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->raza = htmlspecialchars(strip_tags($this->raza));
        $this->edad = htmlspecialchars(strip_tags($this->edad));
        $this->imagen = htmlspecialchars(strip_tags($this->imagen));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));
        
        // Bind parameters
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':raza', $this->raza);
        $stmt->bindParam(':edad', $this->edad);
        $stmt->bindParam(':imagen', $this->imagen);
        $stmt->bindParam(':tipo', $this->tipo);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>