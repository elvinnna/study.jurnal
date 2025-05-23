// theme.js
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('theme-toggle');

    if (!toggleBtn) return;

    // Cek tema dari localStorage
    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark-mode');
        toggleBtn.textContent = '🌞 Mode Terang';
    }

    toggleBtn.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');

        let theme = 'light';
        if (document.body.classList.contains('dark-mode')) {
            theme = 'dark';
            toggleBtn.textContent = '🌞 Mode Terang';
        } else {
            toggleBtn.textContent = '🌙 Mode Gelap';
        }

        localStorage.setItem('theme', theme);
    });
});
