import './bootstrap';
import { createIcons, icons } from 'lucide';

window.createLucideIcons = () => createIcons({ icons });

// Reusable & Batched Icon Initializer
let iconInitQueued = false;
const initIcons = () => {
    if (iconInitQueued) return;
    iconInitQueued = true;
    requestAnimationFrame(() => {
        iconInitQueued = false;
        try {
            createIcons({ icons });
        } catch (e) {
            console.warn('Lucide icon init warning:', e);
        }
    });
};

// 1. Initial DOM and Livewire SPA Lifecycle Hooks
document.addEventListener('DOMContentLoaded', () => {
    initIcons();
});

// 2. Livewire 3 SPA Navigation Hooks (wire:navigate)
document.addEventListener('livewire:navigating', () => {
    // Optional prep
});

document.addEventListener('livewire:navigated', () => {
    initIcons();
    
    // Auto scroll handling for SPA navigation
    if (window.location.hash) {
        const target = document.querySelector(window.location.hash);
        if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
        }
    } else {
        window.scrollTo({ top: 0, behavior: 'instant' });
    }
});

// 3. Livewire Morph & Commit Hooks
document.addEventListener('livewire:initialized', () => {
    initIcons();

    Livewire.hook('commit', ({ succeed }) => {
        succeed(() => {
            initIcons();
        });
    });

    // Graceful Handling for Page Expired / Session Refresh in SPA
    Livewire.hook('request', ({ fail }) => {
        fail(({ status, preventDefault }) => {
            if (status === 419) {
                preventDefault();
                window.location.reload();
            }
        });
    });
});

