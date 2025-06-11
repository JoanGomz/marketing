document.addEventListener("click", function(e) {
    if (e.target.classList.contains("open-eye") || e.target.classList.contains("close-eye")) {
        const container = e.target.closest('.relative'); // El div con class="relative"
        const input = container?.querySelector('.password');
        const openEye = container?.querySelector('.open-eye');
        const closeEye = container?.querySelector('.close-eye');
        
        if (input && openEye && closeEye) {
            if (e.target.classList.contains("open-eye")) {
                input.type = "text";
                openEye.style.display = "none";
                closeEye.style.display = "block";
            } else {
                input.type = "password";
                closeEye.style.display = "none";
                openEye.style.display = "block";
            }
        }
    }
});