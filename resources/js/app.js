// app.js - Versión Optimizada
import './bootstrap';
import '../css/app.css';
// Importar componentes web
import myLoading from './WebComponents/My-Loading.js';

// Registro de componentes web
customElements.define("nocard-loading", myLoading);
import('./slidebarDashboard.js').then(module => {
    module.default();
});
if (window.location.pathname.includes('/parques')) {
    import('./cardSearch.js').then(module => {
        module.default();
    });
}

// Registro global del evento ANTES de cargar módulos
document.addEventListener('livewire:init', () => {
    Livewire.on('smoothScrollToBottom', (event) => {
        const contenedor = document.getElementById("content-conversation");

        if (contenedor) {
            setTimeout(() => {
                contenedor.scrollTo({
                    top: contenedor.scrollHeight,
                    behavior: 'auto'
                });
            }, 1000);
        }
    });
});
document.addEventListener('livewire:init', () => {
    // Resetear scroll cuando empiece a cargar
    Livewire.hook('morph.updating', () => {
        const container = document.getElementById('content-conversation');
        if (container) {
            container.scrollTop = 0;
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    if (window.location.pathname.includes('/conversaciones')) {
        import('./Conversation/whatsappJson.js').then(module => {
            module.default();

            // Después cargamos conversationSearch.js
            // import('Conversation/conversationSearch.js').then(module => {
            //     module.default();
            // });
        });
        import('./Conversation/info-client.js').then(module => {
            module.default();
        });
        import('./Conversation/chatJson.js').then(module => {
            module.default();
        });
    }
});

document.addEventListener('alpine:init', () => {
    Alpine.store('forms', {
        createFormVisible: false,
        updateFormVisible: false,

        showCreateForm() {
            this.createFormVisible = true;
            this.updateFormVisible = false;
        },
        hideCreateForm() {
            this.createFormVisible = false;
        },

        showUpdateForm() {
            this.updateFormVisible = true;
            this.createFormVisible = false;
        },
        hideUpdateForm() {
            this.updateFormVisible = false;
        },

        hideAllForms() {
            this.createFormVisible = false;
            this.updateFormVisible = false;
        }
    });
});