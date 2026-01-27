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
    

    // Abrir y cerar el modadl 
    
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
 
    // Indicacion de fuerza de contraseña
    
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
    
    // Enviar formulario de cmabio de contraseña
    
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
    
    // Funcion para mostrar mensajes

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