<?php
require_once __DIR__ . '/../config/config.php';
require_once '../src/Entity/bootstrap.php';

session_start();

// Variables de sesión
$usuario_id = $_SESSION['usuario_id'] ?? null;
$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario';
$usuario = $_SESSION['usuario'] ?? 'Invitado';
$email = $_SESSION['email'] ?? 'email@example.com';

// Configuración del header
$pageTitle = "El Corte Rebelde";
$bannerText = "20% OFF EN COLECCIÓN DE INVIERNO";
$showBanner = true;
$basePath = "../src";
include '../src/components/header.php';
?>

<link href="<?php echo $basePath; ?>/Css/perfil.css" rel="stylesheet">
<!-- Estilos dinámicos se cargarán según la sección -->
<link id="dynamic-styles" rel="stylesheet">

<div class="profile-container">
    <div class="row g-4">
        <!-- SIDEBAR -->
        <div class="col-lg-3">
            <div class="profile-sidebar">
                <div class="profile-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="profile-name"><?php echo htmlspecialchars($nombreUsuario); ?></div>
                <div class="profile-email"><?php echo htmlspecialchars($email); ?></div>

                <ul class="profile-nav">
                    <li>
                        <a href="#" class="nav-link active" data-section="dashboard">
                            <i class="bi bi-person-circle"></i> 
                            <span>Mi Perfil</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link" data-section="pedidos">
                            <i class="bi bi-bag-check"></i> 
                            <span>Mis Pedidos</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link" data-section="direcciones">
                            <i class="bi bi-house"></i> 
                            <span>Mis Direcciones</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link" data-section="favoritos">
                            <i class="bi bi-heart"></i> 
                            <span>Favoritos</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link" data-section="configuracion">
                            <i class="bi bi-gear"></i> 
                            <span>Configuración</span>
                        </a>
                    </li>
                    <li>
                        <a href="../src/procesos/logout.php" style="color: #dc3545;">
                            <i class="bi bi-box-arrow-right"></i> 
                            <span>Cerrar Sesión</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- CONTENIDO DINÁMICO -->
        <div class="col-lg-9">
            <div class="profile-content">
                <!-- Loading spinner -->
                <div id="loading-spinner" style="display: none; text-align: center; padding: 50px;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
                
                <!-- Contenido dinámico -->
                <div id="dynamic-content">
                    <!-- Aquí se cargará el contenido -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../src/components/footer.php" ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const dynamicContent = document.getElementById('dynamic-content');
    const loadingSpinner = document.getElementById('loading-spinner');
    const dynamicStyles = document.getElementById('dynamic-styles');
    
    // Cargar sección inicial
    loadSection('dashboard');
    
    // Event listeners para los links
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
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
        switch(section) {
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
</script>