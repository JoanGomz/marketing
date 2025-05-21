export default function () {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const mainContent = document.getElementById('main-content');
    // logo y estado de carga de navegación para configurar posición segun actividad del slideBar
    const carga = document.querySelector('nocard-loading');
    // Estado inicial
    carga.slideBarOpen();
    let sidebarOpen = true;
    
    // Función para controlar el estado del sidebar
    function toggleSidebar() {
        if (sidebarOpen) {
            // Cerrar sidebar
            sidebar.style.transform = 'translateX(-100%)';
            
            // Solo ajustar el margen en pantallas grandes
            if (window.innerWidth >= 768) {
                mainContent.style.marginLeft = '0';
                //Ajustar la posición de carga
                carga.slideBarClose();
            }
        } else {
            // Abrir sidebar
            sidebar.style.transform = 'translateX(0)';
            
            // Solo ajustar el margen en pantallas grandes
            if (window.innerWidth >= 768) {
                mainContent.style.marginLeft = '16rem';
                //Ajustar la posición de carga
                carga.slideBarOpen();
            }
        }
        
        sidebarOpen = !sidebarOpen;
    }
    
    // Evento para el botón de toggle
    sidebarToggle.addEventListener('click', toggleSidebar);
    
    // Responsive: configuración según tamaño de pantalla
    function checkScreenSize() {
        if (window.innerWidth < 768) {
            // En móviles: sidebar flotante
            sidebar.style.position = 'fixed';
            sidebar.style.zIndex = '40';
            mainContent.style.marginLeft = '0';
            
            // Si estamos en móvil, mantener cerrado inicialmente
            if (sidebarOpen) {
                sidebar.style.transform = 'translateX(-100%)';
                sidebarOpen = false;
            }
        } else {
            // En escritorio: sidebar empuja el contenido
            sidebar.style.position = 'fixed';
            
            if (sidebarOpen) {
                mainContent.style.marginLeft = '16rem';
                sidebar.style.transform = 'translateX(0)';
            } else {
                mainContent.style.marginLeft = '0';
            }
        }
    }
    
    // Verificar al cargar
    checkScreenSize();
    
    // Verificar al cambiar tamaño de ventana
    window.addEventListener('resize', checkScreenSize);
};