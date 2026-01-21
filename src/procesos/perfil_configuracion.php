<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Entity/bootstrap.php';

session_start();

$usuario_id = $_SESSION['usuario_id'] ?? null;
$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario';
$usuario = $_SESSION['usuario'] ?? 'Invitado';
$email = $_SESSION['email'] ?? 'email@example.com';
?>

<div class="section-title">
    <i class="bi bi-gear"></i> Configuración de Cuenta
</div>

<!-- Configuración de Seguridad -->
<div class="config-section">
    <div class="config-header">
        <h5><i class="bi bi-shield-lock"></i> Seguridad</h5>
    </div>
    <div class="config-body">
        
        <!-- Botón para abrir modal de cambio de contraseña -->
        <div class="config-item">
            <div class="config-info">
                <strong>Contraseña</strong>
                <p class="text-muted">Última modificación: hace 3 meses</p>
            </div>
            <button class="btn btn-outline-primary" id="openPasswordModal">
                <i class="bi bi-key-fill"></i> Cambiar Contraseña
            </button>
        </div>
        
        <div class="config-item">
            <div class="config-info">
                <strong>Autenticación de dos factores</strong>
                <p class="text-muted">Añade una capa extra de seguridad</p>
            </div>
            <label class="switch">
                <input type="checkbox" id="twoFactor">
                <span class="slider"></span>
            </label>
        </div>
        
        <div class="config-item">
            <div class="config-info">
                <strong>Sesiones activas</strong>
                <p class="text-muted">Administra los dispositivos con sesión iniciada</p>
            </div>
            <button class="btn btn-outline-primary" id="viewSessions">
                <i class="bi bi-devices"></i> Ver Sesiones
            </button>
        </div>
    </div>
</div>

<!-- Configuración de Notificaciones -->
<div class="config-section">
    <div class="config-header">
        <h5><i class="bi bi-bell"></i> Notificaciones</h5>
    </div>
    <div class="config-body">
        <div class="config-item">
            <div class="config-info">
                <strong>Email de ofertas y promociones</strong>
                <p class="text-muted">Recibe nuestras mejores ofertas</p>
            </div>
            <label class="switch">
                <input type="checkbox" id="emailOfertas" checked>
                <span class="slider"></span>
            </label>
        </div>
        
        <div class="config-item">
            <div class="config-info">
                <strong>Actualizaciones de pedidos</strong>
                <p class="text-muted">Notificaciones sobre el estado de tus pedidos</p>
            </div>
            <label class="switch">
                <input type="checkbox" id="emailPedidos" checked>
                <span class="slider"></span>
            </label>
        </div>
        
        <div class="config-item">
            <div class="config-info">
                <strong>Newsletter semanal</strong>
                <p class="text-muted">Novedades y tendencias cada semana</p>
            </div>
            <label class="switch">
                <input type="checkbox" id="newsletter">
                <span class="slider"></span>
            </label>
        </div>
        
        <div class="config-item">
            <div class="config-info">
                <strong>Notificaciones push</strong>
                <p class="text-muted">Recibe notificaciones en el navegador</p>
            </div>
            <label class="switch">
                <input type="checkbox" id="pushNotif">
                <span class="slider"></span>
            </label>
        </div>
    </div>
</div>

<!-- Configuración de Privacidad -->
<div class="config-section">
    <div class="config-header">
        <h5><i class="bi bi-eye-slash"></i> Privacidad</h5>
    </div>
    <div class="config-body">
        <div class="config-item">
            <div class="config-info">
                <strong>Perfil público</strong>
                <p class="text-muted">Permitir que otros usuarios vean tu perfil</p>
            </div>
            <label class="switch">
                <input type="checkbox" id="perfilPublico">
                <span class="slider"></span>
            </label>
        </div>
        
        <div class="config-item">
            <div class="config-info">
                <strong>Compartir datos de compra</strong>
                <p class="text-muted">Para mejorar recomendaciones personalizadas</p>
            </div>
            <label class="switch">
                <input type="checkbox" id="compartirDatos" checked>
                <span class="slider"></span>
            </label>
        </div>
        
        <div class="config-item">
            <div class="config-info">
                <strong>Cookies de marketing</strong>
                <p class="text-muted">Permitir cookies de terceros para publicidad</p>
            </div>
            <label class="switch">
                <input type="checkbox" id="cookiesMarketing">
                <span class="slider"></span>
            </label>
        </div>
    </div>
