<div class="seccion-recuperacion">
    <div class="tarjeta">
        <div class="icono-huella">
            <i class="fas fa-paw" aria-hidden="true"></i>
        </div>
        
        <h2 class="titulo-recuperacion">Recuperar Contraseña</h2>
        
        <p class="instrucciones">
            Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
        </p>
        
        <form class="formulario" action="/auth/process-recover" method="POST">
            <div class="campo-formulario">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" placeholder="tu@email.com" required>
                <i class="icono-campo fas fa-envelope"></i>
            </div>
            
            <button type="submit" class="boton-principal">
                <i class="fas fa-paper-plane"></i>
                Enviar enlace de recuperación
            </button>
            
            <div class="enlace-volver">
                <a href="/auth/login" class="nav-link boton-secundario">
                    <i class="fas fa-arrow-left"></i>
                    Volver al inicio de sesión
                </a>
            </div>
        </form>
    </div>
</div>