<?php
require_once '../config/database.php';
require_once '../models/Producto.php';

header('Content-Type: application/json');

$database = new Database();
$db = $database->getConnection();

$producto = new Producto($db);
$stmt = $producto->getAllActive();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($productos);
?>