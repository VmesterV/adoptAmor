<?php
class Producto {
    private $conn;
    private $table = "producto";

    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $imagen;
    public $stock;
    public $esta_activo;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método existente
    public function getAllActive() {
        $query = "SELECT ID_producto as id, nombre, descripcion, precio, imagen, stock
                  FROM " . $this->table . " WHERE esta_activo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // NUEVO MÉTODO: Agregar producto
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                 (nombre, descripcion, precio, imagen, stock, esta_activo) 
                 VALUES (:nombre, :descripcion, :precio, :imagen, :stock, 1)";
        
        $stmt = $this->conn->prepare($query);
        
        // Limpiar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->imagen = htmlspecialchars(strip_tags($this->imagen));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        
        // Bind parameters
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':imagen', $this->imagen);
        $stmt->bindParam(':stock', $this->stock);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>