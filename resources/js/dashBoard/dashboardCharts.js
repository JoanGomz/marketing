import { cardConversations } from './graficos/cardConversations.js';
import { cardEvents } from './graficos/cardEvents.js';
// Función de inicialización para todo el dashboard
function initDashboard() {
    if (document.getElementById("spark1")) {
        cardConversations();
    }
    if(document.getElementById("chart2")) {
        cardEvents();
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDashboard);
} else {
    initDashboard();
}