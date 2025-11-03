<div class="modal fade" id="adopcionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adoptar a <span id="modal-pet-name">Mascota</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="adopcionForm" method="POST" action="/api/adopciones">
                    <div class="mb-3">
                        <label for="dniInput" class="form-label">DNI:</label>
                        <input type="number" class="form-control" name="dni" id="dniInput" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombreInput" class="form-label">Nombre completo:</label>
                        <input type="text" class="form-control" name="nombre" id="nombreInput" required>
                    </div>
                    <div class="mb-3">
                        <label for="mascotaInput" class="form-label">Mascota seleccionada (ID):</label>
                        <input type="number" class="form-control" name="mascota_id" id="mascotaSeleccionada" readonly required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Enviar Solicitud</button>
                </form>
                <div id="adopcion-form-message" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>