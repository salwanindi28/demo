document.addEventListener('DOMContentLoaded', () => {
    // Dropdown profil (berisi tombol Keluar)
    const toggle = document.getElementById('profileToggle');
    const menu = document.getElementById('profileDropdown');
    if (toggle && menu) {
        toggle.addEventListener('click', e => {
            e.stopPropagation();
            const open = menu.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        document.addEventListener('click', e => {
            if (!menu.contains(e.target)) {
                menu.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
    }
});
