document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearSearch');

    if (searchInput && clearBtn) {
        // Mostrar/ocultar botón X según el contenido del input
        searchInput.addEventListener('input', function () {
            if (this.value.length > 0) {
                clearBtn.classList.add('visible');
            } else {
                clearBtn.classList.remove('visible');
            }
        });

        // Limpiar el input al hacer clic en la X
        clearBtn.addEventListener('click', function () {
            searchInput.value = '';
            clearBtn.classList.remove('visible');
            searchInput.focus();
        });
    }

    // Efecto glassmorphism en navbar al hacer scroll
    const navbar = document.querySelector('.navbar.opacidad');
    if (navbar) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    // ====== MENÚ LATERAL ======
    const menuToggle = document.getElementById('menuToggle');
    const menuClose = document.getElementById('menuClose');
    const sideMenu = document.getElementById('sideMenu');
    const menuBackdrop = document.getElementById('menuBackdrop');
    const navbarElement = document.querySelector('.navbar');

    if (menuToggle && menuClose && sideMenu && menuBackdrop && navbarElement) {
        function updateMenuPosition() {
            const navbarRect = navbarElement.getBoundingClientRect();
            const topPosition = navbarRect.bottom;
            sideMenu.style.top = topPosition + 'px';
            sideMenu.style.height = 'calc(100vh - ' + topPosition + 'px)';
            menuBackdrop.style.top = topPosition + 'px';
        }

        function openMenu() {
            updateMenuPosition();
            sideMenu.classList.add('open');
            menuBackdrop.classList.add('show');
            document.body.classList.add('menu-open');
        }

        function closeMenu() {
            sideMenu.classList.remove('open');
            menuBackdrop.classList.remove('show');
            document.body.classList.remove('menu-open');
        }

        menuToggle.addEventListener('click', openMenu);
        menuClose.addEventListener('click', closeMenu);
        menuBackdrop.addEventListener('click', closeMenu);
    }
});


function toggleUserPanel(event) {
    event.preventDefault();
    const panel = document.getElementById('panelUsuario');
    panel.classList.toggle('show');
}

// Cerrar el panel cuando se hace clic fuera
document.addEventListener('click', function (event) {
    const panel = document.getElementById('panelUsuario');
    const userIcon = event.target.closest('.user-panel-container');

    if (!userIcon && panel.classList.contains('show')) {
        panel.classList.remove('show');
    }
});

// Prevenir que el clic en el panel lo cierre
document.getElementById('panelUsuario')?.addEventListener('click', function (event) {
    event.stopPropagation();
});