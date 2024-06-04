function loadPage(page) {
    const content = document.getElementById('content');
    fetch(page)
        .then(response => response.text())
        .then(html => {
            content.innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading page:', error);
        });
}

// Zorg ervoor dat de eerste pagina wordt geladen bij het starten van de site
window.addEventListener('DOMContentLoaded', () => {
    loadPage('home.html');
});
