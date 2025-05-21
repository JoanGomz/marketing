export default function () {
    let infoPanel = document.getElementById("Info-Panel");
    let button = document.getElementById("info-button");
    
    // Configurar estilos iniciales
    infoPanel.style.width = '300px';
    infoPanel.style.overflow = 'hidden';
    infoPanel.style.transition = 'width 0.3s ease-in-out';
    
    // Guardar el ancho original (si está definido en CSS)
    const originalWidth = '300px'; // O el ancho que necesites
    
    let isOpen = true;
    
    button.addEventListener("click", () => {
        if (!isOpen) {
            infoPanel.style.width = originalWidth;
            isOpen = true;
        } else {
            infoPanel.style.width = '0';
            isOpen = false;
        }
    });
};