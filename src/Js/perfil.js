
const API = {
    baseUrl: '../src/api',
    
    // Helper para hacer peticiones fetch
    async request(endpoint, method = 'GET', data = null) {
        const options = {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            }
        };
        
        if (data && method !== 'GET') {
            options.body = JSON.stringify(data);
        }
        
        try {
            const response = await fetch(`${this.baseUrl}/${endpoint}`, options);
            
            // Verificar si la respuesta tiene contenido
            const text = await response.text();
            
            if (!text || text.trim() === '') {
                throw new Error('Respuesta vacía del servidor');
            }
            
            // Intentar parsear como JSON
            let result;
            try {
                result = JSON.parse(text);
            } catch (jsonError) {
                console.error('Error al parsear JSON:', text.substring(0, 500));
                throw new Error('La respuesta del servidor no es un JSON válido');
            }
            
            if (!response.ok) {
                throw new Error(result.message || 'Error en la petición');
            }
            
            return result;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },
    
    //  DIRECCIONES 
    direcciones: {
        obtener: () => API.request('api_direcciones.php'),
        crear: (data) => API.request('api_direcciones.php', 'POST', data),
        actualizar: (data) => API.request('api_direcciones.php', 'PUT', data),
        eliminar: (id) => API.request(`api_direcciones.php?id=${id}`, 'DELETE')
    },
    
    //  PERFIL 
    perfil: {
        obtener: () => API.request('api_perfil.php'),
        actualizar: (data) => API.request('api_perfil.php', 'PUT', data),
        cambiarPassword: (passwordActual, passwordNueva) => 
            API.request('api_perfil.php?action=cambiar_password', 'POST', {
                password_actual: passwordActual,
                password_nueva: passwordNueva
            })
    },
    
    //  PEDIDOS 
    pedidos: {
        obtener: () => API.request('api_pedidos.php')
    }
};

/**
 * Sistema de notificaciones Toast
 */
const Toast = {
    show(message, type = 'info', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="bi bi-${this.getIcon(type)}"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => toast.classList.add('show'), 100);
        
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, duration);
    },
    
    getIcon(type) {
        const icons = {
            success: 'check-circle-fill',
            error: 'x-circle-fill',
            warning: 'exclamation-triangle-fill',
            info: 'info-circle-fill'
        };
        return icons[type] || icons.info;
    }
};

/**
 * Manejo de direcciones
 */
// perfil.js - MODIFICAR DireccionesManager (líneas 135-180)

const DireccionesManager = {
    async cargar() {
        try {
            const response = await API.direcciones.obtener();
            console.log('Direcciones cargadas:', response.data);
        } catch (error) {
            Toast.show('Error al cargar direcciones', 'error');
        }
    },
    
    async crear(data) {
        const response = await API.direcciones.crear(data);
        return response;
    },
    
    async actualizar(data) {
        const response = await API.direcciones.actualizar(data);
        return response;
    },
    
    async eliminar(id) {
        const response = await API.direcciones.eliminar(id);
        return response;
    },
    
    async setPredeterminada(id) {
        const response = await API.direcciones.actualizar({ id, predeterminada: true });
        return response;
    }
};

/**
 * Manejo del perfil
 */
const PerfilManager = {
    async cargar() {
        try {
            const response = await API.perfil.obtener();
            console.log('Perfil cargado:', response.data);
            return response.data;
        } catch (error) {
            Toast.show('Error al cargar perfil', 'error');
        }
    },
    
    async actualizar(data) {
        try {
            const response = await API.perfil.actualizar(data);
            Toast.show(response.message, 'success');
            return response;
        } catch (error) {
            Toast.show(error.message, 'error');
            throw error;
        }
    },
    
    async cambiarPassword(passwordActual, passwordNueva) {
        try {
            const response = await API.perfil.cambiarPassword(passwordActual, passwordNueva);
            Toast.show(response.message, 'success');
            return response;
        } catch (error) {
            Toast.show(error.message, 'error');
            throw error;
        }
    }
};

