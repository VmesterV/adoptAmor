// navigation.js
// --- LÓGICA AJAX PARA NAVEGACIÓN ---

function loadContent(pageName, mainContent, initializePetGrids) {
    const url = `vistas/includes/${pageName}.php`;
    mainContent.innerHTML = '<div class="text-center my-5">Cargando...</div>';

    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error(`No se pudo cargar la página: ${pageName}`);
            return response.text();
        })
        .then(html => {
            mainContent.innerHTML = html;

            if (pageName === 'mascotas') initializePetGrids();

            if (pageName === 'tienda' && typeof initializeTienda === 'function') {
                initializeTienda();
            }
        })
        .catch(error => {
            mainContent.innerHTML = `<div class='mensaje-error'>Error de carga: ${error.message}</div>`;
            console.error(error);
        });
}

