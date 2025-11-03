<div class="seccion-registro">
    <div class="tarjeta">
        <div class="icono-huella">
            <i class="fas fa-paw"></i>
        </div>
        
        <h2 class="titulo-registro">Crear Cuenta</h2>
        
        <form class="formulario" id="form-register">
            <div id="form-message" class="form-message"></div>

            <div class="campo-formulario">
                <label for="nombre">Nombre completo</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre completo" required>
                <i class="icono-campo fas fa-user"></i>
            </div>
            
            <div class="campo-formulario">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" placeholder="tu@email.com" required>
                <i class="icono-campo fas fa-envelope"></i>
            </div>
            
            <div class="campo-formulario">
                <label for="password">Contraseña (mín. 6 caracteres)</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
                <i class="icono-campo fas fa-lock"></i>
            </div>
            
            <div class="campo-formulario">
                <label for="confirmar_password">Confirmar contraseña</label>
                <input type="password" id="confirmar_password" name="confirmar_password" placeholder="••••••••" required>
                <i class="icono-campo fas fa-lock"></i>
            </div>
            
            <button type="submit" class="boton-principal">Crear cuenta</button>
            
            <div class="enlace-login">
                <p>¿Ya tienes cuenta? <a href="/?auth=login" class="nav-link">Inicia sesión</a></p>
            </div>
        </form>
    </div>
</div>

<div class="imagen-lateral">
    <h1>AdoptAmor</h1>
</div>

<script>
document.getElementById('form-register').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const password = document.getElementById('password').value;
    const confirmarPassword = document.getElementById('confirmar_password').value;
    const messageDiv = document.getElementById('form-message');
    
    if (password !== confirmarPassword) {
        messageDiv.textContent = 'Las contraseñas no coinciden';
        messageDiv.className = 'form-message error';
        return;
    }
    
    const formData = new FormData(this);
    formData.append('auth_action', 'register');
    
    messageDiv.textContent = 'Creando cuenta...';
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
            this.reset();
            setTimeout(() => {
                window.location.href = '/?auth=login';
            }, 2000);
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