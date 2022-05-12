const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    important: true,
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './app/Models/*.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                'svg-call': "url('/images/svg/call.svg')",
                'astronaut': "url('/images/astronaut.webp')",
            }
        },
    },
    
    plugins: [require('@tailwindcss/forms')],
    // prefix: 'tw-',
};
