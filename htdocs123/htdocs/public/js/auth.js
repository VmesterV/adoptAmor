// public/js/auth.js
// ===================================
// =   ACTUALIZACIÓN: RUTAS AUTH     =
// ===================================

document.addEventListener('DOMContentLoaded', () => {
    
    const mainContent = document.getElementById('main-content');
    
    if (!mainContent) return;

    // --- FUNCIÓN PARA CARGAR VISTAS ---
    async function cargarVista(url) {
        try {
            mainContent.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"></div><p>Cargando...</p></div>';
            const response = await fetch(url);
            if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
            const html = await response.text();
            mainContent.innerHTML = html;
        } catch (error) {
            mainContent.innerHTML = '<div class="alert alert-danger">Error al cargar la vista.</div>';
        }
    }

    // --- ESCUCHADOR PARA NAVEGACIÓN ---
    mainContent.addEventListener('click', (event) => {
        const link = event.target.closest('a.nav-link');
        if (link && link.href) {
            event.preventDefault();
            const vistaUrl = link.getAttribute('href');
            cargarVista(vistaUrl);
        }
    });

    // --- FORMULARIO DE LOGIN ---
    mainContent.addEventListener('submit', async (event) => {
        if (event.target.id === 'form-login') {
            event.preventDefault(); 
            
            const formData = new FormData(event.target);
            const errorMsg = document.getElementById('form-message');

            try {
                // CAMBIO: Usar ruta del controlador
                const response = await fetch('/auth/process-login', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    window.location.href = data.redirect || '/';
                } else {
                    if (errorMsg) {
                        errorMsg.textContent = data.message;
                        errorMsg.className = 'form-message error';
                    }
                }
            } catch (error) {
                if (errorMsg) {
                    errorMsg.textContent = 'Error de red. Inténtalo de nuevo.';
                    errorMsg.className = 'form-message error';
                }
            }
        }

        // --- FORMULARIO DE REGISTRO ---
        if (event.target.id === 'form-crear') {
            event.preventDefault();

            const formData = new FormData(event.target);
            const password = formData.get('password');
            const confirmarPassword = formData.get('confirmar_password');
            const formMessage = document.getElementById('form-message');

            if (password !== confirmarPassword) {
                formMessage.textContent = 'Las contraseñas no coinciden.';
                formMessage.className = 'form-message error';
                return;
            }

            formMessage.textContent = 'Procesando...';
            formMessage.className = 'form-message';

            try {
                // CAMBIO: Usar ruta del controlador
                const response = await fetch('/auth/process-register', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    formMessage.textContent = data.message;
                    formMessage.className = 'form-message success';
                    event.target.reset();
                } else {
                    formMessage.textContent = data.message;
                    formMessage.className = 'form-message error';
                }

            } catch (error) {
                formMessage.textContent = 'Error de red. Inténtalo de nuevo.';
                formMessage.className = 'form-message error';
            }
        }
    });

    // --- Cargar vista por defecto ---
    cargarVista('/auth/login');
});