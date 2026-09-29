import './bootstrap';

/* =========================================================
   Pusat P2M Polibatam — public site interactions
   ========================================================= */

function initDateTime() {
    const dateText = document.getElementById('top-date-text');
    const dateTime = document.getElementById('top-date-time');

    if (!dateText || !dateTime) return;

    const update = () => {
        const now = new Date();
        dateText.textContent = now.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        });
        dateTime.textContent = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false,
        });
    };

    update();
    setInterval(update, 1000);
}

function initSearchToggle() {
    const toggle = document.getElementById('search-toggle');
    const panel = document.getElementById('search-panel');
    const input = document.getElementById('global-search-input');
    const close = document.getElementById('search-close');

    if (!toggle || !panel || !input) return;

    const isOpen = () => !panel.hasAttribute('hidden');

    const open = () => {
        panel.removeAttribute('hidden');
        toggle.setAttribute('aria-expanded', 'true');
        window.requestAnimationFrame(() => input.focus());
    };

    const shut = () => {
        panel.setAttribute('hidden', 'hidden');
        toggle.setAttribute('aria-expanded', 'false');
    };

    toggle.addEventListener('click', () => (isOpen() ? shut() : open()));

    close?.addEventListener('click', shut);

    input.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') shut();
    });
}

function initTabs() {
    const links = document.querySelectorAll('[data-tab]');
    const panes = document.querySelectorAll('[data-panel]');

    if (!links.length || !panes.length) return;

    links.forEach((link) => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const target = link.dataset.tab;

            links.forEach((item) => item.classList.toggle('active', item === link));

            panes.forEach((pane) => {
                const active = pane.dataset.panel === target;
                pane.classList.toggle('active', active);
                pane.classList.toggle('show', active);
                pane.hidden = !active;
            });
        });
    });
}

function initSlider() {
    const slider = document.querySelector('[data-slider]');
    if (!slider) return;

    const slides = Array.from(slider.querySelectorAll('[data-slide]'));
    if (slides.length < 2) return;

    let index = 0;
    let timer = null;

    const show = (next) => {
        index = (next + slides.length) % slides.length;
        slides.forEach((slide, i) => slide.classList.toggle('active', i === index));
    };

    const restart = () => {
        clearInterval(timer);
        timer = setInterval(() => show(index + 1), 5000);
    };

    slider.querySelectorAll('[data-slide-prev]').forEach((button) => {
        button.addEventListener('click', () => {
            show(index - 1);
            restart();
        });
    });

    slider.querySelectorAll('[data-slide-next]').forEach((button) => {
        button.addEventListener('click', () => {
            show(index + 1);
            restart();
        });
    });

    slider.addEventListener('mouseenter', () => clearInterval(timer));
    slider.addEventListener('mouseleave', restart);

    show(0);
    restart();
}

function initBackToTop() {
    document.querySelectorAll('[data-back-to-top]').forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
}

function initProfileDropdown() {
    const dropdown = document.querySelector('.nav-dropdown');
    if (!dropdown) return;

    const trigger = dropdown.querySelector('.profile-trigger');
    const submenu = dropdown.querySelector('.nav-submenu');

    if (!trigger || !submenu) return;

    const isOpen = () => !submenu.hasAttribute('hidden');

    const open = () => {
        submenu.removeAttribute('hidden');
        dropdown.classList.add('open');
        trigger.setAttribute('aria-expanded', 'true');
    };

    const close = () => {
        submenu.setAttribute('hidden', 'hidden');
        dropdown.classList.remove('open');
        trigger.setAttribute('aria-expanded', 'false');
    };

    trigger.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
        isOpen() ? close() : open();
    });

    // Click-away and Escape both dismiss it.
    document.addEventListener('click', (event) => {
        if (!dropdown.contains(event.target)) close();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') close();
    });

    // Pointer users expect hover to open it, as on the live site.
    dropdown.addEventListener('mouseenter', open);
    dropdown.addEventListener('mouseleave', close);
}

const boot = () => {
    initDateTime();
    initSearchToggle();
    initProfileDropdown();
    initTabs();
    initSlider();
    initBackToTop();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
} else {
    boot();
}
