<?php
require_once '../config/database.php';
require_once '../models/Mascota.php';
require_once '../models/Adopcion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$database = new Database();
$db = $database->getConnection();

$datos = json_decode(file_get_contents("php://input"), true);

if (!$datos || !isset($datos['mascota_id']) || !isset($datos['dni']) || !isset($datos['nombre'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

try {
    $mascotaModel = new Mascota($db);
    $adopcionModel = new Adopcion($db);
    
    // Verificar mascota
    $mascota = $mascotaModel->getById($datos['mascota_id']);
    if (!$mascota) {
        echo json_encode(['success' => false, 'message' => 'Mascota no encontrada']);
        exit;
    }
    
    // Obtener usuario (si existe sesión)
    session_start();
    $id_usuario = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;
    
    // Crear adopción
    $adopcionModel->id_mascota = $datos['mascota_id'];
    $adopcionModel->id_usuario = $id_usuario;
    $adopcionModel->dni_solicitante = $datos['dni'];
    $adopcionModel->nombre_solicitante = $datos['nombre'];
    
    if ($adopcionModel->create()) {
        echo json_encode([
            'success' => true,
            'message' => '¡Solicitud de adopción enviada con éxito! Te contactaremos pronto.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al procesar la solicitud'
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor: ' . $e->getMessage()
    ]);
}
?>