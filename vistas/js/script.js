document.addEventListener("DOMContentLoaded", () => {
    
    const perros = [
        //perros
        { id: "001", nombre: "Rocky", raza: "Shiba", edad: "2 años", imagen: "https://images.pexels.com/photos/1805164/pexels-photo-1805164.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" },
        { id: "002", nombre: "Luna", raza: "Golden", edad: "3 años", imagen: "https://images.pexels.com/photos/2253275/pexels-photo-2253275.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" },
        { id: "003", nombre: "Odin", raza: "Dalmata", edad: "5 años", imagen: "https://www.purina.es/sites/default/files/styles/ttt_image_510/public/2024-02/sitesdefaultfilesstylessquare_medium_440x440public2022-09dalmatian.jpg?itok=GonE9SI9" },
        { id: "004", nombre: "Cosmo", raza: "Pug", edad: "7 años", imagen: "https://blog.dogfydiet.com/wp-content/uploads/2024/02/Perro-pug-acostado-en-mueble.jpg" },
        { id: "005", nombre: "Bruno", raza: "Doberman", edad: "3 años", imagen: "https://cdn0.uncomo.com/es/posts/0/6/1/como_alimentar_a_un_doberman_cachorro_33160_600_square.jpg" },
        { id: "006", nombre: "Kira", raza: "Bichon maltes", edad: "2 años", imagen: "https://estaticos-cdn.prensaiberica.es/clip/823f515c-8143-4044-8f13-85ea1ef58f3a_16-9-discover-aspect-ratio_default_0.jpg" }
    ];

    const gatos = [
        //gatos
        { id: "007", nombre: "Simón", raza: "Siamés", edad: "1 años", imagen: "https://images.pexels.com/photos/104827/cat-pet-animal-domestic-104827.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" },
        { id: "008", nombre: "Simba", raza: "Esfinge", edad: "5 años", imagen: "https://i.pinimg.com/736x/ef/8c/dc/ef8cdc3899137eb61f03547419b0518d.jpg" },
        { id: "009", nombre: "Sasha", raza: "Angora", edad: "3 año", imagen: "https://i.pinimg.com/originals/8e/d7/41/8ed7410285f101ba5892ff723c91fa75.jpg" },
        { id: "010", nombre: "Peluza", raza: "Persa", edad: "5 año", imagen: "https://www.zooplus.es/magazine/wp-content/uploads/2017/10/fotolia_103481419.webp" },
        { id: "011", nombre: "Nala", raza: "Bengala", edad: "6 año", imagen: "https://www.purina.es/sites/default/files/styles/ttt_image_510/public/2021-01/Bengal.1.jpg?itok=98LQ1RfI" },
        { id: "012", nombre: "Chispa", raza: "Bizco", edad: "4 año", imagen: "https://st.depositphotos.com/2836705/3618/i/450/depositphotos_36180101-stock-photo-cross-eyed-cat.jpg" }
    ];

    // --- ELEMENTOS DEL DOM ---
    const mainContent = document.getElementById('main-content');
    const navLinks = document.querySelectorAll('.page-link');
    const darkModeToggle = document.getElementById("darkModeToggle");
    const adopcionModalElement = document.getElementById('adopcionModal');
    // Inicializar el objeto Modal de Bootstrap.
    const adopcionModal = new bootstrap.Modal(adopcionModalElement);
    let count = 0; // Contador de mascotas seleccionadas (simulación de carrito)


    // -----------------------------------------------------------
    // FUNCIONES DE UTILIDAD
    // -----------------------------------------------------------
    
    // Función para crear una tarjeta de mascota
    function createPetCard(pet) {
        const card = document.createElement('div');
        card.classList.add('pet-card');
        card.innerHTML = `
            <img src="${pet.imagen}" alt="${pet.nombre}">
            <h3>${pet.nombre}</h3>
            <p><strong>Raza:</strong> ${pet.raza} | <strong>Edad:</strong> ${pet.edad}</p>
            <button class="adopt-btn" data-pet-id="${pet.id}" data-pet-name="${pet.nombre}">Adoptar</button>
        `;
        return card;
    }

    // Función para asignar eventos a los botones de Adopción (Necesaria después de cada carga AJAX)
    function attachAdoptButtonEvents() {
        const adoptButtons = document.querySelectorAll(".adopt-btn");
        const modalTitle = document.getElementById("modal-pet-name");
        const inputMascota = document.getElementById("mascotaSeleccionada");

        adoptButtons.forEach(btn => {
            btn.addEventListener("click", () => {
                const petId = btn.dataset.petId;
                const petName = btn.dataset.petName;
                
                // 1. Actualiza el nombre de la mascota y el ID en el modal
                modalTitle.textContent = petName;
                inputMascota.value = petId; // Usamos el ID de la mascota para el campo DB

                // 2. Muestra el modal usando el objeto Bootstrap
                adopcionModal.show();
                
                // 3. Incrementa el contador del carrito (simulación)
                count++;

            });
        });
    }
    
    // Función para inyectar tarjetas de mascotas después de que se carga la vista 'mascotas'
    function initializePetGrids() {
        const perrosGrid = document.getElementById('perros-grid');
        const gatosGrid = document.getElementById('gatos-grid');
        
        if (perrosGrid && gatosGrid) {
            perrosGrid.innerHTML = '';
            gatosGrid.innerHTML = '';
            
            perros.forEach(pet => perrosGrid.appendChild(createPetCard(pet)));
            gatos.forEach(pet => gatosGrid.appendChild(createPetCard(pet)));
            
            attachAdoptButtonEvents(); // Adjuntar eventos después de inyectar
        }
    }
    
    // -----------------------------------------------------------
    // LÓGICA AJAX PARA LA NAVEGACIÓN
    // -----------------------------------------------------------

    function loadContent(pageName) {
        // La URL de la vista que devuelve el fragmento HTML/PHP
        const url = `vistas/includes/${pageName}.php`;
        
        mainContent.innerHTML = '<div class="text-center my-5">Cargando...</div>'; // Feedback visual

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`No se pudo cargar la página: ${pageName}`);
                }
                return response.text(); // Devuelve el contenido como texto HTML
            })
            .then(html => {
                mainContent.innerHTML = html; // Inyecta el nuevo HTML
                
                // Si la página cargada es 'mascotas', inyectar las tarjetas de mascotas
                if (pageName === 'mascotas') {
                    initializePetGrids();
                }
                
                // Si la página cargada es 'tienda', inyectar las tarjetas de la tienda
                if (pageName === 'tienda') {
                    // El script2.js
                    if (typeof initializeTienda === 'function') {
                        initializeTienda(); 
                    } else {
                         // Fallback si el script2.js no está modularizado 
                         console.warn("La tienda requiere la recarga del script2.js o modularización.");
                    }
                }
            })
            .catch(error => {
                mainContent.innerHTML = `<div class='mensaje-error'>Error de carga: ${error.message}</div>`;
                console.error(error);
            });
    }

    // --- EVENT LISTENERS PRINCIPALES ---

    // 1. Manejo del Dark Mode
    darkModeToggle.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode");
    });
    
    // 2. Manejo de la Navegación (AJAX)
    navLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            const page = link.dataset.page;
            
            if (page) { // Solo si tiene un atributo data-page
                event.preventDefault(); // Previene la navegación por defecto
                loadContent(page);
            }
            // Si no tiene data-page (como Contacto), deja la navegación por defecto (ancla)
        });
    });

    // 3. Cargar contenido inicial ('mascotas') al cargar la página
    loadContent('mascotas');
    
    // 4. ELIMINACIÓN DE CÓDIGO INNECESARIO
    // Se ha eliminado el bloque de código del 'submit' del formulario de adopción 
    // que estaba comentado y no se usaba.
});