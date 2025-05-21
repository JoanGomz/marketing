export default function () {
    const conversations = document.getElementById("conversaciones");
    
    async function consumirData() {
        try {
            const response = await fetch("/data/chat.json");
            
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error("Error al cargar el JSON:", error);
            return null;
        }
    }

    async function consumirLastConversation() {
        try {
            const response = await fetch("/data/prueba.json");
            
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error("Error al cargar el JSON:", error);
            return null;
        }
    }

    async function crearTabla() {
        const data = await consumirData();
        const lastData = await consumirLastConversation();
        
        if (!data) {
            conversations.innerHTML = "<p>Error al cargar los datos</p>";
            return;
        }

        const opciones = ["Pendiente", "Asignado", "En espera"];
        
        // Definir colores para cada estado
        const colorMap = {
            "Pendiente": {
                dot: "bg-yellow-500",
                text: "text-yellow-700"
            },
            "Asignado": {
                dot: "bg-green-500",
                text: "text-green-700"
            },
            "En espera": {
                dot: "bg-blue-500",
                text: "text-blue-700"
            }
        };
        
        // Limpiar el contenedor antes de agregar nuevos elementos
        conversations.innerHTML = '';
        
        let conversationsHTML = "";
        
        // Generar HTML para los clientes
        data.customers.forEach((element) => {
            const opcion = opciones[Math.floor(Math.random() * opciones.length)];
            const cantMensajes = Math.floor(Math.random() * 10);
            
            // Obtener colores del mapa según el estado
            const dotColor = colorMap[opcion]?.dot || "bg-gray-500";
            const textColor = colorMap[opcion]?.text || "text-gray-500";
            
            conversationsHTML += `
                <div class="chat-item p-4 border-b hover:bg-gray-50 cursor-pointer" data-status="${opcion.toLowerCase()}">
                    <div class="flex justify-between items-start mb-1">
                        <div class="font-bold">${element.name}</div>
                        <div class="text-xs text-gray-500">${new Date(element.last_message * 1000).toLocaleString()}</div>
                    </div>
                    <div class="text-xs text-gray-600 mb-2 truncate">${element.last_message_content}</div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="w-2 h-2 rounded-full ${dotColor} mr-2"></span>
                            <span class="status-text text-xs ${textColor}">${opcion}</span>
                        </div>
                        <span class="bg-brand-redStar text-white text-xs rounded-md w-5 h-5 items-center justify-center ${cantMensajes === 0 ? 'hidden' : 'flex'}">
                            ${cantMensajes}
                        </span>
                    </div>
                </div>
            `;
        });
    
        if (lastData && lastData.customer) {
            const opcion = opciones[Math.floor(Math.random() * opciones.length)];
            const cantMensajes = Math.floor(Math.random() * 10);
            
            // Obtener colores del mapa según el estado
            const dotColor = colorMap[opcion]?.dot || "bg-gray-500";
            const textColor = colorMap[opcion]?.text || "text-gray-500";
            
            conversationsHTML += `
                <div class="chat-item p-4 border-b hover:bg-gray-50 cursor-pointer" data-status="${opcion.toLowerCase()}">
                    <div class="flex justify-between items-start mb-1">
                        <div class="font-bold">${lastData.customer.name}</div>
                        <div class="text-xs text-gray-500">${new Date().toLocaleString()}</div>
                    </div>
                    <div class="text-xs text-gray-600 mb-2 truncate">${lastData.text}</div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="w-2 h-2 rounded-full ${dotColor} mr-2"></span>
                            <span class="status-text text-xs ${textColor}">${opcion}</span>
                        </div>
                        <span class="bg-brand-redStar text-white text-xs rounded-md w-5 h-5 items-center justify-center ${cantMensajes === 0 ? 'hidden' : 'flex'}">
                            ${cantMensajes}
                        </span>
                    </div>
                </div>
            `;
        }
        
        // Actualizar el DOM una sola vez
        conversations.innerHTML = conversationsHTML;
    }
    
    // Iniciar el proceso
    crearTabla();
}