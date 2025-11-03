<div id="tienda" style="display: flex; flex-direction: column;">
    <div class="section-title-wrapper">
        <h2 class="section-title">Tienda de Accesorios 🛍️</h2>
    </div>

    <!-- Buscador de Productos -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Buscar productos:</h5>
                    <div class="input-group">
                        <input type="text" id="buscador-productos" class="form-control" 
                               placeholder="Escribe el nombre del producto...">
                        <button class="btn btn-outline-secondary" type="button" id="limpiar-busqueda">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <small class="text-muted" id="resultados-busqueda">
                        Mostrando todos los productos
                    </small>    
                </div>
            </div>
        </div>
    </div>

    <!-- Contenedor de Productos -->
    <div id="lista-productos" class="row row-cols-1 row-cols-sm-2 row-cols-lg-5 g-4 ">
        <div class="col-12 text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando productos...</span>
            </div>
        </div>
    </div>
</div>