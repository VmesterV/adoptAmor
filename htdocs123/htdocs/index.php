<?php
// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configuración BD
require_once 'config/database.php';
$database = new Database();
$db = $database->getConnection();

// Cargar clases
function cargarClase($clase) {
    if (file_exists("models/$clase.php")) require_once "models/$clase.php";
}
spl_autoload_register('cargarClase');

// APIs
if (isset($_GET['api'])) {
    header('Content-Type: application/json');
    
    switch ($_GET['api']) {
        case 'mascotas':
            $mascota = new Mascota($db);
            $tipo = $_GET['tipo'] ?? '';
            if (in_array($tipo, ['perro', 'gato'])) {
                $stmt = $mascota->getByTipo($tipo);
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            exit;
            
        case 'productos':
            $producto = new Producto($db);
            $stmt = $producto->getAllActive();
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            exit;
            
        case 'adopciones':
            if ($_POST) {
                $adopcion = new Adopcion($db);
                $adopcion->id_mascota = $_POST['mascota_id'];
                $adopcion->dni_solicitante = $_POST['dni'];
                $adopcion->nombre_solicitante = $_POST['nombre'];
                $adopcion->id_usuario = $_SESSION['usuario_id'] ?? null;
                
                if ($adopcion->create()) {
                    echo json_encode(['success' => true, 'message' => 'Solicitud enviada correctamente']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al enviar solicitud']);
                }
            }
            exit;
            
        case 'nueva-mascota':
            if ($_POST) {
                $mascota = new Mascota($db);
                $mascota->nombre = $_POST['nombre'];
                $mascota->raza = $_POST['raza'];
                $mascota->edad = $_POST['edad'];
                $mascota->imagen = $_POST['imagen'] ?: 'https://placehold.co/400x400/f0f0f0/ccc?text=Sin+Foto';
                $mascota->tipo = $_POST['tipo'];
                
                if ($mascota->create()) {
                    echo json_encode(['success' => true, 'message' => 'Mascota agregada correctamente']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al agregar mascota']);
                }
            }
            exit;
            
        case 'nuevo-producto':
            if ($_POST) {
                $producto = new Producto($db);
                $producto->nombre = $_POST['nombre'];
                $producto->descripcion = $_POST['descripcion'];
                $producto->precio = $_POST['precio'];
                $producto->imagen = $_POST['imagen'] ?: 'https://placehold.co/300x300/fefaf6/3d405b?text=Sin+Imagen';
                $producto->stock = $_POST['stock'];
                
                if ($producto->create()) {
                    echo json_encode(['success' => true, 'message' => 'Producto agregado correctamente']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al agregar producto']);
                }
            }
            exit;
    }
}

// Procesar login
if (isset($_POST['auth_action']) && $_POST['auth_action'] === 'login') {
    header('Content-Type: application/json');
    
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Email y contraseña requeridos']);
        exit;
    }
    
    try {
        $usuario = new Usuario($db);
        $userData = $usuario->getByEmail($email);
        
        if ($userData && password_verify($password, $userData['pass'])) {
            $_SESSION['usuario_id'] = $userData['ID_usuario'];
            $_SESSION['usuario_nombre'] = $userData['U_nombre'];
            $_SESSION['usuario_rol'] = $userData['rol'];
            
            echo json_encode([
                'success' => true, 
                'message' => 'Login exitoso',
                'redirect' => '/'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error del servidor']);
    }
    exit;
}

// Procesar registro
if (isset($_POST['auth_action']) && $_POST['auth_action'] === 'register') {
    header('Content-Type: application/json');
    
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmar_password = $_POST['confirmar_password'] ?? '';
    
    // Validaciones
    if (empty($nombre) || empty($email) || empty($password) || empty($confirmar_password)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son requeridos']);
        exit;
    }
    
    if ($password !== $confirmar_password) {
        echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden']);
        exit;
    }
    
    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres']);
        exit;
    }
    
    try {
        $usuario = new Usuario($db);
        $usuario->nombre = $nombre;
        $usuario->email = $email;
        $usuario->password = $password;
        
        if ($usuario->create()) {
            echo json_encode(['success' => true, 'message' => 'Cuenta creada exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear cuenta']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()]);
    }
    exit;
}

// Páginas de autenticación (completas)
if (isset($_GET['auth'])) {
    switch ($_GET['auth']) {
        case 'login':
            include 'views/includes/head.php';
            include 'views/auth/login.php';
            include 'views/includes/scripts.php';
            exit;
        case 'register':
            include 'views/includes/head.php';
            include 'views/auth/register.php';
            include 'views/includes/scripts.php';
            exit;
        case 'recover':
            include 'views/includes/head.php';
            include 'views/auth/recover.php';
            include 'views/includes/scripts.php';
            exit;
        case 'logout':
            session_destroy();
            header('Location: /');
            exit;
    }
}

// Página principal con AJAX
include 'views/includes/head.php';
include 'views/includes/header.php';
echo '<main class="container mt-4" id="main-content">';
include 'views/mascotas/index.php'; // Contenido inicial
echo '</main>';
include 'views/includes/footer.php';
include 'views/includes/scripts.php';
?>