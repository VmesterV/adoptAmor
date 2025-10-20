// main.js
document.addEventListener("DOMContentLoaded", () => {
    const mainContent = document.getElementById('main-content');
    const navLinks = document.querySelectorAll('.page-link');
    const darkModeToggle = document.getElementById("darkModeToggle");
    const adopcionModalElement = document.getElementById('adopcionModal');
    const adopcionModal = new bootstrap.Modal(adopcionModalElement);
    let count = 0;

    function initializePetGrids() {
        const perrosGrid = document.getElementById('perros-grid');
        const gatosGrid = document.getElementById('gatos-grid');

        if (perrosGrid && gatosGrid) {
            perrosGrid.innerHTML = '';
            gatosGrid.innerHTML = '';
            perros.forEach(pet => perrosGrid.appendChild(createPetCard(pet)));
            gatos.forEach(pet => gatosGrid.appendChild(createPetCard(pet)));
            attachAdoptButtonEvents(adopcionModal, count);
        }
    }

    darkModeToggle.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode");
    });

    navLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            const page = link.dataset.page;
            if (page) {
                event.preventDefault();
                loadContent(page, mainContent, initializePetGrids);
            }
        });
    });

    loadContent('mascotas', mainContent, initializePetGrids);
});
