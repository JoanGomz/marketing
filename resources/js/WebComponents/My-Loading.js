export default class myLoading extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({ mode: "open" });

        // Bind methods to this instance
        this.handleLinkClick = this.handleLinkClick.bind(this);
    }
    getTemplate() {
        const template = document.createElement("template");
        template.innerHTML = `
            <div id="route-loading-indicator" class="loading-container">
                <div class="loading-content">
                    <img class="brand-name" src="/Images/Logos/3.webp" alt="Logo de NoCard" />
                    <div class="lds-ripple">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            ${this.getStyles()}
        `;
        return template;
    }
    getStyles() {
        return `
            <style>
                /* Contenedor principal - reemplaza las clases de Tailwind */
                .loading-container {
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background-color: rgba(243, 244, 246, 0.9); /* bg-gray-100/90 */
                    z-index: 50;
                    display: none; /* hidden por defecto */
                }

                /* Media query para replicar las clases lg: de Tailwind */
                @media (min-width: 1024px) {
                    .loading-container {
                        top: 4rem; /* lg:top-16 (4rem = 64px) */
                        left: "16rem";
                    }
                }

                /* Contenedor del contenido */
                .loading-content {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    text-align: center;
                }

                /* Texto de la marca */
                .brand-name {
                    width: 6rem; 
                    margin-bottom: 0.5rem; /* mb-2 */
                }

                /* Animación de carga (con colores de NoCard) */
                .lds-ripple {
                    display: inline-block;
                    position: relative;
                    width: 80px;
                    height: 80px;
                    margin-top: 0.75rem; /* mt-3 */
                    margin-left: auto;
                    margin-right: auto;
                }

                .lds-ripple div {
                    position: absolute;
                    opacity: 1;
                    border-radius: 50%;
                    animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
                }

                .lds-ripple div:nth-child(1) {
                    border: 4px solid #00FFFF; /* Color turquesa */
                }

                .lds-ripple div:nth-child(2) {
                    border: 4px solid #581c94; /* Color morado */
                    animation-delay: -0.5s;
                }

                @keyframes lds-ripple {
                    0% {
                        top: 36px;
                        left: 36px;
                        width: 0;
                        height: 0;
                        opacity: 0;
                    }
                    4.9% {
                        top: 36px;
                        left: 36px;
                        width: 0;
                        height: 0;
                        opacity: 0;
                    }
                    5% {
                        top: 36px;
                        left: 36px;
                        width: 0;
                        height: 0;
                        opacity: 1;
                    }
                    100% {
                        top: 0px;
                        left: 0px;
                        width: 72px;
                        height: 72px;
                        opacity: 0;
                    }
                }
            </style>
        `;
    }

    /**
     * Maneja los clics en enlaces para mostrar automáticamente el indicador de carga
     * @param {Event} e - El evento de clic
     */
    handleLinkClick(e) {
        // Verificar si es un enlace que cambia de página
        if (e.target.tagName === 'A' || e.target.closest('a')) {
            const link = e.target.tagName === 'A' ? e.target : e.target.closest('a');
            const href = link.getAttribute('href');

            // Si es un enlace interno (no contiene # o javascript:)
            if (href && !href.startsWith('#') && !href.startsWith('javascript:') && !link.getAttribute('target')) {
                this.show();
            }
        }
    }

    render() {
        this.shadowRoot.appendChild(this.getTemplate().content.cloneNode(true));
        this.loadingIndicator = this.shadowRoot.getElementById('route-loading-indicator');
    }

    /**
     * Muestra el indicador de carga
     */
    show() {
        this.loadingIndicator.style.display = 'flex';
    }

    /**
     * Oculta el indicador de carga
     */
    hide() {
        this.loadingIndicator.style.display = 'none';
    }
    setLeftPosition(leftPosition) {
        this.loadingIndicator.style.left = leftPosition;
    }

    slideBarClose() {
        this.setLeftPosition('0');
    }
    slideBarOpen() {
        this.setLeftPosition("16rem");
    }
    /**
     * Activa la detección automática de clics en enlaces
     */
    enableAutoDetection() {
        document.addEventListener('click', this.handleLinkClick);
    }

    /**
     * Desactiva la detección automática de clics en enlaces
     */
    disableAutoDetection() {
        document.removeEventListener('click', this.handleLinkClick);
    }

    /**
     * Lifecycle callback cuando el elemento se conecta al DOM
     */
    connectedCallback() {
        this.render();
        this.enableAutoDetection();
    }

    /**
     * Lifecycle callback cuando el elemento se desconecta del DOM
     */
    disconnectedCallback() {
        this.disableAutoDetection();
    }
}