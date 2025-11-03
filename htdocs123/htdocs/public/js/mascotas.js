// public/js/mascotas.js - CON FILTROS
let todasLasMascotas = [];
let filtroActual = 'gato'; // Por defecto gatos

async function initializeMascotas() {
    await cargarTodasLasMascotas();
    configurarFiltros();
    aplicarFiltro(filtroActual);
    agregarTarjetaNuevaMascota();
}

async function cargarTodasLasMascotas() {
    const mascotasGrid = document.getElementById("mascotas-grid");
    if (!mascotasGrid) return;

    try {
        // Cargar perros
        const responsePerros = await fetch('/?api=mascotas&tipo=perro');
        const perros = await responsePerros.json();
        
        // Cargar gatos
        const responseGatos = await fetch('/?api=mascotas&tipo=gato');
        const gatos = await responseGatos.json();
        
        todasLasMascotas = [
            ...perros.map(p => ({ ...p, tipo: 'perro' })),
            ...gatos.map(p => ({ ...p, tipo: 'gato' }))
        ];

    } catch (error) {
        console.error("Error cargando mascotas:", error);
        mascotasGrid.innerHTML = '<div class="col-12"><div class="alert alert-danger">Error cargando mascotas</div></div>';
    }
}

function configurarFiltros() {
    document.querySelectorAll('[data-filter]').forEach(btn => {
        btn.addEventListener('click', function() {
            // Remover clase active de todos los botones
            document.querySelectorAll('[data-filter]').forEach(b => {
                b.classList.remove('active');
            });
            
            // Agregar active al botón clickeado
            this.classList.add('active');
            
            // Aplicar filtro
            const filtro = this.dataset.filter;
            aplicarFiltro(filtro);
        });
    });
}

function aplicarFiltro(filtro) {
    filtroActual = filtro;
    const mascotasGrid = document.getElementById("mascotas-grid");
    
    if (!mascotasGrid) return;
    
    let mascotasFiltradas = [];
    
    switch (filtro) {
        case 'perro':
            mascotasFiltradas = todasLasMascotas.filter(m => m.tipo === 'perro');
            break;
        case 'gato':
            mascotasFiltradas = todasLasMascotas.filter(m => m.tipo === 'gato');
            break;
        case 'todos':
            mascotasFiltradas = todasLasMascotas;
            break;
    }
    
    renderMascotas(mascotasFiltradas);
}

function renderMascotas(mascotas) {
    const mascotasGrid = document.getElementById("mascotas-grid");
    if (!mascotasGrid) return;
    
    mascotasGrid.innerHTML = '';
    
    if (mascotas.length === 0) {
        mascotasGrid.innerHTML = `
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <i class="fas fa-paw fa-2x mb-3"></i>
                    <h5>No hay mascotas disponibles</h5>
                    <p class="mb-0">No encontramos mascotas con los filtros seleccionados.</p>
                </div>
            </div>
        `;
        return;
    }
    
    mascotas.forEach(mascota => {
        mascotasGrid.appendChild(createPetCard(mascota));
    });
    
    attachAdoptButtonEvents();
    
    // Agregar tarjeta de nueva mascota si es el filtro correspondiente
    if (filtroActual !== 'todos') {
        agregarTarjetaNuevaMascotaIndividual();
    }
}

function createPetCard(pet) {
    const col = document.createElement('div');
    col.className = 'col';
    col.innerHTML = `
        <div class="card h-100 shadow-sm">
            <img src="${pet.imagen}" class="card-img-top" alt="${pet.nombre}" 
                 onerror="this.src='https://placehold.co/400x400/f0f0f0/ccc?text=Sin+Foto'">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title">${pet.nombre}</h5>
                    <span class="badge bg-${pet.tipo === 'perro' ? 'primary' : 'success'}">
                        ${pet.tipo === 'perro' ? '🐶' : '🐱'}
                    </span>
                </div>
                <p class="card-text text-muted small">
                    <strong>Raza:</strong> ${pet.raza}<br>
                    <strong>Edad:</strong> ${pet.edad}
                </p>
                <button class="btn btn-danger mt-auto adopt-btn w-100" 
                        data-pet-id="${pet.id}" data-pet-name="${pet.nombre}">
                    🐾 Adoptar
                </button>
            </div>
        </div>
    `;
    return col;
}

function attachAdoptButtonEvents() {
    document.querySelectorAll(".adopt-btn").forEach(btn => {
        btn.addEventListener("click", function() {
            document.getElementById("modal-pet-name").textContent = this.dataset.petName;
            document.getElementById("mascotaSeleccionada").value = this.dataset.petId;
            mostrarModalAdopcion();
        });
    });
}

// Tarjeta para agregar nueva mascota (solo en filtros individuales)
function agregarTarjetaNuevaMascotaIndividual() {
    if (filtroActual === 'todos') return;
    
    const mascotasGrid = document.getElementById("mascotas-grid");
    if (mascotasGrid) {
        // Verificar si ya existe la tarjeta de agregar
        const tarjetaExistente = mascotasGrid.querySelector('.card.border-dashed');
        if (!tarjetaExistente) {
            mascotasGrid.appendChild(createNuevaMascotaCard(filtroActual));
        }
    }
}

function agregarTarjetaNuevaMascota() {
    // Solo se usa para la carga inicial, ahora usamos la individual
}

function createNuevaMascotaCard(tipo) {
    const col = document.createElement('div');
    col.className = 'col';
    col.innerHTML = `
        <div class="card h-100 shadow-sm border-dashed">
            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                <i class="fas fa-plus-circle fa-3x text-muted mb-3"></i>
                <h5 class="card-title">Agregar ${tipo === 'perro' ? 'Perro' : 'Gato'}</h5>
                <p class="card-text text-muted small">Haz clic para agregar una nueva mascota</p>
                <button class="btn btn-outline-primary mt-2" onclick="mostrarFormularioMascota('${tipo}')">
                    Agregar
                </button>
            </div>
        </div>
    `;
    return col;
}

// Resto del código permanece igual (mostrarFormularioMascota, etc.)
// ... (código existente de formularios y adopción)