/* Sistema de navegacion y carga de secciones*/
document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.profile-nav a[data-section]');
    const dynamicContent = document.getElementById('dynamic-content');
    const loadingSpinner = document.getElementById('loading-spinner');
    const dynamicStyles = document.getElementById('dynamic-styles');

    // Cargar la primera sección (dashboard) al cargar la página
    loadSection('dashboard');

    // Event listeners para la navegación
    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            
            // Actualizar clase active
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            
            const section = this.getAttribute('data-section');
            loadSection(section);
        });
    });

    /**
     * Cargar sección dinámica
     */
    async function loadSection(section) {
        if (!dynamicContent) return;

        loadingSpinner.style.display = 'block';
        dynamicContent.style.opacity = '0';

        try {
            const response = await fetch(`../src/procesos/perfil_${section}.php`);
            
            if (!response.ok) {
                throw new Error('Error al cargar la sección');
            }
            
            const html = await response.text();
            dynamicContent.innerHTML = html;

            // Cargar estilos específicos
            const cssPath = `../src/Css/perfil_${section}.css`;
            dynamicStyles.href = cssPath;

            // EJECUTAR SCRIPTS del HTML cargado
            executeScriptsFromHTML(dynamicContent);

            loadingSpinner.style.display = 'none';
            dynamicContent.style.opacity = '1';

            // Ejecutar scripts específicos
            executePageScripts(section);
            
            dynamicContent.scrollIntoView({ behavior: 'smooth', block: 'start' });
            
        } catch (error) {
            console.error('Error:', error);
            dynamicContent.innerHTML = `
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                    Error al cargar la sección. Por favor, inténtalo de nuevo.
                </div>
            `;
            loadingSpinner.style.display = 'none';
            dynamicContent.style.opacity = '1';
        }
    }

    /**
     * Ejecutar scripts del HTML cargado dinámicamente
     */
    function executeScriptsFromHTML(container) {
        const scripts = container.querySelectorAll('script');
        
        scripts.forEach(oldScript => {
            const newScript = document.createElement('script');
            
            // Copiar atributos
            Array.from(oldScript.attributes).forEach(attr => {
                newScript.setAttribute(attr.name, attr.value);
            });
            
            // Copiar contenido
            newScript.textContent = oldScript.textContent;
            
            // Agregar manejador de errores
            newScript.onerror = function(error) {
                console.warn('Error al ejecutar script dinámico:', error);
            };
            
            // Reemplazar el script viejo con el nuevo para que se ejecute
            try {
                oldScript.parentNode.replaceChild(newScript, oldScript);
            } catch (error) {
                console.warn('Error al reemplazar script:', error);
            }
        });
    }

    /**
     * Ejecutar funciones específicas después de cargar cada sección
     */
    function executePageScripts(section) {
        switch (section) {
            case 'dashboard':
                // Dashboard ya tiene su propio script inline
                console.log('Dashboard cargado');
                break;
                
            case 'favoritos':
                // Favoritos se cargan con ORM, no necesita API
                console.log('Favoritos cargados desde perfil_favoritos.php con ORM Doctrine');
                break;
                
            case 'pedidos':
                // Los pedidos ya se cargan con PHP
                console.log('Pedidos cargados desde perfil_pedidos.php con ORM Doctrine');
                break;
                
            case 'direcciones':
                // Direcciones necesita cargar desde API
                DireccionesManager.cargar();
                break;
                
            case 'tarjetaRegalo':
                // Las tarjetas ya se cargan con PHP
                console.log('Tarjetas regalo cargadas desde perfil_tarjetas.php');
                break;
                
            case 'configuracion':
                // Configuración tiene su propio script
                console.log('Configuración cargada');
                break;
        }
    }
});


/* Estilos de Toast dinamicos*/
const toastStyles = document.createElement('style');
toastStyles.textContent = `
    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        z-index: 99999;
        min-width: 250px;
        opacity: 0;
        transform: translateX(400px);
        transition: all 0.3s ease;
    }
    
    .toast.show {
        opacity: 1;
        transform: translateX(0);
    }
    
    .toast-content {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .toast-content i {
        font-size: 1.2rem;
    }
    
    .toast-success {
        border-left: 4px solid #28a745;
    }
    
    .toast-success i {
        color: #28a745;
    }
    
    .toast-error {
        border-left: 4px solid #dc3545;
    }
    
    .toast-error i {
        color: #dc3545;
    }
    
    .toast-warning {
        border-left: 4px solid #ffc107;
    }
    
    .toast-warning i {
        color: #ffc107;
    }
    
    .toast-info {
        border-left: 4px solid #17a2b8;
    }
    
    .toast-info i {
        color: #17a2b8;
    }
`;
document.head.appendChild(toastStyles);
