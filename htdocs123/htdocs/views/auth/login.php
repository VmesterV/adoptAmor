<div class="seccion-login">
    <div class="tarjeta">
        <div class="icono-huella">
            <i class="fas fa-paw"></i>
        </div>
        
        <h2 class="titulo-login">Inicia Sesión</h2>
        
        <form class="formulario" id="form-login">
            <div id="form-message" class="form-message"></div>

            <div class="campo-formulario">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="tu@email.com" required>
                <i class="icono-campo fas fa-envelope"></i>
            </div>
            
            <div class="campo-formulario">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
                <i class="icono-campo fas fa-lock"></i>
            </div>
            
            <div class="opciones-adicionales">
                <a href="/?auth=recover" class="nav-link">Olvidé mi contraseña</a>
            </div>
            
            <button type="submit" class="boton-principal">Entrar</button>
            
            <div class="enlace-registro">
                <p>¿No tienes cuenta? <a href="/?auth=register" class="nav-link">Regístrate aquí</a></p>
            </div>
        </form>
    </div>
</div>

<div class="imagen-lateral">
    <h1>AdoptAmor</h1>
</div>

<script>
document.getElementById('form-login').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    formData.append('auth_action', 'login');
    
    const messageDiv = document.getElementById('form-message');
    messageDiv.textContent = 'Procesando...';
    messageDiv.className = 'form-message';
    
    try {
        const response = await fetch('/', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            messageDiv.textContent = data.message;
            messageDiv.className = 'form-message success';
            setTimeout(() => {
                window.location.href = data.redirect || '/';
            }, 1000);
        } else {
            messageDiv.textContent = data.message;
            messageDiv.className = 'form-message error';
        }
    } catch (error) {
        messageDiv.textContent = 'Error de conexión';
        messageDiv.className = 'form-message error';
    }
});
</script>