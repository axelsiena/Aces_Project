let themeButton = document.getElementById('theme-button');

// Carica il tema preferito dal localStorage al caricamento della pagina
document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        applyTheme(savedTheme);
    } else {
        // Se non c'è un tema salvato, controlla le preferenze del sistema
        const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyTheme(prefersDarkMode ? 'dark' : 'light');
    }
});

themeButton.addEventListener('click', () => {
    const currentTheme = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
    
    // Salva il tema preferito nel localStorage
    localStorage.setItem('theme', currentTheme);
    
    applyTheme(currentTheme);
});

function applyTheme(theme) {
    if (theme === 'dark') {
        document.documentElement.setAttribute('data-bs-theme', 'dark');
        themeButton.classList.add('fa-moon');
        themeButton.classList.remove('fa-sun');
    } else {
        document.documentElement.setAttribute('data-bs-theme', '');
        themeButton.classList.remove('fa-moon');
        themeButton.classList.add('fa-sun');
    }
}

