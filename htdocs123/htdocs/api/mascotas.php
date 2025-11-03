<?php
require_once '../config/database.php';
require_once '../models/Mascota.php';

header('Content-Type: application/json');

$database = new Database();
$db = $database->getConnection();

$mascota = new Mascota($db);
$tipo = $_GET['tipo'] ?? '';

if (in_array($tipo, ['perro', 'gato'])) {
    $stmt = $mascota->getByTipo($tipo);
    $mascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($mascotas);
} else {
    echo json_encode(['success' => false, 'message' => 'Tipo no válido']);
}
?>