import { cardUsers } from './graficos/cardUsers.js';
import { cardConversations } from './graficos/cardConversations.js';

// Función de inicialización para todo el dashboard
function initDashboard() {
    if (document.getElementById("spark1")) {
        cardUsers();
    }
    if (document.getElementById("spark2")) {
        cardConversations();
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDashboard);
} else {
    initDashboard();
}