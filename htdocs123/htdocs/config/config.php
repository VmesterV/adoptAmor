<?php
// Configuración general de la aplicación
define('APP_NAME', 'AdoptaAmor');
define('APP_VERSION', '1.0.0');
define('APP_DEBUG', true);

// Configuración de rutas
define('BASE_URL', 'http://localhost/tu_proyecto'); // Cambiar según tu entorno

// Configuración de sesión
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Cambiar a 1 en producción con HTTPS

// Zona horaria
date_default_timezone_set('America/Lima');
?>