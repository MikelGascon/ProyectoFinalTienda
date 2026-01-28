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
                <strong>Eliminar cuenta</strong>
                <p class="text-muted">Esta acción es permanente e irreversible</p>
            </div>
            <button class="btn btn-danger" id="deleteAccount">
                <i class="bi bi-trash"></i> Eliminar Cuenta
            </button>
        </div>
    </div>
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


<!-- Cargar script de configuración -->
<script src="../src/Js/configuracion.js"></script>