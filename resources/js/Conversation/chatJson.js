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
    smoothScrollToBottom();
}