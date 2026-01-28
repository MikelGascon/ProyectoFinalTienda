// Función para abrir modal con nueva dirección
window.nuevaDireccion = function() {
    document.getElementById('modalTitle').textContent = 'Nueva Dirección';
    document.getElementById('direccionForm').reset();
    document.getElementById('direccion-id').value = '';
    document.getElementById('direccionModal').style.display = 'flex';
}

// Función para editar dirección existente
window.editarDireccion = async function(id) {
    try {
        const response = await API.direcciones.obtener();
        const direccion = response.data.find(d => d.id === id);
        
        if (!direccion) {
            Toast.show('Dirección no encontrada', 'error');
            return;
        }
        
        // Llenar el formulario con los datos de la dirección
        document.getElementById('modalTitle').textContent = 'Editar Dirección';
        document.getElementById('direccion-id').value = direccion.id;
        document.getElementById('direccion-nombre').value = direccion.nombre;
        document.getElementById('direccion-telefono').value = direccion.telefono;
        document.getElementById('direccion-direccion').value = direccion.direccion;
        document.getElementById('direccion-codigo_postal').value = direccion.codigo_postal;
        document.getElementById('direccion-ciudad').value = direccion.ciudad;
        document.getElementById('direccion-provincia').value = direccion.provincia;
        document.getElementById('direccion-pais').value = direccion.pais;
        document.getElementById('direccion-predeterminada').checked = direccion.predeterminada;
        
        document.getElementById('direccionModal').style.display = 'flex';
    } catch (error) {
        Toast.show('Error al cargar dirección', 'error');
    }
}

// Función para guardar dirección (crear o actualizar)
window.guardarDireccion = async function() {
    const form = document.getElementById('direccionForm');
    
    // Validar formulario
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    // Recoger datos del formulario
    const formData = {
        nombre: document.getElementById('direccion-nombre').value,
        telefono: document.getElementById('direccion-telefono').value,
        direccion: document.getElementById('direccion-direccion').value,
        codigo_postal: document.getElementById('direccion-codigo_postal').value,
        ciudad: document.getElementById('direccion-ciudad').value,
        provincia: document.getElementById('direccion-provincia').value,
        pais: document.getElementById('direccion-pais').value,
        predeterminada: document.getElementById('direccion-predeterminada').checked
    };
    
    const id = document.getElementById('direccion-id').value;
    
    try {
        if (id) {
            // Actualizar dirección existente
            formData.id = parseInt(id);
            await DireccionesManager.actualizar(formData);
        } else {
            // Crear nueva dirección
            await DireccionesManager.crear(formData);
        }
        
        // Cerrar modal
        cerrarModal();
        
        // Recargar sección para mostrar cambios
        document.querySelector('[data-section="direcciones"]')?.click();
        
    } catch (error) {
        console.error('Error al guardar dirección:', error);
    }
}

// Función para establecer como predeterminada
window.setPredeterminada = async function(id) {
    if (!confirm('¿Establecer esta dirección como predeterminada?')) {
        return;
    }
    
    try {
        await DireccionesManager.setPredeterminada(id);
        
        // Recargar sección
        document.querySelector('[data-section="direcciones"]')?.click();
    } catch (error) {
        console.error('Error al establecer predeterminada:', error);
    }
}

// Función para eliminar dirección
window.eliminarDireccion = async function(id) {
    if (!confirm('¿Estás seguro de que quieres eliminar esta dirección?')) {
        return;
    }
    
    try {
        await DireccionesManager.eliminar(id);
        
        // Recargar sección
        document.querySelector('[data-section="direcciones"]')?.click();
    } catch (error) {
        console.error('Error al eliminar dirección:', error);
    }
}

// Función para cerrar modal
window.cerrarModal = function() {
    document.getElementById('direccionModal').style.display = 'none';
}

