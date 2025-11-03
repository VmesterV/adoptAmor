<!-- Filtros de Mascotas -->
<div style="display: flex; flex-direction: column;">
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-danger shadow-sm">
        <div class="card-body">
          <h5 class="card-title text-danger">Filtrar por tipo:</h5>
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-danger active" data-filter="perro">
              🐶 Perros
            </button>
            <button type="button" class="btn btn-outline-danger" data-filter="gato">
              🐱 Gatos
            </button>
            <button type="button" class="btn btn-outline-danger" data-filter="todos">
              🐾 Todos
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Contenedor de Mascotas -->
  <div id="mascotas-container">
    <!-- Aquí se cargarán las mascotas según el filtro -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="mascotas-grid">
      <div class="col-12 text-center">
        <div class="spinner-border text-danger" role="status">
          <span class="visually-hidden">Cargando mascotas...</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Adopción -->
  <div class="modal fade" id="adopcionModal">
    <div class="modal-dialog">
      <div class="modal-content border-danger">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">
            <i class="fas fa-heart me-2"></i>
            Adoptar a <span id="modal-pet-name">Mascota</span>
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="adopcionForm">
            <input type="hidden" name="mascota_id" id="mascotaSeleccionada">
            <div class="mb-3">
              <label class="form-label text-danger">DNI:</label>
              <input type="number" class="form-control border-danger" name="dni" required>
            </div>
            <div class="mb-3">
              <label class="form-label text-danger">Nombre completo:</label>
              <input type="text" class="form-control border-danger" name="nombre" required>
            </div>
            <button type="submit" class="btn btn-danger w-100">
              <i class="fas fa-paper-plane me-2"></i>Enviar Solicitud
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
