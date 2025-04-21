document.addEventListener('DOMContentLoaded', () => {
    var boton = document.getElementById('boc');
    if (boton) {
        boton.addEventListener('click', function(){
            alert('Enviamos un mensaje a tu correo para que puedas recuperar contraseña');
        });
    }

    const searchInput = document.getElementById('searchInput');
    const searchContainer = document.querySelector('.search-container');
    const resultsContainer = document.getElementById('resultsContainer');
    const noResults = document.getElementById('noResults');
    const searchCards = document.querySelectorAll('.search-card');

    if (searchInput && searchContainer && resultsContainer && noResults && searchCards.length > 0) {
        // Mostrar resultados al hacer clic en el input
        searchInput.addEventListener('focus', () => {
            resultsContainer.classList.remove('hidden');
            doSearch();
        });

        // Ocultar resultados al hacer clic fuera
        document.addEventListener('click', (e) => {
            if (!searchContainer.contains(e.target)) {
                resultsContainer.classList.add('hidden');
                noResults.classList.add('hidden');
            }
        });

        // Función de búsqueda
        const doSearch = () => {
            const searchTerm = searchInput.value.trim().toLowerCase();
            let visibleItems = 0;

            searchCards.forEach(card => {
                const text = card.textContent.toLowerCase();
                if(text.includes(searchTerm)) {
                    card.classList.remove('hidden');
                    visibleItems++;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Mostrar u ocultar mensaje de no resultados
            if(visibleItems === 0 && searchTerm !== '') {
                noResults.classList.remove('hidden');
                resultsContainer.classList.add('hidden');
            } else {
                noResults.classList.add('hidden');
                resultsContainer.classList.remove('hidden');
            }
        };

        // Escuchar entrada de búsqueda
        searchInput.addEventListener('input', doSearch);
    }
});

function vercontra(id, element) {
    const passwordInput = document.getElementById(id);
    const passwordType = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', passwordType);
    // Cambiar el símbolo de la lectura de la contraseña
    element.textContent = passwordType === 'password' ? '👁️‍🗨️' : '👀';
}