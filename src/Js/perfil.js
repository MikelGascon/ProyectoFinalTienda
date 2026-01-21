document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.nav-link');
    const dynamicContent = document.getElementById('dynamic-content');
    const loadingSpinner = document.getElementById('loading-spinner');
    const dynamicStyles = document.getElementById('dynamic-styles');

    // Cargar sección inicial
    loadSection('dashboard');

    // Event listeners para los links
    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            const section = this.getAttribute('data-section');
            if (section) {
                e.preventDefault();

                // Actualizar clase active
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');

                // Cargar sección
                loadSection(section);
            }
        });
    });

    function loadSection(section) {
        // Mostrar loading
        loadingSpinner.style.display = 'block';
        dynamicContent.style.opacity = '0.5';

        // Fetch del contenido
        fetch(`../src/procesos/perfil_${section}.php`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al cargar la sección');
                }
                return response.text();
            })
            .then(html => {
                dynamicContent.innerHTML = html;

                // Cargar estilos específicos de la sección si existen
                const cssPath = `../src/Css/perfil_${section}.css`;
                dynamicStyles.href = cssPath;

                // Ocultar loading
                loadingSpinner.style.display = 'none';
                dynamicContent.style.opacity = '1';

                // Scroll suave al inicio del contenido
                dynamicContent.scrollIntoView({ behavior: 'smooth', block: 'start' });

                // Ejecutar scripts específicos si existen
                executePageScripts(section);
            })
            .catch(error => {
                console.error('Error:', error);
                dynamicContent.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        Error al cargar la sección. Por favor, inténtalo de nuevo.
                    </div>
                `;
                loadingSpinner.style.display = 'none';
                dynamicContent.style.opacity = '1';
            });
    }

    function executePageScripts(section) {
        // Aquí puedes ejecutar scripts específicos para cada sección
        switch (section) {
            case 'favoritos':
                initFavoritos();
                break;
            case 'pedidos':
                initPedidos();
                break;
            case 'direcciones':
                initDirecciones();
                break;
            case 'configuracion':
                initConfiguracion();
                break;
        }
    }

    // Funciones de inicialización para cada sección
    function initFavoritos() {
        // Código específico para favoritos
        console.log('Favoritos inicializado');
    }

    function initPedidos() {
        // Código específico para pedidos
        console.log('Pedidos inicializado');
    }

    function initDirecciones() {
        // Código específico para direcciones
        console.log('Direcciones inicializado');
    }

    function initConfiguracion() {
        // Código específico para configuración
        console.log('Configuración inicializado');
    }
});