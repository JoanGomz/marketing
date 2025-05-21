export default function () {
    const contenedor = document.getElementById("content-conversation");
    function smoothScrollToBottom() {
        if (contenedor) {
            contenedor.scrollTo({
                top: contenedor.scrollHeight,
                behavior: 'smooth'
            });
        }
    }
    async function consumirConversación(params) {
        try {
            let response = await fetch("/data/conversation.json");

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error("Error al cargar el JSON:", error);
            return null; // Devolver null o un objeto vacío en caso de error
        }
    }

    async function cargarConversacion() {
        let data = await consumirConversación();
        contenedor.innerHTML = ''; // Clear the container first

        data.conversation.forEach(item => {
            if (item.sender == "user") {
                contenedor.innerHTML += `
                    <!-- Mensaje del cliente --> 
                    <div class="mb-4 flex justify-start min-w-[400px]">
                        <div class="max-w-md rounded-lg p-4 bg-white border min-w-[400px] shadowCard">
                            <div>${item.message}</div>
                            <div class="text-xs mt-1 text-gray-500">09:30</div>
                        </div>
                    </div>
                `;
            } else {
                let menuHtml = '';
                // Check if menu exists and is an array
                if (item.menu && Array.isArray(item.menu) && item.menu.length > 0) {
                    // Create buttons for each menu option
                    menuHtml = '<div class="mt-2 border-t border-blue-300 pt-3">';
                    item.menu.forEach(menuItem => {
                        menuHtml += `
                            <div class="mt-2">
                                <button class="bg-[#0997AF] hover:bg-blue-600 text-white px-4 py-2 rounded-lg w-full text-left">${menuItem.title}</button>
                            </div>
                        `;
                    });
                    menuHtml += '</div>';
                }
                contenedor.innerHTML += `
                    <!-- Mensaje del asesor -->
                    <div class="mb-4 flex justify-end">
                        <div class="max-w-md rounded-lg p-4 bg-brand-blueStar text-white shadowCard">
                            <div>${item.message}</div>
                            <div class="text-xs mt-1 text-blue-100">09:40</div>
                            ${menuHtml}
                        </div>
                    </div>
                `;
            }
        });
        smoothScrollToBottom();
    }
    cargarConversacion();
}