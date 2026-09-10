import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/Livewire/**/*.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#16a34a',
                secondary: '#2563eb',
                darkBlue: '#05070a',
                bedasGreen: '#1bb55c',
                bedasLime: '#8ed500',
                jerseyPurple: '#a855f7',
                jerseyMagenta: '#d946ef'
            }
        },
    },
    plugins: [],
};
