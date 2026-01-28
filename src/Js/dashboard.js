
// Funciones del modal de edición
function abrirModalEdicion() {
    document.getElementById('editModal').style.display = 'flex';
    // Cargar los valores actuales en el formulario
    document.getElementById('edit-nombre').value = document.getElementById('display-nombre').textContent;
    document.getElementById('edit-usuario').value = document.getElementById('display-usuario').textContent;
    document.getElementById('edit-email').value = document.getElementById('display-email').textContent;
}

function cerrarModalEdicion() {
    document.getElementById('editModal').style.display = 'none';
}

async function guardarCambios(event) {
    const form = document.getElementById('formEditarPerfil');
    
    // Validar formulario
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    // Obtener datos del formulario
    const formData = {
        nombre: document.getElementById('edit-nombre').value,
        usuario: document.getElementById('edit-usuario').value,
        email: document.getElementById('edit-email').value
    };
    
    try {
        // Mostrar indicador de carga
        const btnGuardar = event ? event.target : document.querySelector('.btn-primary');
        const textoOriginal = btnGuardar.innerHTML;
        btnGuardar.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Guardando...';
        btnGuardar.disabled = true;
        
        // Llamar a la API para actualizar el perfil
        const response = await fetch('../src/api/api_perfil.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Actualizar la vista con los nuevos datos
            document.getElementById('display-nombre').textContent = formData.nombre;
            document.getElementById('display-usuario').textContent = formData.usuario;
            document.getElementById('display-email').textContent = formData.email;
            
            // Actualizar también el sidebar
            document.querySelector('.profile-name').textContent = formData.nombre;
            document.querySelector('.profile-email').textContent = formData.email;
            
            // Mostrar mensaje de éxito
            if (typeof Toast !== 'undefined') {
                Toast.show(data.message, 'success');
            } else {
                alert(data.message);
            }
            
            // Cerrar modal
            cerrarModalEdicion();
        } else {
            // Mostrar mensaje de error
            if (typeof Toast !== 'undefined') {
                Toast.show(data.message, 'error');
            } else {
                alert('Error: ' + data.message);
            }
        }
        
        // Restaurar botón
        btnGuardar.innerHTML = textoOriginal;
        btnGuardar.disabled = false;
        
    } catch (error) {
        console.error('Error:', error);
        
        if (typeof Toast !== 'undefined') {
            Toast.show('Error al actualizar el perfil. Inténtalo de nuevo.', 'error');
        } else {
            alert('Error al actualizar el perfil. Inténtalo de nuevo.');
        }
    }
}

// Event listener para el link "Ver todos los pedidos"
document.querySelector('.view-all-link')?.addEventListener('click', function (e) {
    e.preventDefault();
    const section = this.getAttribute('data-section');
    document.querySelector(`[data-section="${section}"]`).click();
});
