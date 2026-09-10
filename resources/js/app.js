import '../css/app.css';
import './bootstrap';
import { createIcons, icons } from 'lucide';

window.createLucideIcons = () => {
    try {
        createIcons({ icons });
    } catch (e) {
        // Safe catch
    }
};

let initTimer = null;
const initIcons = () => {
    clearTimeout(initTimer);
    initTimer = setTimeout(() => {
        window.createLucideIcons();
    }, 50);
};

// 1. Initial DOM & Livewire SPA Navigation Hooks
document.addEventListener('DOMContentLoaded', initIcons);
document.addEventListener('livewire:navigated', () => {
    initIcons();
    if (window.location.hash) {
        const target = document.querySelector(window.location.hash);
        if (target) target.scrollIntoView({ behavior: 'smooth' });
    }
});

// 2. Livewire 3 Morph & Commit Hooks
document.addEventListener('livewire:initialized', () => {
    initIcons();

    Livewire.hook('commit', ({ succeed }) => {
        succeed(() => {
            initIcons();
        });
    });

    // Prevent automatic reload loops and default alert dialogs on temporary request failures
    Livewire.hook('request', ({ fail }) => {
        fail(({ status, preventDefault }) => {
            if (status === 419) {
                preventDefault(); // Suppress the default Livewire "Page Expired" alert dialog
                console.warn('[Livewire] Sesi / CSRF token 419 diabaikan agar input tidak terganggu.');
            }
        });
    });
});


