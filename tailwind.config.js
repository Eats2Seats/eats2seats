const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    mode: 'jit',

    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        screens: {
            'sm': '640px',
            'md': '768px',
            'lg': '1024px',
            'xl': '1280px',
            '2xl': '1536px',
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                serif: ['Lato', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                blueGray: colors.blueGray,
                amber: colors.amber,
                lime: colors.lime,
                emerald: colors.emerald,
                teal: colors.teal,
                cyan: colors.cyan,
                lightBlue: colors.lightBlue,
                indigo: colors.indigo,
                fuchsia: colors.fuchsia,
                rose: colors.rose,
            },
            backgroundImage: theme => ({
                deselect: 'url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' class=\'h-5 w-5\' viewBox=\'0 0 20 20\' fill=\'white\'%3E%3Cpath fill-rule=\'evenodd\' d=\'M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z\' clip-rule=\'evenodd\' /%3E%3C/svg%3E")',
            }),
        },
    },

    variants: {
        extend: {},
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],
};
