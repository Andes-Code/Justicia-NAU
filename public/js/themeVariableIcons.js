document.addEventListener('DOMContentLoaded', () => {
    function getColorScheme() {
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }
    function updateImages() {
        const colorScheme = getColorScheme(); // Obtiene 'dark' o 'light'
        
        // Cambia el src de todas las imágenes con la clase .footer-img
        (document.querySelectorAll(".footer-img") || []).forEach((etiqueta) => {
            etiqueta.src = `images/icons/${colorScheme}/${etiqueta.dataset.target}.svg`; // Cambia el nombre de archivo según el tema
        });
    }

    // Llama a la función inicialmente
    updateImages();

    // Escucha los cambios en el esquema de color
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', updateImages);
})