</div>

<!-- Preferencias de Compra -->
<div class="config-section">
    <div class="config-header">
        <h5><i class="bi bi-cart"></i> Preferencias de Compra</h5>
    </div>
    <div class="config-body">
        <div class="config-item">
            <div class="config-info">
                <strong>Idioma</strong>
                <p class="text-muted">Selecciona tu idioma preferido</p>
            </div>
            <select class="form-select form-select-sm" style="width: auto;">
                <option value="es" selected>Español</option>
                <option value="en">English</option>
                <option value="fr">Français</option>
                <option value="de">Deutsch</option>
            </select>
        </div>
        
        <div class="config-item">
            <div class="config-info">
                <strong>Moneda</strong>
                <p class="text-muted">Moneda para mostrar precios</p>
            </div>
            <select class="form-select form-select-sm" style="width: auto;">
                <option value="eur" selected>EUR (€)</option>
                <option value="usd">USD ($)</option>
                <option value="gbp">GBP (£)</option>
            </select>
        </div>
        
        <div class="config-item">
            <div class="config-info">
                <strong>Guardar carrito</strong>
                <p class="text-muted">Mantener productos en el carrito entre sesiones</p>
            </div>
            <label class="switch">
                <input type="checkbox" id="guardarCarrito" checked>
                <span class="slider"></span>
            </label>
        </div>
    </div>
</div>

<!-- Zona de Peligro -->
<div class="config-section danger-zone">
    <div class="config-header">
        <h5><i class="bi bi-exclamation-triangle"></i> Zona de Peligro</h5>
    </div>
    <div class="config-body">
        <div class="config-item">
            <div class="config-info">
                <strong>Descargar mis datos</strong>
                <p class="text-muted">Solicita una copia de toda tu información</p>
            </div>
            <button class="btn btn-outline-secondary" id="downloadData">
                <i class="bi bi-download"></i> Descargar
            </button>
        </div>
        
        <div class="config-item">
            <div class="config-info">
                <strong>Eliminar cuenta</strong>
                <p class="text-muted">Esta acción es permanente e irreversible</p>
            </div>
            <button class="btn btn-danger" id="deleteAccount">
                <i class="bi bi-trash"></i> Eliminar Cuenta
            </button>
        </div>
    </div>
</div>

<!-- Botón Guardar Cambios Generales -->
<div class="text-end mt-4">
    <button class="btn btn-primary btn-lg" id="saveGeneralConfig">
        <i class="bi bi-check-circle"></i> Guardar Preferencias
    </button>
</div>

<!-- MODAL/POPUP DE CAMBIO DE CONTRASEÑA -->
<div id="passwordModal" class="modal-overlay" style="display: none;">
    <div class="modal-content modal-password">
        <div class="modal-header">
            <h5>
                <i class="bi bi-shield-lock"></i> Cambiar Contraseña
            </h5>
            <button class="btn-close" id="closePasswordModal">&times;</button>
        </div>
        
        <div class="modal-body">
            <div class="alert alert-info mb-3">
                <i class="bi bi-info-circle"></i>
                <strong>Verificación de seguridad:</strong> Por tu seguridad, debes ingresar tu contraseña actual dos veces para confirmar tu identidad.
            </div>
            
            <form id="passwordChangeForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="current_password_1">
                                <i class="bi bi-lock"></i> Contraseña Actual
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="current_password_1" 
                                   name="current_password_1" 
                                   placeholder="Ingresa tu contraseña actual"
                                   required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="current_password_2">
                                <i class="bi bi-lock-fill"></i> Confirmar Contraseña Actual
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="current_password_2" 
                                   name="current_password_2" 
                                   placeholder="Confirma tu contraseña actual"
                                   required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="new_password">
                        <i class="bi bi-key-fill"></i> Nueva Contraseña
                    </label>
                    <input type="password" 
                           class="form-control" 
                           id="new_password" 
                           name="new_password" 
                           placeholder="Ingresa tu nueva contraseña"
                           minlength="8"
                           required>
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i> Mínimo 8 caracteres. Recomendamos incluir mayúsculas, números y símbolos.
                    </small>
                </div>
                
                <div class="password-strength" id="passwordStrength" style="display: none;">
                    <div class="strength-info">
                        <span class="strength-label">Seguridad de la contraseña:</span>
                        <span class="strength-text" id="strengthText">Débil</span>
                    </div>
                    <div class="strength-bar">
                        <div class="strength-bar-fill" id="strengthBar"></div>
                    </div>
                </div>
                
                <div id="passwordMessage" class="alert" style="display: none; margin-top: 15px;"></div>
            </form>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelPasswordChange">
                <i class="bi bi-x-circle"></i> Cancelar
            </button>
            <button type="submit" form="passwordChangeForm" class="btn btn-primary">
                <i class="bi bi-shield-check"></i> Cambiar Contraseña
            </button>
        </div>
    </div>
