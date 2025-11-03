// public/js/tienda.js - CON BUSCADOR
let carrito = [];
let todosLosProductos = [];
let productosFiltrados = [];

async function initializeTienda() {
    await cargarProductos();
    configurarBuscador();
    agregarTarjetaNuevoProducto();
}

async function cargarProductos() {
    const listaProductos = document.getElementById("lista-productos");
    if (!listaProductos) return;

    try {
        const response = await fetch('/?api=productos');
        todosLosProductos = await response.json();
        productosFiltrados = [...todosLosProductos];
        renderProductos();
        renderCarrito();
        actualizarContadorResultados();
    } catch (error) {
        console.error("Error:", error);
        listaProductos.innerHTML = '';
    }
}

function configurarBuscador() {
    const buscador = document.getElementById('buscador-productos');
    const limpiarBtn = document.getElementById('limpiar-busqueda');
    
    if (buscador) {
        buscador.addEventListener('input', function() {
            filtrarProductos(this.value);
        });
    }
    
    if (limpiarBtn) {
        limpiarBtn.addEventListener('click', function() {
            document.getElementById('buscador-productos').value = '';
            filtrarProductos('');
        });
    }
}

function filtrarProductos(terminoBusqueda) {
    if (!terminoBusqueda.trim()) {
        productosFiltrados = [...todosLosProductos];
    } else {
        const termino = terminoBusqueda.toLowerCase();
        productosFiltrados = todosLosProductos.filter(producto => 
            producto.nombre.toLowerCase().includes(termino) ||
            producto.descripcion.toLowerCase().includes(termino)
        );
    }
    
    renderProductos();
    actualizarContadorResultados();
}

function actualizarContadorResultados() {
    const contador = document.getElementById('resultados-busqueda');
    if (contador) {
        const buscador = document.getElementById('buscador-productos');
        const termino = buscador ? buscador.value : '';
        
        if (termino.trim()) {
            contador.textContent = `Encontrados ${productosFiltrados.length} producto(s) para "${termino}"`;
        } else {
            contador.textContent = `Mostrando todos los productos (${productosFiltrados.length})`;
        }
    }
}

function renderProductos() {
    const listaProductos = document.getElementById("lista-productos");
    if (!listaProductos) return;
    
    // Limpiar lista
    const tarjetasExistentes = listaProductos.querySelectorAll('.col:not(.nuevo-producto)');
    tarjetasExistentes.forEach(tarjeta => tarjeta.remove());
    
    if (productosFiltrados.length === 0) {
        listaProductos.innerHTML = `
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    <i class="fas fa-search fa-2x mb-3"></i>
                    <h5>No se encontraron productos</h5>
                    <p class="mb-0">No hay productos que coincidan con tu búsqueda.</p>
                </div>
            </div>
        `;
        return;
    }
    
    productosFiltrados.forEach(prod => {
        listaProductos.insertBefore(createProductCard(prod), listaProductos.lastElementChild);
    });
}

function createProductCard(prod) {
    const col = document.createElement('div');
    col.className = 'col';
    col.innerHTML = `
        <div class="card h-100 shadow-sm">
            <img src="${prod.imagen}" class="card-img-top" alt="${prod.nombre}" 
                 onerror="this.src='https://placehold.co/300x300/fefaf6/3d405b?text=Sin+Imagen'">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">${prod.nombre}</h5>
                <p class="card-text small flex-grow-1">${prod.descripcion}</p>
                <div class="mt-auto">
                    <p class="card-text text-secondary mb-1">Stock: ${prod.stock}</p>
                    <p class="card-text fs-5 fw-bold text-primary mb-2">S/ ${parseFloat(prod.precio).toFixed(2)}</p>
                    <button class="btn btn-primary w-100 ${prod.stock <= 0 ? 'disabled' : ''}">
                        ${prod.stock <= 0 ? 'Sin Stock' : 'Agregar 🛒'}
                    </button>
                </div>
            </div>
        </div>
    `;
    
    if (prod.stock > 0) {
        col.querySelector('button').addEventListener('click', () => agregarAlCarrito(prod.id));
    }
    
    return col;
}

function agregarTarjetaNuevoProducto() {
    const listaProductos = document.getElementById("lista-productos");
    if (listaProductos) {
        // Verificar si ya existe
        const tarjetaExistente = listaProductos.querySelector('.nuevo-producto');
        if (!tarjetaExistente) {
            const col = createNuevoProductoCard();
            col.classList.add('nuevo-producto');
            listaProductos.appendChild(col);
        }
    }
}

function createNuevoProductoCard() {
    const col = document.createElement('div');
    col.className = 'col nuevo-producto';
    col.innerHTML = `
        <div class="card h-100 shadow-sm border-2 border-dashed position-relative overflow-hidden agregar-producto-card">
            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-4">
                <div class="icon-container mb-3">
                    <i class="fas fa-plus-circle fa-3x text-primary"></i>
                </div>
                <h5 class="card-title fw-bold mb-2">Agregar nuevo producto</h5>
                <p class="card-text text-muted small mb-3">
                    Haz clic para registrar un nuevo artículo en tu tienda.
                </p>
                <button class="btn btn-outline-danger rounded-pill px-4" onclick="mostrarFormularioProducto()">
                    <i class="fas fa-plus me-2"></i>Agregar producto
                </button>
            </div>
        </div>
    `;
    return col;
}


// Resto del código permanece igual (agregarAlCarrito, renderCarrito, etc.)
// ... (código existente del carrito y formularios)

