// direcciones.js - VERSIÓN QUE SÍ REDIRECCIONA

window.nuevaDireccion = function() {
    document.getElementById('modalTitle').textContent = 'Nueva Dirección';
    document.getElementById('direccionForm').reset();
    document.getElementById('direccion-id').value = '';
    document.getElementById('direccionModal').style.display = 'flex';
}

window.editarDireccion = async function(id) {
    try {
        const response = await API.direcciones.obtener();
        const direccion = response.data.find(d => d.id === id);
        
        if (!direccion) {
            Toast.show('Dirección no encontrada', 'error');
            return;
        }
        
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

window.guardarDireccion = async function() {
    const form = document.getElementById('direccionForm');
    
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
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
            formData.id = parseInt(id);
            await API.direcciones.actualizar(formData);
        } else {
            await API.direcciones.crear(formData);
        }
        
        cerrarModal();
        
        // Forzar redirección
        setTimeout(() => {
            window.location.replace("index.php");
        }, 500);
        
    } catch (error) {
        console.error('Error al guardar dirección:', error);
        Toast.show('Error al guardar', 'error');
    }
}

window.setPredeterminada = async function(id) {
    if (!confirm('¿Establecer esta dirección como predeterminada?')) {
        return;
    }
    
    try {
        await API.direcciones.actualizar({ id: id, predeterminada: true });
        
        setTimeout(() => {
            window.location.replace("index.php");
        }, 500);
        
    } catch (error) {
        console.error('Error al establecer predeterminada:', error);
        Toast.show('Error', 'error');
    }
}

window.eliminarDireccion = async function(id) {
    if (!confirm('¿Estás seguro de que quieres eliminar esta dirección?')) {
        return;
    }
    
    try {
        await API.direcciones.eliminar(id);
        
        setTimeout(() => {
            window.location.replace("index.php");
        }, 500);
        
    } catch (error) {
        console.error('Error al eliminar dirección:', error);
        Toast.show('Error', 'error');
    }
}

window.cerrarModal = function() {
    document.getElementById('direccionModal').style.display = 'none';
}