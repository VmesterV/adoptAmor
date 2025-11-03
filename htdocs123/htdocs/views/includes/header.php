<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<header>
    <nav class="navbar navbar-expand-lg bg-light shadow-sm" data-bs-theme="dark">
        <div class="container"> 
            <a class="navbar-brand" href="/">
                <h1>adopt<span style="color: red;">Amor</span>🐾</h1>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContenido">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContenido">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0  ">
                    <li class="nav-item ">
                        <a class="nav-link page-link  " href="#" data-page="mascotas" >Adopción</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-link  " class="links" href="#" data-page="tienda">Tienda</a>
                    </li>
                    <li class=" nav-item">
                        <a  class="nav-link page-link" href="#contacto" data-page="footer">Contacto</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center gap-2">
                    <button id="carrito-btn" class="btn btn-outline-danger position-relative">
                        🛒
                        <span id="carrito-contador" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">0</span>
                    </button>
                    
                    <button id="darkModeToggle" class="btn-dark-mode">🌙</button>
                    
                    <?php if (!isset($_SESSION['usuario_id'])): ?>
                        <a href="/?auth=login" class="btn btn-outline-danger">Iniciar sesión</a>
                    <?php else: ?>
                        <span class="navbar-text text-white me-2">
                            ¡Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>!
                        </span>
                        <a href="/?auth=logout" class="btn btn-outline-danger btn-sm">Salir</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Carrito Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="carritoOffcanvas">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Mi Carrito</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">
        <ul id="carrito-offcanvas-lista" class="list-group list-group-flush flex-grow-1">
            <li class="list-group-item text-center text-muted">No hay productos en el carrito.</li>
        </ul>
        <div class="carrito-modal-footer mt-auto border-top pt-3">
            <h4 id="carrito-offcanvas-total" class="total-carrito text-end mb-3">Total: S/ 0.00</h4>
            <button class="btn btn-primary w-100 mb-2">Finalizar Compra</button>
            <button id="vaciar-carrito" class="btn btn-outline-danger w-100">Vaciar Carrito</button>
        </div>
    </div>
</div>