</div>

<script>
(function() {
    // Elementos del DOM
    const passwordModal = document.getElementById('passwordModal');
    const openModalBtn = document.getElementById('openPasswordModal');
    const closeModalBtn = document.getElementById('closePasswordModal');
    const cancelBtn = document.getElementById('cancelPasswordChange');
    const passwordForm = document.getElementById('passwordChangeForm');
    const passwordMessage = document.getElementById('passwordMessage');
    const newPasswordInput = document.getElementById('new_password');
    const strengthIndicator = document.getElementById('passwordStrength');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    
    // ============================================
    // ABRIR Y CERRAR MODAL
    // ============================================
    
    function openModal() {
        passwordModal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Evitar scroll del body
        // Enfocar el primer campo
        setTimeout(() => {
            document.getElementById('current_password_1')?.focus();
        }, 100);
    }
    
    function closeModal() {
        passwordModal.style.display = 'none';
        document.body.style.overflow = ''; // Restaurar scroll
        passwordForm.reset();
        strengthIndicator.style.display = 'none';
        passwordMessage.style.display = 'none';
    }
    
    // Event listeners para abrir/cerrar modal
    if (openModalBtn) {
        openModalBtn.addEventListener('click', openModal);
    }
    
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }
    
    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeModal);
    }
    
    // Cerrar modal al hacer clic fuera
    if (passwordModal) {
        passwordModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    }
    
    // Cerrar con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && passwordModal.style.display === 'flex') {
            closeModal();
        }
    });
    
    // ============================================
    // INDICADOR DE FORTALEZA DE CONTRASEÑA
    // ============================================
    
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            const password = this.value;
            if (password.length > 0) {
                strengthIndicator.style.display = 'block';
                const strength = calculatePasswordStrength(password);
                updateStrengthIndicator(strength);
            } else {
                strengthIndicator.style.display = 'none';
            }
        });
    }
    
    function calculatePasswordStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/\d/.test(password)) strength++;
        if (/[^a-zA-Z\d]/.test(password)) strength++;
        return strength;
    }
    
    function updateStrengthIndicator(strength) {
        const colors = ['#dc3545', '#fd7e14', '#ffc107', '#28a745', '#0d6efd'];
        const texts = ['Muy débil', 'Débil', 'Regular', 'Fuerte', 'Muy fuerte'];
        const widths = ['20%', '40%', '60%', '80%', '100%'];
        
        strengthBar.style.width = widths[strength] || '20%';
        strengthBar.style.backgroundColor = colors[strength] || '#dc3545';
        strengthText.textContent = texts[strength] || 'Muy débil';
        strengthText.style.color = colors[strength] || '#dc3545';
    }
    
    // ============================================
    // ENVIAR FORMULARIO DE CAMBIO DE CONTRASEÑA
    // ============================================
    
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const currentPass1 = formData.get('current_password_1');
            const currentPass2 = formData.get('current_password_2');
            const newPass = formData.get('new_password');
            
            // Validar que las dos contraseñas actuales coincidan
            if (currentPass1 !== currentPass2) {
                showMessage('Las contraseñas actuales no coinciden. Por favor, verifícalas.', 'error');
                return;
            }
            
            // Validar que la nueva contraseña sea diferente
            if (currentPass1 === newPass) {
                showMessage('La nueva contraseña debe ser diferente a la actual.', 'error');
                return;
            }
            
            // Validar longitud mínima
            if (newPass.length < 8) {
                showMessage('La nueva contraseña debe tener al menos 8 caracteres.', 'error');
                return;
            }
            
            // Preparar datos para enviar
            const sendData = new FormData();
            sendData.append('current_password', currentPass1);
            sendData.append('new_password', newPass);
            
            // Deshabilitar botón de envío
            const submitBtn = this.querySelector('button[type="submit"]') || 
                            document.querySelector('button[form="passwordChangeForm"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Cambiando...';
            
            // Enviar petición
            fetch('../src/procesos/cambiar_password.php', {
                method: 'POST',
                body: sendData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('✓ Contraseña cambiada correctamente', 'success');
                    setTimeout(() => {
                        closeModal();
                    }, 2000);
                } else {
                    showMessage(data.message || 'Error al cambiar la contraseña', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Error al procesar la solicitud. Inténtalo de nuevo.', 'error');
            })
            .finally(() => {
                // Rehabilitar botón
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }
    
    // ============================================
    // FUNCIÓN PARA MOSTRAR MENSAJES
    // ============================================
    
    function showMessage(message, type) {
        passwordMessage.innerHTML = message;
        passwordMessage.className = 'alert alert-' + (type === 'success' ? 'success' : 'danger');
        passwordMessage.style.display = 'block';
        
        if (type === 'success') {
            setTimeout(() => {
                passwordMessage.style.display = 'none';
            }, 3000);
        }
    }
    
    // ============================================
    // OTRAS FUNCIONES DE CONFIGURACIÓN
    // ============================================
    
    // Guardar configuración general
    const saveConfigBtn = document.getElementById('saveGeneralConfig');
    if (saveConfigBtn) {
        saveConfigBtn.addEventListener('click', function() {
            const config = {
                twoFactor: document.getElementById('twoFactor')?.checked || false,
                emailOfertas: document.getElementById('emailOfertas')?.checked || false,
                emailPedidos: document.getElementById('emailPedidos')?.checked || false,
                newsletter: document.getElementById('newsletter')?.checked || false,
                pushNotif: document.getElementById('pushNotif')?.checked || false,
                perfilPublico: document.getElementById('perfilPublico')?.checked || false,
                compartirDatos: document.getElementById('compartirDatos')?.checked || false,
                cookiesMarketing: document.getElementById('cookiesMarketing')?.checked || false,
                guardarCarrito: document.getElementById('guardarCarrito')?.checked || false,
            };
            
            fetch('../src/procesos/guardar_configuracion.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(config)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✓ Configuración guardada correctamente');
                } else {
                    alert('✗ Error al guardar la configuración');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('✗ Error al guardar la configuración');
            });
        });
    }
    
    // Ver sesiones
    const viewSessionsBtn = document.getElementById('viewSessions');
    if (viewSessionsBtn) {
        viewSessionsBtn.addEventListener('click', function() {
            alert('Mostrando sesiones activas... (Implementar modal)');
        });
    }
    
    // Descargar datos
    const downloadDataBtn = document.getElementById('downloadData');
    if (downloadDataBtn) {
        downloadDataBtn.addEventListener('click', function() {
            if (confirm('¿Solicitar descarga de tus datos personales?')) {
                alert('Se enviará un email con el enlace de descarga en las próximas 24-48 horas');
            }
        });
    }
    
    // Eliminar cuenta
    const deleteAccountBtn = document.getElementById('deleteAccount');
    if (deleteAccountBtn) {
        deleteAccountBtn.addEventListener('click', function() {
            const confirmacion = prompt('Esta acción es IRREVERSIBLE. Escribe "ELIMINAR" para confirmar:');
            if (confirmacion === 'ELIMINAR') {
                if (confirm('¿Estás ABSOLUTAMENTE seguro? Esta acción no se puede deshacer')) {
                    alert('Procesando eliminación de cuenta...');
                }
            }
        });
    }
})();
</script>