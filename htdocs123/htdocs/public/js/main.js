// public/js/main.js - NAVEGACIÓN AJAX
document.addEventListener("DOMContentLoaded", function() {
    // Modo oscuro
    const darkModeToggle = document.getElementById("darkModeToggle");
    if (darkModeToggle) {
        const darkMode = localStorage.getItem('darkMode') === 'true';
        if (darkMode) {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
            darkModeToggle.textContent = '☀️';
        }
        
        darkModeToggle.addEventListener("click", function() {
            const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
            document.documentElement.setAttribute('data-bs-theme', isDark ? 'light' : 'dark');
            darkModeToggle.textContent = isDark ? '🌙' : '☀️';
            localStorage.setItem('darkMode', !isDark);
        });
    }

    // Navegación AJAX
    document.querySelectorAll('.page-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const page = this.dataset.page;
            
            if (page === 'footer') {
                document.getElementById('contacto')?.scrollIntoView({behavior: 'smooth'});
                return;
            }
            
            loadContent(page);
        });
    });

    // Carrito
    document.getElementById('carrito-btn')?.addEventListener('click', function() {
        new bootstrap.Offcanvas(document.getElementById('carritoOffcanvas')).show();
    });

    // Inicializar página actual
    if (document.getElementById('perros-grid')) initializeMascotas();
    if (document.getElementById('lista-productos')) initializeTienda();
});

// Cargar contenido vía AJAX
async function loadContent(page) {
    const mainContent = document.getElementById('main-content');
    if (!mainContent) return;
    
    mainContent.innerHTML = `
        <div class="text-center my-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
    `;

    try {
        const response = await fetch(`/views/${page}/index.php`);
        if (!response.ok) throw new Error('Error cargando contenido');
        
        const html = await response.text();
        mainContent.innerHTML = html;
        
        // Inicializar módulos
        if (page === 'mascotas' && typeof initializeMascotas === 'function') {
            initializeMascotas();
        } else if (page === 'tienda' && typeof initializeTienda === 'function') {
            initializeTienda();
        }
        
        // Actualizar URL
        history.pushState({}, '', `/?page=${page}`);
        
    } catch (error) {
        mainContent.innerHTML = '<div class="alert alert-danger">Error cargando contenido</div>';
    }
}

// Modal adopción
function mostrarModalAdopcion() {
    new bootstrap.Modal(document.getElementById('adopcionModal')).show();
}